<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo $base_url; ?>"><?php echo $site_name; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo ADMIN; ?>index.php">Panel</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSystematics" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Systematics</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownSystematics">
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>sp_species.php?order_by=id">Species</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>sp_taxa.php?order_by=id">Taxa</a>
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>sp_taxa_types.php?order_by=id">Taxa Types</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>sp_taxonomists.php?id=0&order_by=id">Taxonomists</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownWaypoints" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Camp</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownWaypoints">
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>camp_campaigns.php?order_by=id">Campaings</a>
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>wpt_waypoints.php?order_by=id">Waypoints</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>wpt_units.php?order_by=id">Units</a>
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>wpt_units_types.php?order_by=id">Units Types</a>
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-item disabled" href="<?php echo ADMIN; ?>wpt_places.php?order_by=id">Places</span>
                    <span class="dropdown-item disabled" href="<?php echo ADMIN; ?>wpt_provinces.php?order_by=id">Provinces</span>
                    <span class="dropdown-item disabled" href="<?php echo ADMIN; ?>wpt_countries.php?order_by=id">Countries</span>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMusuem" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Museum</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMusuem">
                    <a class="dropdown-item" href="<?php echo MUSEUM; ?>tombs.php?id=0&where&order_by=tb.id">Tombs</a>
                    <span class="dropdown-item disabled" href="<?php echo MUSEUM; ?>collections.php?where&id&order_by=tb.id">Collections</span>
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-item disabled" href="<?php echo MUSEUM; ?>refrences.php?order_by=id">References</span>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUsers" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Users</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownUsers">
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>users_users.php?order_by=id">Users</a>
                    <a class="dropdown-item" href="<?php echo ADMIN; ?>users_users_types.php?order_by=id">Users Types</a>
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
