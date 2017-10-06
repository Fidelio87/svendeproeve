<?php

if (isset($_GET['id']) && (int)$_GET['id']) {
    $id = $_GET['id'];
} else {
    redirect_to($_SERVER['HTTP_REFERER']);
}

$query  = 'SELECT bruger_id, bruger_brugernavn, bruger_beskrivelse, bruger_img
              FROM brugere 
              WHERE bruger_status = 1 AND bruger_id = ' . $id;
$result = $db->query($query);
$row = $result->fetch_object();


?>

<form action="" method="post" enctype="multipart/form-data" autocomplete="off">

<?php

$bruger_id      = $row->bruger_id;
$brugernavn     = $row->bruger_brugernavn;
$beskrivelse    = $row->bruger_beskrivelse;
$img            = $row->bruger_img;

if (isset($_POST['rediger_profil'])) {
    $img = $_FILES['img'];

    if (empty($_POST['beskrivelse'])) {
        $beskrivelse = '';
    } else {
        $beskrivelse = $db->real_escape_string($_POST['beskrivelse']);
    }

    if (isset($img) && !empty($img['tmp_name'])) {
        $query_gl_img  = 'SELECT bruger_id, bruger_img FROM brugere WHERE bruger_id = ' . $id;
        $result_gl_img = $db->query($query_gl_img);
        $row_gl = $result_gl_img->fetch_object();

        if (!$result_gl_img) {
            query_error($query_gl_img, __LINE__, __FILE__);
        }

        if (file_exists('img/brugere/' . $row_gl->bruger_img) &&
            file_exists('img/brugere/thumbs/' . $row_gl->bruger_img)) {
            unlink('img/brugere/' . $row_gl->bruger_img);
            unlink('img/brugere/thumbs/' . $row_gl->bruger_img);
        }

        //bliver brugt i queryen
        $filnavn = time() . '_' . $db->real_escape_string($img['name']);

        $img_sql = ', bruger_img = "' . $filnavn . '"';

        $img = $manager->make($img['tmp_name']);

        //gemmer alm billede
        //gemmer alm billede
        $img->resize(768, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save('img/brugere/' . $filnavn);

        //gemmer thumbnail billede
        $img->resize(88, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save('img/brugere/thumbs' . $filnavn);
    } else {
        $img_sql = '';
    }

    $query = "UPDATE brugere SET bruger_beskrivelse = '$beskrivelse'
                                $img_sql
                  WHERE bruger_id = $id";
    $result = $db->query($query);

    if (!$result) { query_error($query, __LINE__, __FILE__); }

    if ($db->affected_rows >= 1) {
        alert('success', 'Dine ændringer blev gemt');
        set_log('opdater', 'Profilen blev redigeret', $id);
    } else {
        alert('warning', 'Ups, noget gik galt');
    }
}

?>

    <div class="form-group">
        <label for="inputName" class="control-label">Brugernavn</label>
        <input disabled class="form-control" placeholder="<?php echo $brugernavn; ?>">
    </div>
    <div class="form-group">
        <label for="inputDesc" class="control-label">Beskrivelse</label>
        <textarea name="beskrivelse" id="ck_indhold" class="form-control "><?php echo $beskrivelse; ?></textarea>
    </div>
    <div class="media">
        <img class="img-responsive" src="img/brugere/<?php echo $row->bruger_img; ?>">
        <div class="media-body">
            <h4 class="media-heading"></h4>
            Nuværende billede
        </div>
    </div>
    <div class="form-group">
        <label for="billede" class="control-label">Udskift billede</label>
        <input type="file" name="img" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
        <button name="rediger_profil" type="submit" class="btn btn-warning">
            <i class="fa fa-floppy-o fa-fw"></i> Gem ændringer
        </button>
    </div>
</form>
