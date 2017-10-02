<?php

?>

<nav class="navbar navbar-default">
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
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

