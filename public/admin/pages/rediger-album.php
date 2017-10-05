<?php

checkAccess();

if (isset($_GET['id']) && (int)$_GET['id']) {
    $album_id = $_GET['id'];
}

$query  = 'SELECT album_id,
                  album_kunstner,
                  album_titel,
                  album_img,
                  fk_genre_id,
                  fk_pris_id
              FROM albums 
              WHERE album_id = ' . $album_id;
$result = $db->query($query);
$row = $result->fetch_object();

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
    <small> Rediger album</small>
</h1>

<form method="post" action="" enctype="multipart/form-data">

    <?php

    $album_id   = $row->album_id;
    $kunstner   = $row->album_kunstner;
    $titel      = $row->album_titel;
    $img        = $row->album_img;
    $genre      = $row->fk_genre_id;
    $pris       = $row->fk_pris_id;

    if (isset($_POST['rediger_album'])) {
        $kunstner   = $db->real_escape_string($_POST['kunstner']);
        $titel      = $db->real_escape_string($_POST['titel']);
        $genre      = $db->real_escape_string($_POST['genre']);
        $pris       = $db->real_escape_string($_POST['pris']);

        rediger_album($album_id, $kunstner, $titel, $_FILES['img'], $genre, $pris);

        // TODO fix image staying in cache
        redirect_to('index.php?page=albums');
    }

    ?>

    <div class="form-group">
        <label for="inputName" class="control-label">Kunstner</label>
        <input name="kunstner" class="form-control" value="<?php echo $kunstner; ?>">
    </div>
    <div class="form-group">
        <label for="titel" class="control-label">Titel</label>
        <input name="titel" class="form-control" value="<?php echo $titel; ?>">
    </div>
    <!--    IMAGE-->
    <div class="media">
            <img class="img-responsive" src="../img/albums/<?php echo $row->album_img; ?>"">
        <div class="media-body">
            <h4 class="media-heading"></h4>
            Nuværende billede
        </div>
    </div>

    <div class="form-group">
        <label for="billede" class="control-label">Upload billede</label>
        <input type="file" name="img" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
        <label for="genre" class="control-label">Genre</label>
        <select name="genre" id="genre" class="form-control">
            <?php

            $query  = 'SELECT * FROM genrer ORDER BY genre_navn';
            $result = $db->query($query);
            if (!$result) {
                query_error($query, __LINE__, __FILE__);
            }

            while ($row = $result->fetch_object()) {
                ?>
                <option <?php if ($row->genre_id === $genre) { echo 'selected'; } ?> value="<?php echo $row->genre_id; ?>"><?php echo $row->genre_navn; ?></option>
                <?php
            }

            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="pris" class="control-label">Pris</label>
        <select name="pris" id="pris" class="form-control">
            <?php

            $query  = 'SELECT * FROM priser ORDER BY vaerdi';
            $result = $db->query($query);
            if (!$result) {
                query_error($query, __LINE__, __FILE__);
            }

            while ($row = $result->fetch_object()) {
                ?>
                <option <?php if ($row->id === $pris) { echo 'selected'; } ?> value="<?php echo $row->id; ?>"><?php echo $row->vaerdi; ?></option>
                <?php
            }

            ?>

        </select>
    </div>

    <div class="form-group">
        <div class="btn-group">
            <button name="rediger_album" class="btn btn-primary">
                <i class="fa fa-floppy-o fa-fw"></i> Rediger
            </button>
        </div>
    </div>
</form>