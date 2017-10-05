<?php

if (isset($_GET['sort'])) {
    $sort= $db->real_escape_string($_GET['sort']);
} else {
    $sort = '';
}



$albums_pr_side = 5;

$nuv_side = 1;

if (isset($_GET['side_nr']) && (int)$_GET['side_nr']) {
    $nuv_side = (int)$_GET['side_nr'];
}

$query_count = 'SELECT COUNT(album_id) AS antal FROM albums';
$result_count = $db->query($query_count);
if (!$result_count) { query_error($query_count, __LINE__, __FILE__); }

$row_count = $result_count->fetch_object();
$album_antal = $row_count->antal;
$total_albums = ceil($album_antal/$albums_pr_side);

$offset = ($nuv_side - 1) * $albums_pr_side;

?>

    <div class="row text-center">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
            <span>Sorter efter</span>
            <ul class="nav nav-pills">
                <li class="presentation">
                    <a href="index.php?page=<?php echo $side_url;?><?php if (isset($_GET['side_nr'])) {
                        echo '&side_nr' . $_GET['side_nr'];
                    } ?>&sort=1">Test</a>
                </li>
            </ul>
        </div>
    </div>

<?php




$query  = 'SELECT   album_id, 
                    album_kunstner, 
                    album_titel, 
                    album_img, 
                    fk_genre_id, 
                    fk_pris_id,
                    genre_navn,
                    vaerdi
          FROM albums 
          INNER JOIN priser ON albums.fk_pris_id = priser.id
          INNER JOIN genrer ON albums.fk_genre_id = genrer.genre_id
          ORDER BY album_titel
          LIMIT ' . $albums_pr_side . ' OFFSET ' . $offset;
$result = $db->query($query);

if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

while ($row = $result->fetch_object()) {
    ?>
    <div class="col-sm-6 col-md-4" id="album-box">
        <div class="thumbnail album-thmb">
            <img src="img/albums/thumbs/<?php echo $row->album_img; ?>" class="img-responsive" alt="<?php
            echo $row->album_titel; ?>">
            <div class="caption">
                <h3><?php echo $row->album_titel; ?></h3>
                <p><?php echo $row->album_kunstner; ?></p>
                <p><a href="#" class="btn btn-primary" role="button">Button</a>
                    <a href="#" class="btn btn-default" role="button">Button</a></p>
            </div>
        </div>
    </div>
<?php
}
?>
<div class="clearfix"></div>
<div class="row">
    <ul class="pagination pagination-sm">
        <?php


        for ($i = 1; $i <= $total_albums; $i++) {
            ?>
            <li <?php if ($nuv_side === $i) { echo 'class="active"'; } ?>>
                <a href="?page=musikbutikken&side_nr=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php
        }

        ?>

    </ul>
</div>



