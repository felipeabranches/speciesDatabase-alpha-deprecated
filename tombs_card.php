<?php
include_once 'init.php';
$page_title = 'Tombs';
$id = (!$_GET['id']) ? '' : ' AND t.id IN ('.$_GET['id'].')';
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="<?php echo $author; ?>">
	<title><?php echo $page_title; ?> - <?php echo $site_name; ?></title>
    <?php include_once 'modules/head.php'; ?>
</head>

<body class="bg-light">
<?php include_once 'modules/menu.php'; ?>
<div class="container-fluid" role="main">
    <div class="toolbar sticky-top row my-2 p-2 d-print-none">
        <div class="col-12">
            <h4><?php echo $page_title; ?></h4>
        </div>
    </div>
    <div class="row">
        <?php
        $sql = 'SELECT
                    t.name AS tomb, t.entity AS tEntity, t.date AS tDate, t.specie_count AS n,
                    c.name AS campaign, c.entity AS cEntity, c.date AS cDate,
                    wpt.name AS waypoint,
                    un.name AS unit,
                    unt.name AS unitType,
                    CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                FROM camp_tombs AS t
                LEFT JOIN camp_campaigns AS c
                    ON c.id = t.id_campaign
                LEFT JOIN wpt_waypoints AS wpt
                    ON wpt.id = t.id_waypoint
                LEFT JOIN camp_units AS un
                    ON un.id = wpt.id_unit
                LEFT JOIN camp_units_types AS unt
                    ON unt.id = un.id_type
                LEFT JOIN sp_species AS sp
                    ON sp.id = t.id_specie
                WHERE t.published = 1 '.$id.'
                ORDER BY t.id
                ';
        if($result=mysqli_query($mysqli,$sql))
        {
            if(!$result->num_rows)
            {
                echo '<p>No entries</p>';
            }
            else
            {
                // Fetch one and one row
                while ($row=mysqli_fetch_object($result))
                {
                ?>
                <div class="col-12 col-md-4">
                    <div class="card mt-3 mb-3">
                        <h5 class="card-header"><?php echo $row->tomb; ?></h5>
                        <div class="card-body">
                            <p class="card-title"><em><?php echo $row->nomenclature; ?></em> <span class="float-right">N: <?php echo $row->n; ?></span></p>
                            <p class="card-text text-muted"><?php echo $row->unitType; ?> <?php echo $row->unit; ?></p>
                            <p class="card-text text-muted"><?php echo $row->waypoint; ?></p>
                            <p class="card-text">Col: <?php echo $row->cEntity; ?> <span class="float-right"><?php echo $row->cDate; ?></span></p>
                            <p class="card-text">Det: <?php echo $row->tEntity; ?> <span class="float-right"><?php echo $row->tDate; ?></span></p>
                        </div>
                        <div class="card-footer text-muted"><?php echo $row->campaign; ?></div>
                    </div>
                </div>
                <?php
                }
                // Free result set
                mysqli_free_result($result);
            }
        }
        mysqli_close($mysqli);
        ?>
    </div>
</div>
<?php include_once 'modules/footer.php'; ?>
</body>
</html>
