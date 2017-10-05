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
        <p><?php echo $bruger->konto_saldo; ?> <span class="text-info">Grunker</span></p>
        </div>

        <div class="col-md-8">
            <div class="col-md-6">
                <img src="img/brugere/<?php echo $bruger->bruger_img; ?>" alt="" class="img-responsive">
            </div>
            <div class="col-md-6">
                <a href="?page=anmeldelser&bruger_id=<?php echo 2;?>"> Læs anmeldelser</a>
                <h4>Seneste køb</h4>
                <ul class="list-group">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div>
        <?php
    }
} else {
    alert('info', 'Det ser ud til, at du ingen profil har endnu. Opret venligst een <a href="?opret-profil">her</a>');
}
?>


