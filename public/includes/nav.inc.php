<?php

if (isset($_POST['submit_login']) && login($_POST['brugernavn'], $_POST['password'])) {
    redirect_to('index.php');
}

?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <?php

                $query = 'SELECT side_url, side_nav_label
                          FROM sider
                          WHERE side_status = 1 AND side_nav_visning = 1
                          ORDER BY side_nav_sortering';
                $result = $db->query($query);

                if (!$result) { query_error($query, __LINE__, __FILE__); }

                while ($row = $result->fetch_object()) {
                    ?>
                    <li <?php if ($row->side_url === $side_url) { echo 'active'; } ?>>
                        <a href="index.php?page=<?php echo $row->side_url; ?>">
                            <?php echo $row->side_nav_label ?></a>
                    </li>
                    <?php
                }
                ?>
<!--                TODO align button -->
                <?php
                if (empty($_SESSION['bruger'])) {
                    ?>
                    <form class="navbar-form navbar-right" action="#" method="post" role="form">
                        <div class="form-group-sm">
                            <input type="text" name="brugernavn" class="form-control" placeholder="Brugernavn" required>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" name="submit_login" class="btn btn-sm btn-primary">
                            <i class="fa fa-key fa-fw"></i> Login</button>
                        <a href="?page=opret-profil" class="btn btn-info btn-sm navbar-right "><i class="fa fa-user-plus fa-fw"></i> Opret profil</a>
                    </form>

                <?php
                } else {
                    ?>
                    <p class="navbar-text">Logget ind som <?php 
                        echo $_SESSION['bruger']['navn']; 
                        if (isset($_SESSION['bruger']['niveau']) && is_admin()) {
                            ?>
                        <a href="admin/index.php" class="nav-link"><i class="fa fa-lock fa-fw"></i> Gå til adminside</a>
                        <?php
                        }
                        ?></p>
                    
                <?php
                }
                ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>