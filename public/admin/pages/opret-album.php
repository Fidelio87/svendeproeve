<?php

checkAccess();



?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
    <small> Opret nyt album</small>
</h1>

<form method="post" action="" enctype="multipart/form-data">
    <?php
    $kunstner           = '';
    $titel              = '';


    if (isset($_POST['opret_album'])) {
        $kunstner         = $db->real_escape_string($_POST['kunstner']);
        $titel            = $db->real_escape_string($_POST['titel']);

        opret_album($kunstner, $titel, $_FILES['img'], $_POST['genre'], $_POST['pris']);

    }

    ?>

    <div class="form-group">
        <label for="inputName" class="control-label">Kunstner</label>
        <input name="kunstner" class="form-control" value="<?php echo $kunstner; ?>" autofocus required>
    </div>
    <div class="form-group">
        <label for="titel" class="control-label">Titel</label>
        <input name="titel" class="form-control" value="<?php echo $titel; ?>" required>
    </div>
    <!--    IMAGE-->
    <div class="form-group">
        <label for="billede" class="control-label">Upload billede</label>
        <input type="file" name="img" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
        <label for="genre" class="control-label">Genre</label>
        <select name="genre" id="genre" class="form-control" required>
            <option value="">Vælg genre</option>
            <?php

            $query  = 'SELECT * FROM genrer ORDER BY genre_navn';
            $result = $db->query($query);
            if (!$result) {
                query_error($query, __LINE__, __FILE__);
            }
            
            while ($row = $result->fetch_object()) {
                ?>
                <option value="<?php echo $row->genre_id; ?>"><?php echo $row->genre_navn; ?></option>
                <?php
            }
            
            ?>
            
        </select>
    </div>

    <div class="form-group">
        <label for="pris" class="control-label">Pris</label>
        <select name="pris" id="pris" class="form-control" required>
            <option value="">Vælg pris</option>
            <?php

            $query  = 'SELECT * FROM priser ORDER BY vaerdi';
            $result = $db->query($query);
            if (!$result) {
                query_error($query, __LINE__, __FILE__);
            }

            while ($row = $result->fetch_object()) {
                ?>
                <option value="<?php echo $row->id; ?>"><?php echo $row->vaerdi; ?></option>
                <?php
            }

            ?>

        </select>
    </div>
    

    <div class="form-group">
        <div class="btn-group">
            <button type="reset" name="ryd" class="btn btn-default">
                <i class="fa fa-undo fa-fw"></i> Ryd
            </button>
            <button name="opret_album" class="btn btn-primary">
                <i class="fa fa-check-circle fa-fw"></i> Opret album
            </button>
        </div>
    </div>

</form>