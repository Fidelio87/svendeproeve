<?php


checkAccess();

if (isset($_GET['slet_id'])) {
    $id = (int)$_GET['slet_id'];
//    $query = 'DELETE FROM transaktioner WHERE fk_album_id = ' . $id;
//    $db->query($query);

    $query = 'SELECT album_id, album_img FROM albums WHERE album_id = ' . $id;
    $result = $db->query($query);
    $row = $result->fetch_object();
        //hvis der er billeder tilknyttet albummet, slettes de
    if (isset($row->album_img)) {
        unlink('../img/albums/' . $row->album_img);
        unlink('../img/albums/thumbs/' . $row->album_img);
    }

    $query = 'DELETE FROM albums WHERE album_id = ' . $id;
    $db->query($query);

    set_log('slet', 'Et album blev slettet');

    redirect_to('index.php?page='.$side);
}

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
</h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th align="right"><i class="fa fa-sort-numeric-desc fa-fw"></i> Oprettet</th>
            <th>Kunstner</th>
            <th>Titel</th>
            <th>Cover</th>
            <th>Genre</th>
            <th>Pris</th>
            <th class="icon"></th>
            <th class="icon"></th>
            <th class="icon"><a href="index.php?page=opret-album" class="btn btn-success btn-xs"
                                title="Opret nyt album"><i class="fa fa-plus-square fa-lg fa-fw"></i></a></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "
                    SELECT 
                        album_id,
                        DATE_FORMAT(album_oprettet, '%e. %b %Y [%H:%i]') AS album_oprettet_dato,
                        album_kunstner,
                        album_titel,
                        album_img,
                        genre_navn,
                        vaerdi
                    FROM albums
                    INNER JOIN genrer ON albums.fk_genre_id = genrer.genre_id
                    INNER JOIN priser ON albums.fk_pris_id = priser.id
                    ORDER BY album_oprettet DESC";
        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }


        $antal_album = $result->num_rows;
        if ($antal_album > 0) {
            while ($album = $result->fetch_object()) {
                ?>
                <tr id="<?php echo $album->album_id; ?>">
                    <td align="right"><?php echo $album->album_oprettet_dato; ?></td>
                    <td><?php echo $album->album_kunstner; ?></td>
                    <td><p class="small"><?php echo $album->album_titel; ?></p></td>
                    <td><img src="../img/albums/thumbs/<?php echo $album->album_img; ?>" alt="billede af <?php
                        echo $album->album_titel; ?>" class="img img-rounded"></td>
                    <td><?php echo $album->genre_navn; ?></td>
                    <td><?php echo $album->vaerdi; ?></td>
                    <td></td>
                    <td><a href="index.php?page=rediger-album&id=<?php echo $album->album_id; ?>"
                           class="btn btn-warning btn-xs" title="Rediger album">
                            <i class="fa fa-edit fa-lg fa-fw"></i></a></td>
                    <td><a href="index.php?page=<?php echo $side; ?>&slet_id=<?php echo $album->album_id; ?>"
                           class="btn btn-danger btn-xs" onClick="return confirm('Er du sikker på du vil slette albummet?')"
                           title="Slet album"><i class="fa fa-trash-o fa-lg fa-fw"></i></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="12">Der blev ikke fundet nogle albums</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

