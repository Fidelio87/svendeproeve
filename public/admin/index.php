<?php

require_once 'config.php';

if (!is_admin()) {
    redirect_to('../404.php');
}


//IMPORTS
require '../../resources/vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(array('driver' => 'gd'));

if (isset($_GET['logout'])) {
    session_destroy();
    redirect_to('../index.php?page=');
}


if (isset($_GET['page'])) {
    // …henter vi pagens filnavn herfra
    $side     = $_GET['page'];
    $side_sti = 'pages/' . $side . '.php';
} else {
    $side     = '';
    $side_sti = 'pages/dashboard.php';
}

$sider = [
    ''                   => [
        'ikon'      => 'dashboard',
        'titel'     => 'Dashboard',
        'vis'       => 1,
        'niveau'    => 1000,
        'aktiv_paa' => ['']

    ],
    'brugere'            => [
        'ikon'      => 'users',
        'titel'     => 'Brugere',
        'vis'       => 1,
        'niveau'    => 1000,
        'aktiv_paa' => ['brugere', 'opret-bruger']
    ],
    'opret-bruger'       => [
        'ikon'   => 'users',
        'titel'  => 'Opret bruger',
        'vis'    => 0,
        'niveau' => 1000
    ],
    'albums'             => [
        'ikon'      => 'file-text-o',
        'titel'     => 'Albums',
        'vis'       => 1,
        'niveau'    => 1000,
        'aktiv_paa' => ['album', 'opret-album', 'rediger-album']
    ],
    'opret-album'        => [
        'ikon'   => 'plus',
        'titel'  => 'Opret album',
        'vis'    => 0,
        'niveau' => 1000
    ],
    'rediger-album'      => [
        'ikon'   => 'file-text-o',
        'titel'  => 'Rediger album',
        'vis'    => 0,
        'niveau' => 1000
    ],
    'genrer'             => [
        'ikon'      => 'list',
        'titel'     => 'Genrer',
        'vis'       => 1,
        'niveau'    => 1000,
        'aktiv_paa' => ['genrer', 'rediger-genre']
    ],
    'rediger-genre'      => [
        'ikon'   => 'list',
        'titel'  => 'Rediger genre',
        'vis'    => 0,
        'niveau' => 1000
    ],
    'anmeldelser'        => [
        'ikon'      => 'bullhorn',
        'titel'     => 'Anmeldelser',
        'vis'       => 1,
        'niveau'    => 1000,
        'aktiv_paa' => ['anmeldelser, opret-anmeldelse, rediger-anmeldelse']
    ],
    'opret-anmeldelse'   => [
        'ikon'   => 'bullhorn',
        'titel'  => 'Opret anmeldelse',
        'vis'    => 0,
        'niveau' => 1000
    ],
    'rediger-anmeldelse' => [
        'ikon'   => 'bullhorn',
        'titel'  => 'Rediger anmeldelse',
        'vis'    => 0,
        'niveau' => 1000
    ],
    'rediger-info'       => [
        'ikon'      => 'info-circle',
        'titel'     => 'Rediger info',
        'vis'       => 1,
        'niveau'    => 1000,
        'aktiv_paa' => ['rediger-info']
    ]
];

$side_titel = isset($sider[$side]['titel']) ? $sider[$side]['titel'] : 'HTTP 404';

?>

<!DOCTYPE html>
<html lang="da">
<?php require 'includes/head.inc.php'; ?>
<body>

<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><i class="fa fa-cogs fa-fw"></i> DJ Grunk</a>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['bruger']['navn']; ?>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="index.php?page=rediger-bruger"><i class="fa fa-pencil fa-fw"></i> Rediger profil</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="index.php?logout"><i class="fa fa-sign-out fa-fw"></i> Log af</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <?php
                    //                        udskriver alle links i $sider-array
                    foreach ($sider as $key => $value) {
                        if ($_SESSION['bruger']['niveau'] >= $value['niveau'] && $value['vis'] === 1) {
                            ?>
                            <li>
                                <a <?php
                                if (in_array($sider, $value['aktiv_paa'], true)) {
                                    echo 'class="active"';
                                } ?> href="index.php<?php if (!empty($key)) {
                                    echo '?page=' . $key;
                                } ?>">
                                    <i class="fa fa-<?php echo $value['ikon']; ?> fa-fw"></i>
                                    <?php echo $value['titel']; ?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                    <li>
                        <a href="../index.php" target="_blank"><i class="fa fa-external-link fa-fw">

                            </i> Gå til frontend</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--        Page content-->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if (file_exists($side_sti)) {
                        include($side_sti);
                    } else {
                        ?>
                        <h1><i class="fa fa-exclamation-triangle"></i> Websiden blev ikke fundet (HTTP 404)</h1>
                        <hr>
                        <p>Ups!.. Noget gik galt. Siden du efterspurgte kunne ikke findes. Prøv evt. senere.</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <?php show_dev_info(); ?>
            </div>
            <!--                CKEDITOR-replace script-->
            <script>

                CKEDITOR.replace('ck_indhold', {
                    'language' : 'da',
                    'uiColor' : '#fefefe',
                    toolbarGroups: [
                        {"name":"basicstyles","groups":["basicstyles"]},
                        {"name":"links","groups":["links"]},
                        {"name":"paragraph","groups":["list","blocks"]},
                        {"name":"document","groups":["mode"]},
                        {"name":"insert","groups":["insert"]},
                        {"name":"styles","groups":["styles"]}
                    ],
                    // Remove the redundant buttons from toolbar groups defined above.
                    removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
                });

            </script>
        </div>
        <!--            .page-wrapper-->
    </div>
    <!--        .wrapper-->
</div>

<?php require 'includes/scripts.inc.php'; ?>

</body>
</html>
<?php $db->close(); ?>



