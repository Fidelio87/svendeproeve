<?php


$kontakt_navn    = '';
$kontakt_adresse = '';
$kontakt_tlf     = '';
$kontakt_email   = '';
$kontakt_besked  = '';


if (isset($_POST['submit'])) {
    $kontakt_navn    = $_POST['navn'];
    $kontakt_adresse = $_POST['adresse'];
    $kontakt_email   = $_POST['email'];
    $kontakt_besked  = $_POST['besked'];

    if (empty($kontakt_navn) || empty($kontakt_email) || empty($kontakt_emne) || empty($kontakt_besked)) {
        alert('danger', 'Fejl! Ikke alle felter er udfyldte');
    } else {
        $modtager = 'red@bbbmag.dk';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers  .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        $headers .= 'From: ' . $kontakt_navn . ' <' . $kontakt_email . '>' . "\r\n";
        mail();

        alert('success', 'Tak for din henvendelse!');

        $kontakt_navn    = '';
        $kontakt_adresse = '';
        $kontakt_tlf     = '';
        $kontakt_email   = '';
        $kontakt_besked  = '';
    }
}


?>
<div class="row">
    <address class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <ul class="list-group">
            <?php

            $query  = 'SELECT * FROM adresser LIMIT 1';
            $result = $db->query($query);
            if ( ! $result) {
                query_error($query, __LINE__, __FILE__);
            }

            while ($row = $result->fetch_object()) {
                ?>
                <li class="list-group-item"><h2><?php echo $row->navn; ?></h2></li>
                <li class="list-group-item"><?php echo $row->gade . " " . $row->husnr; ?></li>
                <li class="list-group-item"><?php echo $row->postnr . " - " . $row->bynavn; ?></li>
                <li class="list-group-item">Tlf. <?php echo $row->tlf; ?></li>
                <li class="list-group-item">
                    <a href="mailto:<?php echo $row->email ?>" target="_blank">
                        <?php echo $row->email; ?>
                    </a></li>
                <?php
            }
            ?>
        </ul>
    </address>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <h2>Åbningstider</h2>
        <ul class="list-group">
            <?php
            $query  = "SELECT TIME_FORMAT(tidspunkt_tid_fra, '%H.%i') AS tidspunkt_fra,
                        TIME_FORMAT(tidspunkt_tid_til, '%H.%i') AS tidspunkt_til,
                        tidspunkt_ugedag
                        FROM tidspunkter
                        ORDER BY tidspunkt_id
                        LIMIT 7";
            $result = $db->query($query);

            if (!$result) {
                query_error($query, __LINE__, __FILE__);
            }

            while ($row = $result->fetch_object()) {
                ?>
                <li class="list-group-item list-group-item-info">
                    <?php echo $row->tidspunkt_ugedag . ': '
                               . $row->tidspunkt_fra . ' - '
                               . $row->tidspunkt_til;
                    ?>
                </li>
                <?php
            }
            ?>
            <li class="list-group-item list-group-item-info">Søndag: Lukket</li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <form action="#" method="post" role="form" class="form-horizontal">
            <div class="form-group col-md-8">
                <label for="">Navn</label>
                <input type="text" class="form-control" name="navn" value="<?php echo $kontakt_navn; ?>"
                       placeholder="Navn">
            </div>
            <div class="form-group col-md-8">
                <label for="">Adresse</label>
                <input type="text" class="form-control" name="adresse" value="<?php echo $kontakt_adresse; ?>"
                       placeholder="Adresse">
            </div>
            <div class="form-group col-md-8">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $kontakt_email; ?>"
                       placeholder="@">
            </div>
            <div class="form-group col-md-8">
                <label for="">Tlf</label>
                <input type="number" min="00000000" max="9999999999" class="form-control" name="tlf" value="<?php
                echo $kontakt_tlf; ?>">
            </div>
            <div class="form-group col-md-8">
                <label for="">Besked</label>
                <textarea class="form-control" cols="16" rows="3" name="besked"
                          placeholder="Skriv din besked her."><?php echo $kontakt_besked; ?></textarea>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" class="btn btn-primary">Send besked</button>
                </div>
            </div>
        </form>
    </div>
</div>
