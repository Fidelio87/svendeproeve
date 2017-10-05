<?php

$sidste_mnd = date('F', strtotime('-1 month'));

?>

<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
<!--Velkomsttekst-->
    <?php echo $side->side_indhold; ?>
</div>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
<!--hitlisten-->
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Hitlisten</div>
        <div class="panel-body">
            <p>Her kan du se en oversigt over hvilke albums der gjorde sig godt i <?php echo $sidste_mnd; ?></p>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Salg sidste måned</th>
                    <th>Kunstner</th>
                    <th>Album</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>129</td>
                    <td>Shakira</td>
                    <td>Oral</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <h2>Albums</h2>

    <?php
    $query      = 'SELECT album_id, album_kunstner, album_titel, album_img FROM albums ORDER BY RAND() LIMIT 3';
    $result     = $db->query($query);
    if (!$result) {
        query_error($query, __LINE__, __FILE__);
    }

    while ($row = $result->fetch_object()) {
            ?>

<!--        TODO fix AJAX og styling-->

        <div class="media">
            <div class="media-left">
                <a href="?page=album&id=<?php echo $row->album_id; ?>">
                    <img class="media-object" src="img/albums/thumbs/<?php echo $row->album_img; ?>" alt="">
                </a>
            </div>
            <div class="media-body">
                <h4><?php echo $row->album_kunstner; ?></h4>
                <em><?php echo $row->album_titel; ?></em>
            </div>
        </div>
    <?php
    }
    ?>
</div>
