<?php

if (isset($_SESSION['bruger']['id']) && !is_admin()) {

    $id = (int)$_SESSION['bruger']['id'];

    $query  = 'SELECT bruger_id, bruger_brugernavn, bruger_beskrivelse, bruger_img, konto_saldo
                FROM brugere
                INNER JOIN konti ON brugere.bruger_id = konti.fk_bruger_id
                WHERE bruger_id = ' . $id . ' AND bruger_status = 1';
    $result = $db->query($query);
    if (!$result) {
        query_error($query, __LINE__, __FILE__);
    }
    
    while ($bruger = $result->fetch_object()) {
        ?>
        <div class="col-md-4">
            <h4><?php echo $bruger->bruger_brugernavn; ?></h4>
            <?php echo $bruger->bruger_beskrivelse; ?>
            <p>Du har <?php echo $bruger->konto_saldo; ?> <span class="text-info">Grunker</span> på din konto</p>
            <a href="index.php?page=rediger-profil&id=<?php echo $bruger->bruger_id; ?>" class="btn btn-warning">
                <i class="fa fa-cog fa-fw"></i> Redigér profil
            </a>
        </div>
        <div class="col-md-8">
            <div class="col-sm-12 col-md-6">
                <img src="img/brugere/<?php echo $bruger->bruger_img; ?>" alt="" class="img-responsive">
            </div>
            <div class="col-sm-12 col-md-6">
                <a href="?page=anmeldelser&bruger_id=<?php echo $bruger->bruger_id; ?>"> Læs anmeldelser</a>
                <h4>Seneste køb</h4>
                <ul class="list-group">
                    <?php
                    $query_liste = 'SELECT timestamp, album_id, album_kunstner, album_titel FROM transaktioner
                                    LEFT JOIN konti ON transaktioner.fk_konto_id = konti.konto_id
                                    INNER JOIN albums ON transaktioner.fk_album_id = albums.album_id
                                    WHERE fk_konto_id = (SELECT konto_id FROM konti WHERE fk_bruger_id = ' . $id. ')
                                    ORDER BY timestamp';
                    $result_liste = $db->query($query_liste);

                    if (!$result_liste) { query_error($query_liste, __LINE__, __FILE__); }

                    while   ($row_liste = $result_liste->fetch_object()) {
                        ?>
                        <li class="list-group-item"><strong><a href="index.php?page=album&id=<?php
                                echo $row_liste->album_id; ?>"><?php
                                echo $row_liste->album_titel; ?></a></strong> - <em><?php
                                echo $row_liste->album_kunstner; ?></em></li>
                        <hr>
                        <?php
                    }
                    ?>
                </ul>
        </div>
        </div>
        <?php
    }
} else {
    alert('info', 'Det ser ud til, at du ingen profil har endnu. 
Opret venligst een <a class="btn btn-info text-success" href="?page=opret-profil"><i class="fa fa-user-plus fa-fw"></i> her</a>');
}
?>




