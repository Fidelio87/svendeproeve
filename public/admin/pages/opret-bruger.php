<?php


checkAccess();

if (DEV_STATUS) {
    $lipsum = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
    Accusamus commodi maiores quos recusandae ullam. 
Accusamus commodi cupiditate delectus dolores eaque et exercitationem explicabo non quasi repellat. 
Accusamus aliquam iure sunt!';
} else {
    $lipsum = '';
}


?>

<h1 class="page-header">
    <i class="fa fa-<?php echo $sider['brugere']['ikon']; ?>"></i> <?php echo $sider['brugere']['titel']; ?>
    <small> Opret ny bruger</small>
</h1>

<form method="post" action="" enctype="multipart/form-data">
    <?php
    $brugernavn         = '';
    $beskrivelse_tmp    = $lipsum;



    if (isset($_POST['opret_bruger'])) {
        $brugernavn         = $db->real_escape_string($_POST['brugernavn']);
        $beskrivelse_tmp    = $_POST['beskrivelse'];
//        $fk_rolle_id        = $db->real_escape_string($_POST['rolle']);

        opret_bruger(
            $brugernavn,
            $beskrivelse_tmp,
            $_POST['password'],
            $_POST['conf_password'],
            $_FILES['img']
        );

        $sidste_bruger_id = $db->insert_id;


        set_log('opret', 'Brugeren med id ' . $sidste_bruger_id . ' blev oprettet', 1);


        $query = 'INSERT INTO konti (konto_saldo, fk_bruger_id) VALUES (1500, ' . $sidste_bruger_id . ')';
        $result = $db->query($query);
        if (!$result) { query_error($query, __LINE__, __FILE__); }


        set_log('opret', 'Brugeren med id ' . $sidste_bruger_id . ' fik overførst 1500 grunker til sin nye konto', 1);

    }

    ?>

    <div class="form-group">
        <label for="inputName" class="control-label">Brugernavn</label>
        <input name="brugernavn" class="form-control" value="<?php echo $brugernavn; ?>" autofocus required>
    </div>
    <div class="form-group">
        <label for="inputDesc" class="control-label">Beskrivelse</label>
        <textarea name="beskrivelse" id="ck_indhold" class="form-control "><?php echo $beskrivelse_tmp; ?></textarea>
    </div>
    <!--                    PASSWORD 1-->
    <div class="form-group">
        <label for="inputPassword" class="control-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <!--                    PASSWORD 2-->
    <div class="form-group">
        <label for="inputConfPassword" class="control-label">Bekræft password</label>
        <input type="password" name="conf_password" class="form-control" required>
    </div>

    <!--    IMAGE-->
    <div class="form-group">
        <label for="billede" class="control-label">Upload billede</label>
        <input type="file" name="img" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
        <div class="btn-group">
            <button type="reset" name="ryd" class="btn btn-default">
                <i class="fa fa-undo fa-fw"></i> Ryd
            </button>
            <button name="opret_bruger" class="btn btn-primary">
                <i class="fa fa-check-circle fa-fw"></i> Opret
            </button>
        </div>
    </div>

</form>

