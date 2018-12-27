<?php
include_once '../../init.php';
$page_title = 'Tombs';
$id = $_GET['id'];
$where = (!$_GET['where'] || $_GET['where'] == NULL) ? '' : $_GET['where'];
$order_by = $_GET['order_by'];

include_once $base_dir.'/libraries/museum/tombs.php';
$tombs = new Tombs;
$result = mysqli_query($mysqli, $tombs->getTombs($id, $where, $order_by));
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
            <span class="float-right">
                <button class="btn btn-info btn-sm disabled"><i class="fas fa-download"></i>Export as sheet</button>
                <a href="tombs_card.php?id=0" class="btn btn-info btn-sm" role="button"><i class="fas fa-print"></i>Print all Tombs' labels</a>
                <a href="tomb.php?id=0" class="btn btn-primary btn-sm" role="button"><i class="fas fa-plus"></i>New</a>
            </span>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php if (!$result->num_rows): ?>
                <span>No entries</span>
                <?php else: ?>
                <!-- Table -->
                <table class="table table-striped table-hover table-sm">
                    <caption>Tombs</caption>
                    <thead>
                        <tr width="100%">
                            <th width="5%"><a href="tombs.php?id=0&where&order_by=tb.id">ID</a></th>
                            <th width="15%"><a href="tombs.php?id=0&where&order_by=tb.name">Name</a></th>
                            <th width="15%"><a href="tombs.php?id=0&where&order_by=cp.name">Campaing</a></th>
                            <th width="30%"><a href="tombs.php?id=0&where&order_by=wpt.name">Waypoint</a></th>
                            <th width="25%"><a href="tombs.php?id=0&where&order_by=sp.genus,sp.specie">Specie</a></th>
                            <th width="5%"><a href="tombs.php?id=0&where&order_by=tb.specie_count">N</a></th>
                            <th width="5%" colspan="2"><a href="tombs.php?id=0&where&order_by=tb.published">State</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_object($result)): ?>
                        <tr>
                            <td><?php echo $row->tbID; ?></td>
                            <td>
                                <a href="tomb.php?id=<?php echo $row->tbID; ?>"><?php echo $row->tomb; ?></a>
                                <a href="tombs_card.php?id=<?php echo $row->tbID; ?>" class="badge badge-dark" title="Print <?php echo $row->tomb; ?> label"><i class="fas fa-print"></i></a>
                            </td>
                            <td><?php echo $row->campaign; ?></td>
                            <td>
                                <?php echo $row->waypoint; ?>
                                <?php if ($row->wptNote): ?>
                                <span class="badge badge-dark" ><?php echo $row->wptNote; ?></span>
                                <?php endif; ?>
                                <span data-toggle="tooltip" data-placement="top" title="<?php echo $row->latitude.'/'.$row->longitude; ?>"><i class="fas fa-globe-americas"></i></span>
                            </td>
                            <td><?php echo $row->genus.' '.$row->specie; ?></td>
                            <td>
                                <?php echo $row->n; ?>
                                <?php if ($row->tbNote): ?>
                                <span data-toggle="tooltip" data-placement="top" title="<?php echo $row->tbNote; ?>"><i class="fas fa-info-circle"></i></span>
                                <?php endif; ?>
                            </td>
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
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>
</body>
</html>
