<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php"><?php echo $site_name; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Species</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="taxonomists_card.php?id=0&order_by=id">Taxonomists</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="campaigns_card.php?id=0&order_by=id">Campaigns</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="waypoints_card.php?id=0&order_by=id">Waypoints</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tombs_table.php?id=0&order_by=tb.id">Tombs</a>
            </li>
        </ul>
        <!--ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="admin">Admin</a>
            </li>
        </ul-->
    </div>
</nav>
