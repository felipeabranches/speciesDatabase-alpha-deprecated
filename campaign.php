<?php
include_once 'init.php';
$id = $_GET['id'];
$page_title = 'Campaign';

include_once 'libraries/campaigns/campaigns.php';
$campaign = new Campaigns;
$result = mysqli_query($mysqli, $campaign->getCampaign($id));
$cp = mysqli_fetch_object($result);
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="<?php echo $author; ?>">
	<title><?php echo (!$result->num_rows) ? 'No '.$page_title : $cp->name; ?> - <?php echo $site_name; ?></title>
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
            <h4 class="float-left"><?php echo $cp->name; ?></h4>
            <span class="float-right">ID#<span class="badge badge-secondary badge-pill"><?php echo $cp->id; ?></span></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php if (!$result->num_rows): ?>
                <p>No entries</p>
                <?php else: ?>
                <?php if ($cp->image): ?>
                <figure class="figure">
                    <img src="<?php echo $cp->image; ?>" alt="<?php echo $cp->name; ?>" class="figure-img img-fluid rounded" />
                    <figcaption class="figure-caption">Foto: Nome, Ano (arquivo.JPG)</figcaption>
                </figure>
                <?php endif; ?>
                <p class="badge badge-secondary"><?php echo $cp->note; ?></p>
                <?php echo html_entity_decode($cp->description); ?>
                <?php endif; ?>
                <?php mysqli_free_result($result); ?>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h5>Tombs</h5>
                <?php $tbResult = mysqli_query($mysqli, $campaign->getTombs($id)); ?>
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
                <h5>Waypoints</h5>
                <?php $wptResult = mysqli_query($mysqli, $campaign->getWaypoints($id)); ?>
                <?php if (!$wptResult->num_rows): ?>
                <p>No entries</p>
                <?php else: ?>
                <?php while ($wpt = mysqli_fetch_object($wptResult)): ?>
                <p><?php echo $wpt->name; ?> <span class="badge badge-secondary"><?php echo $wpt->note; ?></span></p>
                <?php endwhile; ?>
                <?php endif; ?>
                <?php mysqli_free_result($wptResult); ?>
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