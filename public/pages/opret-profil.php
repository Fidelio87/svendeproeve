<?php

if (DEV_STATUS) {
    $lipsum = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus commodi maiores quos recusandae ullam. 
Accusamus commodi cupiditate delectus dolores eaque et exercitationem explicabo non quasi repellat. 
Accusamus aliquam iure sunt!';
} else {
    $lipsum = '';
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <?php

    $brugernavn         = '';
    $beskrivelse_tmp    = $lipsum;

    if (isset($_POST['opret_bruger'])) {

    }

    ?>
</form>