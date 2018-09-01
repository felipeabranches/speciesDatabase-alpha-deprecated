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
    <?php include_once '../modules/head.php'; ?>
</head>

<body class="bg-light">
<?php include_once 'modules/menu.php'; ?>
<div class="container-fluid" role="main">
    <div class="row my-2 p-2">
        <div class="col-12 col-md-6">
            <h4><?php echo $page_title; ?></h4>
        </div>
        <div class="col-12 col-md-6">
            <!-- Button trigger GPX modal -->
            <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#uploadGPX">Importar de arquivo GPX</button>
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
            <a href="camp_waypoint.php?id=0" class="btn btn-primary float-right" role="button">New</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class=" my-3 p-3 bg-white rounded box-shadow">
                <table class="table table-striped table-hover table-sm">
                    <tr width="100%">
                        <th width="5%"><a href="camp_waypoints.php?order_by=id">ID</a></th>
                        <th width="45%"><a href="camp_waypoints.php?order_by=name">Name</a></th>
                        <th width="15%"><a href="camp_waypoints.php?order_by=latitude">Latitude</a></th>
                        <th width="15%"><a href="camp_waypoints.php?order_by=longitude">Longitude</a></th>
                        <th width="15%"><a href="camp_waypoints.php?order_by=date">Date</a></th>
                        <th width="5%" colspan="2">State</th>
                    </tr>
                    <?php
                    $sql = 'SELECT cs.id AS id, cs.name AS name, cs.latitude AS latitude, cs.longitude AS longitude, cs.date AS date, cs.published AS published
                            FROM camp_spots AS cs
                            ORDER BY cs.'.$order_by.'
                            ';

                    if ($result=mysqli_query ($mysqli,$sql))
                    {
                        if ($result->num_rows)
                        {
                            // Fetch one and one row
                            while ($row = mysqli_fetch_assoc ($result))
                            {
                                if ($row['published'])
                                {
                                    $published='<i class="fas fa-toggle-on"></i>';
                                }
                                else
                                {
                                    $published='<i class="fas fa-toggle-off"></i>';
                                }
                                echo '<tr>';
                                echo '<td>'.$row['id'].'</td>';
                                echo '<td><a href="camp_waypoint.php?id='.$row['id'].'">'.$row['name'].'</a></td>';
                                echo '<td>'.$row['latitude'].'</td>';
                                echo '<td>'.$row['longitude'].'</td>';
                                echo '<td>'.$row['date'].'</td>';
                                echo '<td>'.$published.'</td>';
                                echo '<td><!--a data-toggle="modal" data-target="#modal-'.$row['id'].'"><i class="fas fa-trash-alt"></i></a--></td>';
                                echo '</tr>';
                                echo '<!-- Modal >
                                    <div class="modal" id="modal-'.$row['id'].'" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete <strong>'.$row['name'].'</strong> (ID: '.$row['id'].')?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="modules/camp_waypoints_delete.php?id='.$row['id'].'" class="btn btn-danger">Delete</a>
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div-->';
                            }
                            // Free result set
                            mysqli_free_result ($result);
                        }
                        else
                        {
                            echo '<tr><td colspan="4">No entries</td></tr>';
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once '../modules/footer.php'; ?>
<!-- Fontawesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</body>
</html>
