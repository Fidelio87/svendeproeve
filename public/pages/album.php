<?php

if (isset($_GET['id']) && (int)$_GET['id']) {
    $album_id = $_GET['id'];

    if (isset($_GET['action']) && $_GET['action'] === 'koeb') {
        $query_konto = 'SELECT konto_id, konto_saldo FROM konti WHERE fk_bruger_id = ' . $_SESSION['bruger']['id'];
        $result_konto = $db->query($query_konto);

        if (!$result_konto) { query_error($query_konto, __LINE__, __FILE__); }

        $row_konto = $result_konto->fetch_object();
        $konto_id = $row_konto->konto_id;
        $konto_saldo = $row_konto->konto_saldo;

        $query_trans = 'INSERT INTO transaktioner (fk_konto_id, fk_album_id) VALUES (' . $konto_id . ', ' . $album_id . ')';
        $result_trans = $db->query($query_trans);

        if (!$result_trans) { query_error($query_trans, __LINE__, __FILE__); }

        $trans_ins_id = $db->insert_id;

        $query_pris = 'SELECT album_id, vaerdi 
                        FROM priser 
                        INNER JOIN albums ON priser.id = albums.fk_pris_id 
                        WHERE album_id = ' . $album_id;
        $result_pris = $db->query($query_pris);

        if (!$result_pris) { query_error($query_pris, __LINE__, __FILE__); }

        $row_pris = $result_pris->fetch_object();

        $pris = $row_pris->vaerdi;

        $ny_saldo = $konto_saldo - $pris;

        if ($ny_saldo >= $pris) {
            $query_koeb = 'UPDATE konti SET konto_saldo = ' . $ny_saldo . ' WHERE fk_bruger_id = ' . $_SESSION["bruger"]["id"];
            $result_koeb = $db->query($query_koeb);

            if (!$result_koeb) { query_error($query_koeb, __LINE__, __FILE__); }


            set_log('opret', 'Bruger købte album med id ' . $album_id, $_SESSION['bruger']['id']);

            alert('success', 'Du har købt et album!');
        } else {
            alert('danger', 'Der er desværre ingen dækning for dette køb!');
        }
//        redirect_to('index.php?page=musikbutikken');
    }
}

$query_genre  = 'SELECT fk_genre_id
                  FROM albums 
                  INNER JOIN genrer ON albums.fk_genre_id = genrer.genre_id
                  WHERE album_id = ' . $album_id;
$result_genre = $db->query($query_genre);
$row_genre = $result_genre->fetch_object();
$genre_id = $row_genre->fk_genre_id;


?>
    <div class="container">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h3>Andre albums fra samme genre</h3>
            <?php
            $query  = 'SELECT   album_id, 
                                album_kunstner, 
                                album_titel, 
                                album_img
                      FROM albums 
                      WHERE fk_genre_id = ' . $genre_id . '
                      ORDER BY RAND()
                      LIMIT 3';
            $result = $db->query($query);

            if (!$result) { query_error($query, __LINE__, __FILE__); }

            while ($row = $result->fetch_object()) {
                ?>
            <div class="row">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="img/albums/thumbs/<?php echo $row->album_img; ?>" alt="">
                    </div>
                    <div class="media-body">
                        <h4><?php echo $row->album_kunstner; ?></h4>
                        <em><?php echo $row->album_titel; ?></em>
                    </div>
                </div>
                <hr>
            </div>
            <?php
            }
            ?>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
                  WHERE album_id = ' . $album_id;
            $result = $db->query($query);
            $row = $result->fetch_object();

            if (!$result) { query_error($query, __LINE__, __FILE__); }

            ?>
                <div class="thumbnail album-thmb">
                    <img src="img/albums/<?php echo $row->album_img; ?>" class="img-responsive" alt="<?php
                    echo $row->album_titel; ?>">
                    <div class="caption">
                        <h3><?php echo $row->album_titel; ?></h3>
                        <p><?php echo $row->album_kunstner; ?>   <span class="badge"><?php
                                echo $row->genre_navn; ?></span></p>
                        <p>Pris <?php echo $row->vaerdi; ?> Grunker</p>
                        <p>
                            <a href="index.php?page=album&id=<?php
                            echo $row->album_id; ?>&action=koeb" class="btn btn-info <?php
                            if(empty($_SESSION['bruger']) || $_SESSION['bruger']['niveau'] > 100) { echo 'hidden';}
                            ?>" role="button">Køb album</a>
                            <a href="index.php?page=anmeldelser&album_id=<?php echo $row->album_id; ?>" class="btn btn-default" role="button"> > Læs anmeldelser</a></p>
                    </div>
                </div>
        </div>
    </div>


