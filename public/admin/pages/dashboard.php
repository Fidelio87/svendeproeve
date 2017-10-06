<?php

checkAccess();

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
    <small>Overblik</small>
</h1>


<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-<?php echo $sider['brugere']['ikon'] ?> fa-5x"></i>
                    </div>
                    <?php
                    $query = 'SELECT COUNT(bruger_id) as bruger_antal
                            FROM brugere';
                    $result = $db->query($query);
                    $row = $result->fetch_object();

                    if (!$result) { query_error($query, __LINE__, __FILE__); }
                    ?>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $row->bruger_antal; ?></div>
                        <div class="text-info">Bruger<?php if ($row->bruger_antal > 1) { echo 'e'; } ?></div>
                    </div>
                </div>
            </div>
            <a href="index.php?page=brugere">
                <div class="panel-footer">
                    <span class="pull-left">Gå til oversigt</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-<?php echo $sider['albums']['ikon'] ?> fa-5x"></i>
                    </div>
                    <?php
                    $query = 'SELECT COUNT(album_id) as album_antal
                              FROM albums';
                    $result = $db->query($query);

                    if (!$result) { query_error($query, __LINE__, __FILE__); }

                    $row = $result->fetch_object();
                    ?>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $row->album_antal; ?></div>
                        <div class="text-info">
                            <?php
                            if ($row->album_antal > 1) {
                                echo 'Albums';
                            } else {
                                echo 'Album';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <a href="index.php?page=albums">
                <div class="panel-footer">
                    <span class="pull-left">Gå til oversigt</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-<?php echo $sider['anmeldelser']['ikon'] ?> fa-5x"></i>
                    </div>
                    <?php
                    $query = 'SELECT COUNT(id) as anmeldelse_antal
                            FROM anmeldelser';
                    $result = $db->query($query);
                    if (!$result) { query_error($query, __LINE__, __FILE__); }


                    $row = $result->fetch_object();
                    ?>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $row->anmeldelse_antal; ?></div>
                        <div class="text-info">Anmeldelse<?php if ($row->anmeldelse_antal > 1 || $row->anmeldelse_antal == 0) { echo 'r'; } ?>
                        </div>
                    </div>
                </div>
            </div>
            <a href="index.php?page=anmeldelser">
                <div class="panel-footer">
                    <span class="pull-left">Gå til oversigt</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-<?php echo $sider['genrer']['ikon'] ?> fa-5x"></i>
                    </div>
                    <?php
                    $query = 'SELECT COUNT(genre_id) as genre_antal
                            FROM genrer';
                    $result = $db->query($query);

                    if (!$result) { query_error($query, __LINE__, __FILE__); }

                    $row = $result->fetch_object();
                    ?>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $row->genre_antal; ?></div>
                        <div class="text-info">Genre<?php if ($row->genre_antal > 1) { echo 'r'; } ?></div>
                    </div>
                </div>
            </div>
            <a href="index.php?page=genrer">
                <div class="panel-footer">
                    <span class="pull-left">Gå til oversigt</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>'
<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <h2>Systemlog</h2>
        <?php

        $query = 'SELECT * FROM logs
                  INNER JOIN log_typer ON logs.fk_log_type = log_typer.log_type_id
                  INNER JOIN brugere ON logs.fk_bruger_id = brugere.bruger_id
                  ORDER BY log_tid DESC';
        $result = $db->query($query);

        while ($row = $result->fetch_object()) {
            ?>
            <details class="bg-<?php echo $row->log_type_css; ?>">
                <summary>#<?php echo $row->log_id; ?> - <span class="text-capitalize"><?php echo $row->log_type_navn; ?></span></summary>
                <p><em><?php echo $row->log_tid; ?></em></p>
                <p class="small"><em><?php echo $row->log_beskrivelse; ?></em></p>
                <p>Aktør: <strong><?php echo $row->bruger_brugernavn;?></strong></p>
            </details>
        <?php
        }

        ?>

    </div>
</div>
