<?php

checkAccess();




//SLET BRUGER
if (isset($_GET['slet_id']) && $_GET['slet_id'] !== $_SESSION['bruger']['id']) {
    $id = (int)$_GET['slet_id'];

    $query_gl_img = 'SELECT bruger_img
              FROM brugere
              WHERE bruger_id = ' . $id;
    $result_gl_img = $db->query($query_gl_img);

    if (!$result_gl_img) { query_error($query_gl_img, __LINE__, __FILE__); }

    $row_gl_img = $result_gl_img->fetch_object();

    var_dump($row_gl_img);
    //hvis der er et billede tilknyttet brugeren, slettes de
    if (isset($row_gl_img->bruger_img)) {
         if (file_exists('img/brugere/' . $row_gl_img->bruger_img)) {
             unlink('../img/personer/' . $row_gl_img->bruger_img);
         }
         if (file_exists('img/brugere/thumbs/' . $row_gl->bruger_img)) {
             unlink('../img/personer/thumbs/' . $row_gl_img->bruger_img);
         }
    }

    $query_konto = 'SELECT konto_id FROM konti WHERE fk_bruger_id = ' . $id;
    $result_konto = $db->query($query_konto);

    if (!$result_konto) { query_error($query_konto, __LINE__, __FILE__); }

    $row_konto = $result_konto->fetch_object();

    $konto_id = $row_konto->konto_id;

    $query_count_trans = 'SELECT COUNT(id) FROM transaktioner WHERE fk_konto_id = ' . $konto_id;

    $result_count_trans = $db->query($query_count_trans);

    if (!$result_count_trans) { query_error($query_count_trans, __LINE__, __FILE__); }


    $rows_count_trans = $result_count_trans->fetch_object();

    if ($rows_count_trans > 0) {
        $query_del_trans = 'DELETE FROM transaktioner WHERE fk_konto_id = ' . $konto_id;

        $result_del_trans = $db->query($query_del_trans);

        if (!$result_del_trans) { query_error($query_del_trans, __LINE__, __FILE__); }
    }

    $query_del_konto = 'DELETE FROM konti WHERE fk_bruger_id = ' . $id;

    $result_del_konto = $db->query($query_del_konto);
    if (!$result_del_konto) { query_error($query_del_konto, __LINE__, __FILE__); }

    $query_del_anm = 'DELETE FROM anmeldelser WHERE fk_bruger_id = ' . $id;
    $result_del_anm = $db->query($query_del_anm);

    if (!$result_del_anm) { query_error($query_del_anm, __LINE__, __FILE__); }

    $query_del_logs = 'DELETE FROM logs WHERE fk_bruger_id = ' . $id;

    $result_del_logs = $db->query($query_del_logs);

    var_dump($query_del_logs);

    if (!$result_del_logs) { query_error($query_del_logs, __LINE__, __FILE__); }

    $query = 'DELETE FROM brugere WHERE bruger_id = ' . $id;

    $result = $db->query($query);

    if (!$result) { query_error($query, __LINE__, __FILE__); }

    if ($db->affected_rows >= 1) {
        set_log('slet', 'En bruger blev slettet', 1);
    }

//    redirect_to('index.php?page=' . $side);
}

?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider[$side]['ikon']; ?>"></i> <?php echo $sider[$side]['titel']; ?>
    <small>Oversigt over brugere</small>
</h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th align="right"><i class="fa fa-sort-numeric-desc fa-fw"></i> Sidste login</th>
            <th>Brugernavn</th>
            <th>Beskrivelse</th>
            <th>Grunker</th>
            <th>Rolle</th>
            <th class="icon"><a href="index.php?page=opret-bruger"
                                class="btn btn-success btn-xs"
                                title="Opret ny bruger"><i class="fa fa-plus-square fa-lg fa-fw"></i></a></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $bruger_id = $db->real_escape_string($_SESSION['bruger']['id']);
        $rolle_niveau = $db->real_escape_string($_SESSION['bruger']['niveau']);

        $query = "SELECT  bruger_id,
                          bruger_status,
                          DATE_FORMAT(bruger_sidste_login, '%e. %b %Y [%H:%i]') AS sidste_login,
                          bruger_brugernavn,
                          SUBSTR(bruger_beskrivelse, 1, 30) as beskrivelse_kort,
                          rolle_navn,
                          konto_saldo
                          FROM brugere
                          LEFT JOIN konti ON brugere.bruger_id = konti.fk_bruger_id
                          INNER JOIN roller on fk_rolle_id = rolle_id
                          AND rolle_niveau <= " . $rolle_niveau . "
                          ORDER BY bruger_oprettet DESC";
        $result = $db->query($query);

        $antal_brugere = $result->num_rows;

        if ($antal_brugere > 0) {
            while ($bruger = $result->fetch_object()) {
                ?>
                <tr<?php if ($bruger->bruger_id == $_SESSION['bruger']['id']) { echo ' class="info"'; } ?>>
                    <td align="left"><?php echo $bruger->sidste_login; ?></td>
                    <td><?php echo $bruger->bruger_brugernavn; ?></td>
                    <td><?php echo $bruger->beskrivelse_kort; ?>...</td>
                    <td><?php echo $bruger->konto_saldo; ?></td>
                    <td><?php echo $bruger->rolle_navn; ?></td>
                    <!--                    Slet ikon-->
                    <td><?php if ($bruger->bruger_id !== $_SESSION['bruger']['id']) {
                            ?>
                            <a href="index.php?page=<?php echo $side; ?>&slet_id=<?php
                            echo $bruger->bruger_id; ?>" class="btn btn-danger btn-xs"
                               onClick="return confirm('Er du sikker på at du vil slette brugeren?')"
                               title="slet bruger">
                                <i class="fa fa-trash-o fa-lg fa-fw"></i>
                            </a>
                        <?php }
                        ?>
                    </td>
                </tr>
                <?php
            } //.slut-while-løkke
        } else {
            ?>
            <tr>
                <td colspan="9">Der blev ikke fundet nogle brugere</td>
            </tr>
            <?php
        } //.slut-antal-brugere-check
        ?>
        </tbody>
    </table>
</div>
