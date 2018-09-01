<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo $base_url; ?>"><?php echo $site_name; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Panel</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSystematics" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Systematics</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownSystematics">
                    <a class="dropdown-item" href="sp_species.php?order_by=id">Species</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="sp_taxa.php?order_by=id">Taxa</a>
                    <a class="dropdown-item" href="sp_taxa_types.php?order_by=id">Taxa Types</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="sp_taxonomists.php?order_by=id">Taxonomists</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCampaings" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Campaings</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownCampaings">
                    <a class="dropdown-item" href="camp_campaings.php?order_by=id">Campaings</a>
                    <a class="dropdown-item" href="camp_waypoints.php?order_by=id">Waypoints</a>
                    <a class="dropdown-item" href="camp_tombs.php?order_by=id">Tombs</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="camp_units.php?order_by=id">Units</a>
                    <a class="dropdown-item" href="camp_units_types.php?order_by=id">Units Types</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle disabled" href="#" id="navbarDropdownReferences" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">References</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownUsers">
                    <a class="dropdown-item" href="user_refs.php?order_by=id">References</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle disabled" href="#" id="navbarDropdownUsers" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Users</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownUsers">
                    <a class="dropdown-item" href="user_users.php?order_by=id">Users</a>
                    <a class="dropdown-item" href="user_users_types.php?order_by=id">Users Types</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url; ?>">Site</a>
            </li>
        </ul>
    </div>
</nav>
