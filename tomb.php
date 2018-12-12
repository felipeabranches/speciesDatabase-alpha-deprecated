<?php
include_once 'init.php';
$page_title = 'Tomb';
$id = $_GET['id'];
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
    <div class="toolbar sticky-top row my-2 p-2">
        <div class="col-12">
            <h4><?php //echo $page_title; ?>CICEFETMG-<?php echo $id; ?></h4>
        </div>
    </div>
    <div class="row">
        <?php
        $sql = 'SELECT
                    t.name AS tomb, t.entity AS tEntity, t.date AS tDate, t.specie_count AS n,
                    c.id AS cID, c.name AS campaign, c.entity AS cEntity, c.date AS cDate, c.note AS cNote, c.image AS cIMG,
                    wpt.id AS wptID, wpt.name AS waypoint, wpt.place AS place, wpt.latitude AS latitude, wpt.longitude AS longitude, wpt.elevation AS elevation, wpt.time AS time, wpt.note AS wptNote, wpt.image AS wptIMG,
                    un.name AS unit,
                    unt.name AS unitType,
                    sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature, sp.note AS spNote, sp.image AS spIMG
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
                WHERE t.published = 1
                    AND t.id = '.$id.'
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
                <?php if($row->cIMG): ?>
                <!--img class="card-img-top" src="<?php echo $row->cIMG; ?>" alt="<?php echo $row->campaign; ?>"-->
                <?php endif; ?>
                <div class="card-header">
                    <h5 class="float-left"><?php echo $row->campaign; ?></h5>
                    <a href="campaign.php?id=<?php echo $row->cID; ?>" class="btn btn-primary btn-sm float-right">Details</a>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Collector</dt>
                        <dd><?php echo $row->cEntity; ?></dd>
                        <dt>Date</dt>
                        <dd><?php echo $row->cDate; ?></dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <span class="badge badge-secondary"><?php echo $row->cNote; ?></span>
                    <span class="float-right">ID#<span class="badge badge-secondary badge-pill"><?php echo $row->cID; ?></span></span>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-4">
            <div class="card mt-3 mb-3">
                <?php if($row->spIMG): ?>
                <!--img class="card-img-top" src="<?php echo $row->spIMG; ?>" alt="<?php echo $row->nomenclature; ?>"-->
                <?php endif; ?>
                <div class="card-header">
                    <h5 class="float-left"><?php echo $row->nomenclature; ?></h5>
                    <a href="specie.php?id=<?php echo $row->spID; ?>" class="btn btn-primary btn-sm float-right">Details</a>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Determinator</dt>
                        <dd><?php echo $row->tEntity; ?></dd>
                        <dt>Date</dt>
                        <dd><?php echo $row->tDate; ?></dd>
                        <dt>N</dt>
                        <dd><?php echo $row->n; ?></dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <span class="badge badge-secondary"><?php echo $row->spNote; ?></span>
                    <span class="float-right">ID#<span class="badge badge-secondary badge-pill"><?php echo $row->spID; ?></span></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card mt-3 mb-3">
                <?php if ($row->wptIMG): ?>
                <!--img class="card-img-top" src="<?php echo $row->wptIMG; ?>" alt="<?php echo $row->waypoint; ?>"-->
                <?php endif; ?>
                <div class="card-header">
                    <h5 class="float-left"><?php echo $row->waypoint; ?></h5>
                    <a href="waypoint.php?id=<?php echo $row->wptID; ?>" role="button" class="btn btn-primary btn-sm float-right">Details</a>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Unit</dt><dd><?php echo $row->unitType; ?> <?php echo $row->unit; ?></dd>
                        <dt>Place</dt><dd><?php echo $row->place; ?></dd>
                        <dt>Latitude</dt><dd><?php echo $row->latitude; ?></dd>
                        <dt>Longitude</dt><dd><?php echo $row->longitude; ?></dd>
                        <dt>Elevation</dt><dd><?php echo $row->elevation; ?></dd>
                        <dt>Time</dt><dd><?php echo $row->time; ?></dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <span class="badge badge-secondary"><?php echo $row->wptNote; ?></span>
                    <span class="float-right">ID#<span class="badge badge-secondary badge-pill"><?php echo $row->wptID; ?></span></span>
                </div>
            </div>
        </div>
            <?php
                }
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
