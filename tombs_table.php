<?php
include_once 'init.php';
$page_title = 'Tombs';
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
        <div class="col-6 text-right">
            <button class="btn btn-primary disabled"><i class="fas fa-download"></i> Export as sheet</button>
            <a href="tombs_card.php?id=0" class="btn btn-primary" role="button"><i class="fas fa-print"></i> Print all Tombs' labels</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php
                $sql = 'SELECT
                            t.id AS id, t.name AS tomb, t.entity AS determinator, t.date AS tDate, t.specie_count AS n, t.note AS tmbNote,
                            camp.id AS campID, camp.name AS campaign, camp.date AS cDate, camp.entity AS collector,
                            wpt.name AS waypoint, wpt.place AS place, wpt.latitude AS latitude, wpt.longitude AS longitude, wpt.note AS wptNote,
                            un.name AS unit,
                            sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                        FROM camp_tombs AS t
                        LEFT JOIN camp_campaigns AS camp
                            ON camp.id = t.id_campaign
                        LEFT JOIN camp_waypoints AS wpt
                            ON wpt.id = t.id_waypoint
                        LEFT JOIN camp_units AS un
                            ON un.id = wpt.id_unit
                        LEFT JOIN sp_species AS sp
                            ON sp.id = t.id_specie
                        WHERE t.published = 1
                        ORDER BY t.id
                        ';

                if($result = mysqli_query($mysqli,$sql))
                {
                    if(!$result->num_rows)
                    {
                        echo '<p>No entries</p>';
                    }
                    else
                    {
                        ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm small">
                        <caption>Tombs</caption>
                        <thead>
                            <tr>
                                <th scope="col">Tomb</th>
                                <th scope="col">Campaign</th>
                                <th scope="col">Specie</th>
                                <th scope="col">Collected</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Waypoint</th>
                                <th scope="col">Place</th>
                                <th scope="col">Collector</th>
                                <th scope="col">Determinator</th>
                                <th scope="col">Determined</th>
                                <th scope="col">Latitude</th>
                                <th scope="col">Longitude</th>
                                <th scope="col">N</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nTotal = 0;
                            // Fetch one and one row
                            while ($row = mysqli_fetch_object($result))
                            {
                            ?>
                            <tr scope="row">
                                <td>
                                    <a href="tomb.php?id=<?php echo $row->id; ?>"><?php echo $row->tomb; ?></a>
                                    <a href="tombs_card.php?id=<?php echo $row->id; ?>" class="badge badge-dark" title="Print <?php echo $row->tomb; ?> label"><i class="fas fa-print"></i></a>
                                </td>
                                <td><a href="campaign.php?id=<?php echo $row->campID; ?>"><?php echo $row->campaign; ?></a></td>
                                <td><a href="specie.php?id=<?php echo $row->spID; ?>"><?php echo $row->nomenclature; ?></a></td>
                                <td><?php echo $row->cDate; ?></td>
                                <td><?php echo $row->unit; ?></td>
                                <td>
                                    <?php echo $row->waypoint; ?>
                                    <?php if ($row->wptNote): ?>
                                        <span data-toggle="tooltip" data-placement="top" title="<?php echo $row->wptNote; ?>"><i class="fas fa-info-circle"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $row->place; ?></td>
                                <td><?php echo $row->collector; ?></td>
                                <td><?php echo $row->determinator; ?></td>
                                <td><?php echo $row->tDate; ?></td>
                                <td><?php echo $row->latitude; ?></td>
                                <td><?php echo $row->longitude; ?></td>
                                <td>
                                    <?php echo $row->n; ?>
                                    <?php if ($row->tmbNote): ?>
                                        <span data-toggle="tooltip" data-placement="top" title="<?php echo $row->tmbNote; ?>"><i class="fas fa-info-circle"></i></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                                $nTotal += $row->n;
                            }
                        ?>
                        </tbody>
                        <tfoot scope="row">
                            <tr>
                                <td colspan="12">Total</td>
                                <td><?php echo $nTotal; ?></td>
                            </tr>
                        </tfoot>
                        <?php
                        // Free result set
                        mysqli_free_result($result);
                        ?>
                    </table>
                </div>
                <?php
                    }
                }
                mysqli_close($mysqli);
                ?>
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
