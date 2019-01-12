<?php
include_once 'init.php';
$page_title = 'Tombs';
$id = $_GET['id'];
$order_by = $_GET['order_by'];

// Species class
require_once $base_dir.'/libraries/species/species.php';
$species = new Species();
// Tombs class
require_once $base_dir.'/libraries/museum/tombs.php';
$tombs = new Tombs;
$result = mysqli_query($mysqli, $tombs->getTombs($id, 'tb.published = 1', $order_by));
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
        <div class="col-6">
            <h4><?php echo $page_title; ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php if(!$result->num_rows): ?>
                <span>No entries</span>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm small">
                        <caption>Tombs</caption>
                        <thead>
                            <tr>
                                <th scope="col"><a href="tombs_table.php?id=0&order_by=tb.name">Tomb</a></th>
                                <th scope="col">Determinator</th>
                                <th scope="col">Determined</th>
                                <th scope="col"><a href="tombs_table.php?id=0&order_by=cp.name">Campaign</a></th>
                                <th scope="col">Collector</th>
                                <th scope="col">Collected</th>
                                <th scope="col"><a href="tombs_table.php?id=0&order_by=wpt.name">Waypoint</a></th>
                                <th scope="col">Unit</th>
                                <th scope="col">Place</th>
                                <th scope="col">Latitude</th>
                                <th scope="col">Longitude</th>
                                <th scope="col"><a href="tombs_table.php?id=0&order_by=sp.genus,sp.specie">Species</a></th>
                                <th scope="col">N</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nTotal = 0; ?>
                            <?php while ($row = mysqli_fetch_object($result)): ?>
                            <tr scope="row">
                                <td><a href="tomb.php?id=<?php echo $row->tbID; ?>"><?php echo $row->tomb; ?></a></td>
                                <td><?php echo $row->tbEntity; ?></td>
                                <td><?php echo $row->tbDate; ?></td>
                                <td><a href="campaign.php?id=<?php echo $row->cpID; ?>"><?php echo $row->campaign; ?></a></td>
                                <td><?php echo $row->cpEntity; ?></td>
                                <td><?php echo $row->cpDate; ?></td>
                                <td>
                                    <a href="waypoint.php?id=<?php echo $row->wptID; ?>"><?php echo $row->waypoint; ?></a>
                                    <?php if ($row->wptNote): ?>
                                        <span data-toggle="tooltip" data-placement="top" title="<?php echo $row->wptNote; ?>"><i class="fas fa-info-circle"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $row->unit; ?></td>
                                <td><?php echo $row->place; ?></td>
                                <td><?php echo $row->latitude; ?></td>
                                <td><?php echo $row->longitude; ?></td>
                                <td><a href="specie.php?id=<?php echo $row->spID; ?>"><?php echo $species->getNomenclature($row->spID); ?></a></td>
                                <td>
                                    <?php echo $row->n; ?>
                                    <?php if ($row->tbNote): ?>
                                        <span data-toggle="tooltip" data-placement="top" title="<?php echo $row->tbNote; ?>"><i class="fas fa-info-circle"></i></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $nTotal += $row->n; ?>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot scope="row">
                            <tr>
                                <td colspan="12">Total</td>
                                <td><?php echo $nTotal; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php endif; ?>
                <?php mysqli_free_result($result); ?>
                <?php mysqli_close($mysqli); ?>
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
</body>
</html>
