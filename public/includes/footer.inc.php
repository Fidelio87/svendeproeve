<?php

$query  = 'SELECT * FROM adresser LIMIT 1';
$result = $db->query($query);
$row    = $result->fetch_object();
if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

?>

<footer class="container">
    <address class="col-lg-12 text-center">
        <h4 class="lead"><?php echo $row->navn; ?></h4>
        <h5><?php   echo $row->gade; ?> <?php
            echo $row->husnr; ?>, <?php
            echo $row->postnr; ?> <?php
            echo $row->bynavn; ?> - TEL: +45 <?php
            echo $row->tlf; ?> - Email: <span><a href="mailto: <?php
                echo $row->email; ?>"><?php
                    echo $row->email; ?></a></span></h5>
    </address>
</footer>