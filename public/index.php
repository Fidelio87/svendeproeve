<?php

require '../config.php';

include '../resources/vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(array('driver' => 'gd'));

if (isset($_GET['logout'])) {
    logout();
    redirect_to('index.php');
}

$side_url = isset($_GET['page']) ? $db->real_escape_string($_GET['page']) : '';


$query  = "SELECT side_url,
                  side_titel,
                  side_nav_label,
                  side_nav_sortering,
                  side_indhold,
                  side_include_filnavn
            FROM sider
            LEFT JOIN side_includes ON fk_side_include_id = side_include_id
            WHERE side_status = 1 AND side_url = '$side_url'";
$result = $db->query($query);
$side    = $result->fetch_object();
if (!$result) {
    query_error($query, __LINE__, __FILE__);
}

$side_titel = isset($side) ? $side->side_titel : 'HTTP 404';


?>

<!DOCTYPE html>
<html lang="da">
    <?php require_once 'includes/head.inc.php'; ?>
<body>
    <div class="container">
        <?php include 'includes/header.inc.php'; ?>

        <?php include 'includes/nav.inc.php'; ?>

        <!--    CONTENT-->
        <div class="row">
            <div class="row">
                <?php

                echo '<h2>' . $side_titel . '</h2>';

                if (isset($side->side_indhold) && $side_url !== '') {
                    echo $side->side_indhold;
                }

                ?>
            </div>
           <div class="row">
               <?php
               if (isset($side->side_include_filnavn) && file_exists('pages/' . $side->side_include_filnavn)) {
                   include 'pages/' . $side->side_include_filnavn;
               } else {
                   redirect_to('404.php');
               }
               ?>
           </div>
        </div>

        <div class="row bg-warning">
            <div class="container-fluid">
                <?php show_dev_info(); ?>
            </div>
        </div>

        <?php include 'includes/footer.inc.php'; ?>
    </div> <!--..Main container-->
<?php include 'includes/scripts.inc.php'; ?>
</body>
</html>
<?php ob_end_flush(); ?>

