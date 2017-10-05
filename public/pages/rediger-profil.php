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

$bruger_id          = $row->bruger_id;
$brugernavn          = $row->bruger_brugernavn;
$beskrivelse        = $row->bruger_beskrivelse;

if (isset($_POST['rediger_bruger'])) {

    $beskrivelse = $db->real_escape_string($_POST['beskrivelse']);
    $fil = $_FILES['img'];


    if (file_exists('../img/albums/' . $row_gl->album_img) &&
        file_exists('../img/albums/thumbs' . $row_gl->album_img)) {
        unlink($img_dir . $row_gl->album_img);
        unlink($img_dir_thumbs . $row_gl->album_img);
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
