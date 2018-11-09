<?php
include_once 'init.php';
$page_title = 'Waypoint';
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
            <h4><?php echo $page_title; ?> #<?php echo $id; ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php
                $sql = 'SELECT
                            t.specie_count AS count,
                            wpt.name AS waypoint,
                            sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                        FROM camp_tombs AS t
                        LEFT JOIN camp_waypoints AS wpt
                            ON t.id_waypoint = wpt.id
                        LEFT JOIN sp_species AS sp
                            ON t.id_specie = sp.id
                        WHERE wpt.published = 1
                            AND wpt.id = '.$id.'
                        ';
                $result = mysqli_query($mysqli, $sql);

                if(!$result->num_rows): ?>
                <p>No entries</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm small">
                        <!--caption>Total species</caption-->
                        <thead>
                            <tr>
                                <th scope="col">Waypoint</th>
                                <?php
                                $array = '';
                                $cntTotal = 0;
                                while($row = mysqli_fetch_object($result)):
                                    $cnt = $row->count;
                                    $cntTotal += $cnt;
                                    $array[] .= $cnt;
                                    $wpt = $row->waypoint;
                                ?>
                                <th scope="col">
                                    <!--sp<?php echo $row->spID; ?>
                                    <span data-toggle="tooltip" data-placement="top" title="--><?php echo $row->nomenclature; ?><!--"><i class="fas fa-info-circle"></i></span>-->
                                </th>
                                <?php endwhile; ?>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $wpt; ?></td>
                                <?php foreach($array as $i): ?>
                                <td><?php echo $i; ?></td>
                                <?php endforeach; ?>
                                <td><?php echo $cntTotal; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <?php foreach($array as $i): ?>
                                <td>&nbsp;</td>
                                <?php endforeach; ?>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>pi</td>
                                <?php foreach($array as $i): ?>
                                <td><?php echo $i/$cntTotal; ?></td>
                                <?php endforeach; ?>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>lnpi</td>
                                <?php foreach($array as $i): ?>
                                <td><?php echo log($i/$cntTotal); ?></td>
                                <?php endforeach; ?>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>pi*lnpi</td>
                                <?php foreach($array as $i): ?>
                                <td><?php echo $i/$cntTotal*log($i/$cntTotal); ?></td>
                                <?php endforeach; ?>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Shannon</td>
                                <?php
                                $shannon = 0;
                                foreach($array as $i):
                                    $shannon += $i/$cntTotal*log($i/$cntTotal);
                                ?>
                                <td>&nbsp;</td>
                                <?php endforeach; ?>
                                <td><?php echo (!$shannon) ? 0 : -1*$shannon; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
                <?php mysqli_free_result($result); ?>
            </div>
        </div>
    </div>
</div>
<?php include_once 'modules/footer.php'; ?>
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>
<!-- Fontawesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</body>
</html>