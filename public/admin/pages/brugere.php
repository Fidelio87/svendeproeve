<?php

checkAccess();




//SLET BRUGER
if (isset($_GET['slet_id']) && $_GET['slet_id'] !== $_SESSION['bruger']['id']) {
    $id = (int)$_GET['slet_id'];

    $query = 'SELECT bruger_img
              FROM brugere
              WHERE bruger_id = ' . $id;
    $result = $db->query($query);

    if (!$result) { query_error($query, __LINE__, __FILE__); }

    $row = $result->fetch_object();
    //hvis der er et billede tilknyttet brugeren, slettes de
    if (isset($row->bruger_img)) {
        unlink('../img/personer/' . $row->bruger_img);
        unlink('../img/personer/thumbs/' . $row->bruger_img);
    }

    // TODO delete all related table entries

    $query = 'DELETE FROM brugere WHERE bruger_id = ' . $id;

    $result = $db->query($query);

    if (!$result) { query_error($query, __LINE__, __FILE__); }

    if ($db->affected_rows >= 1) {
        set_log('slet', 'En bruger blev slettet');
    }

    redirect_to('index.php?page=' . $side);
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
