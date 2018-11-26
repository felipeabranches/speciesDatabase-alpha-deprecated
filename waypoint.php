<?php
include_once 'init.php';
$id = $_GET['id'];
$page_title = 'Waypoint';

include_once 'libraries/campaigns/waypoints.php';
$waypoint = new Waypoints;
$result = mysqli_query($mysqli, $waypoint->getWaypoint($id));
$wpt = mysqli_fetch_object($result);
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="<?php echo $author; ?>">
	<title><?php echo (!$result->num_rows) ? 'No '.$page_title : $wpt->name; ?> - <?php echo $site_name; ?></title>
    <?php include_once 'modules/head.php'; ?>
</head>

<body class="bg-light">
<?php include_once 'modules/menu.php'; ?>
<div class="container-fluid" role="main">
    <div class="toolbar sticky-top row my-2 p-2">
        <div class="col-12">
            <?php if (!$result->num_rows): ?>
            <h4>No entries</h4>
            <?php else: ?>
            <h4 class="float-left"><?php echo $wpt->name; ?></h4>
            <span class="float-right">ID#<span class="badge badge-secondary badge-pill"><?php echo $wpt->id; ?></span></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
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

                if (!$result->num_rows): ?>
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

        <div class="col-12 col-md-6">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h5>Tombs</h5>
                <?php $tbResult = mysqli_query($mysqli, $waypoint->getTombs($id)); ?>
                <?php if (!$tbResult->num_rows): ?>
                <p>No entries</p>
                <?php else: ?>
                <table class="table table-striped table-hover table-sm small">
                    <caption>Tombs</caption>
                    <thead>
                        <tr>
                            <th scope="col">Tomb</th>
                            <th scope="col">Specie</th>
                            <th scope="col">Waypoint</th>
                            <th scope="col">N</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nTotal = 0; ?>
                        <?php while ($tb = mysqli_fetch_object($tbResult)): ?>
                        <tr scope="row">
                            <td><a href="tomb.php?id=<?php echo $tb->tombID; ?>"><?php echo $tb->tomb; ?></a></td>
                            <td><a href="specie.php?id=<?php echo $tb->spID; ?>"><?php echo $tb->nomenclature; ?></a></td>
                            <td>
                                <a href="waypoint.php?id=<?php echo $tb->wptID; ?>"><?php echo $tb->waypoint; ?></a>
                                <?php if ($tb->wptNote): ?>
                                <span data-toggle="tooltip" data-placement="top" title="<?php echo $tb->wptNote; ?>"><i class="fas fa-info-circle"></i></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $tb->n; ?>
                                <?php if ($tb->tbNote): ?>
                                <span data-toggle="tooltip" data-placement="top" title="<?php echo $tb->tbNote; ?>"><i class="fas fa-info-circle"></i></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $nTotal += $tb->n; ?>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr scope="row">
                            <td colspan="3">Total</td>
                            <td><?php echo $nTotal; ?></td>
                        </tr>
                    </tfoot>
                </table>
                <?php endif; ?>
                <?php mysqli_free_result($tbResult); ?>
            </div>

            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h5>Campaigns</h5>
                <?php $cpResult = mysqli_query($mysqli, $waypoint->getCampaigns($id)); ?>
                <?php if (!$cpResult->num_rows): ?>
                <p>No entries</p>
                <?php else: ?>
                <?php while ($cp = mysqli_fetch_object($cpResult)): ?>
                <p><?php echo $cp->name; ?> <span class="badge badge-secondary"><?php echo $cp->note; ?></span></p>
                <?php endwhile; ?>
                <?php endif; ?>
                <?php mysqli_free_result($cpResult); ?>
            </div>
        </div>
    </div>
</div>
<?php mysqli_close($mysqli); ?>
<?php include_once 'modules/footer.php'; ?>
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>
</body>
</html>