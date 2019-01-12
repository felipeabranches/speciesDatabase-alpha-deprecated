<?php
include_once '../init.php';
$page_title = 'Waypoints';
$page_count = 10;
$order_by = $_GET['order_by'];
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
    <?php include_once $base_dir.'/modules/head.php'; ?>
</head>

<body class="bg-light">
<?php include_once $base_dir.'/admin/modules/menu.php'; ?>
<div class="container-fluid" role="main">
    <div class="toolbar sticky-top row my-2 p-2">
        <div class="col-12">
            <h4 class="float-left"><?php echo $page_title; ?></h4>
            <div class="float-right">
                <!-- Button trigger GPX modal -->
                <button class="btn btn-info btn-sm disabled" data-toggle="modal" data-target="#uploadGPX"><i class="fas fa-upload"></i>Import GPX file</button>
                <!-- GPX modal -->
                <div class="modal fade" id="uploadGPX" tabindex="-1" role="dialog" aria-labelledby="uploadGPXLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadGPXLabel">Carregar arquivo GPX</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Escolha um arquivo .gpx</label>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info">Carregar</button>
                                <button type="button" class="btn btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="wpt_waypoint.php?id=0" class="btn btn-primary btn-sm" role="button"><i class="fas fa-plus"></i>New</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php
                $sql = 'SELECT
                            wpt.id AS id, wpt.name AS name, wpt.latitude AS latitude, wpt.longitude AS longitude, wpt.elevation AS elevation, wpt.time AS time, wpt.note AS note, wpt.published AS published,
                            unt.name AS unit
                        FROM wpt_waypoints AS wpt
                        LEFT JOIN wpt_units AS unt
                            ON unt.id = wpt.id_unit
                        ORDER BY wpt.'.$order_by.'
                        ';
                $result = mysqli_query($mysqli, $sql);
                ?>
                <?php if (!$result->num_rows): ?>
                <span>No entries</span>
                <?php else: ?>
                <!-- Table -->
                <table class="table table-striped table-hover table-sm">
                    <caption>Waypoints</caption>
                    <thead>
                        <tr width="100%">
                            <th width="5%"><a href="wpt_waypoints.php?order_by=id">ID</a></th>
                            <th width="30%"><a href="wpt_waypoints.php?order_by=name">Name</a></th>
                            <th width="15%"><a href="wpt_waypoints.php?order_by=unit">Unit</a></th>
                            <th width="10%"><a href="wpt_waypoints.php?order_by=latitude">Latitude</a></th>
                            <th width="10%"><a href="wpt_waypoints.php?order_by=longitude">Longitude</a></th>
                            <th width="10%"><a href="wpt_waypoints.php?order_by=elevation">Elevation</a></th>
                            <th width="15%"><a href="wpt_waypoints.php?order_by=time">Time</a></th>
                            <th width="5%" colspan="2"><a href="wpt_waypoints.php?order_by=published">State</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_object($result)): ?>
                        <tr>
                            <td><?php echo $row->id; ?></td>
                            <td><a href="wpt_waypoint.php?id=<?php echo $row->id; ?>"><?php echo $row->name; ?></a> <span class="badge badge-dark"><?php echo $row->note; ?></span></td>
                            <td><?php echo $row->unit; ?></td>
                            <td><?php echo $row->latitude; ?></td>
                            <td><?php echo $row->longitude; ?></td>
                            <td><?php echo ($row->elevation == '0.000000') ? '-' : $row->elevation; ?></td>
                            <td><?php echo $row->time; ?></td>
                            <td><?php echo (!$row->published) ? '<i class="fas fa-toggle-off"></i>' : '<i class="fas fa-toggle-on"></i>'; ?></td>
                            <td><i class="fas fa-trash-alt"></i></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php endif; ?>
                <?php mysqli_free_result($result); ?>
            </div>
        </div>
    </div>
</div>
<?php include_once $base_dir.'/modules/footer.php'; ?>
</body>
</html>
