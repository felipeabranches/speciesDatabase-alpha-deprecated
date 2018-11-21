<?php
include_once 'init.php';
$page_title = 'Waypoints';
$id = (!$_GET['id']) ? '' : ' AND wpt.id IN ('.$_GET['id'].')';
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
            <h4><?php echo $page_title; ?></h4>
        </div>
    </div>
    <div class="row">
        <?php
        $sql = 'SELECT
                    wpt.id AS wptID, wpt.name AS waypoint, wpt.place AS place, wpt.latitude AS latitude, wpt.longitude AS longitude, wpt.elevation AS elevation, wpt.time As time, wpt.note As note, wpt.image As image,
                    unit.name AS unit,
                    untt.name AS unitType
                FROM camp_waypoints AS wpt
                LEFT JOIN camp_units AS unit
                    ON unit.id = wpt.id_unit
                LEFT JOIN camp_units_types AS untt
                    ON untt.id = unit.id_type
                WHERE wpt.published = 1 '.$id.'
                ORDER BY wpt.id
                ';
        if($result = mysqli_query($mysqli,$sql))
        {
            if(!$result->num_rows)
            {
                echo '<p>No entries</p>';
            }
            else
            {
                // Fetch one and one row
                while ($row = mysqli_fetch_object($result))
                {
                ?>
        <div class="col-12 col-md-4">
            <div class="card mt-3 mb-3">
                <?php if ($row->image): ?>
                <img class="card-img-top" src="<?php echo $row->image; ?>" alt="<?php echo $row->waypoint; ?>">
                <?php endif; ?>
                <div class="card-header">
                    <h5 class="float-left"><?php echo $row->waypoint; ?></h5>
                    <a href="waypoint.php?id=<?php echo $row->wptID; ?>" role="button" class="btn btn-primary btn-sm float-right">Details</a>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Unit</dt>
                        <dd><?php echo $row->unitType; ?> <?php echo $row->unit; ?></dd>
                        <dt>Place</dt>
                        <dd><?php echo $row->place; ?></dd>
                        <dt>Latitude</dt>
                        <dd><?php echo $row->latitude; ?></dd>
                        <dt>Longitude</dt>
                        <dd><?php echo $row->longitude; ?></dd>
                        <dt>Elevation</dt>
                        <dd><?php echo $row->elevation; ?></dd>
                        <dt>Time</dt>
                        <dd><?php echo $row->time; ?></dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <span class="badge badge-secondary"><?php echo $row->note; ?></span>
                    <span class="float-right">ID#<span class="badge badge-secondary badge-pill"><?php echo $row->wptID; ?></span></span>
                </div>
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
