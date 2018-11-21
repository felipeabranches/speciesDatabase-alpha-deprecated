<?php
include_once 'init.php';
$page_title = 'Campaign';
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
        <div class="col-12 col-md-6">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php
                $sql = 'SELECT
                            c.id AS cID, c.name AS campaign, c.entity AS cEntity, c.date AS cDate, c.description AS description, c.note AS note, c.image AS image
                        FROM camp_campaings AS c
                        WHERE c.published = 1
                            AND c.id = '.$id.'
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
                <h4><?php echo $row->campaign; ?></h4>
                <?php if($row->image): ?>
                <figure class="figure">
                    <img src="<?php echo $row->image; ?>" alt="<?php echo $row->campaign; ?>" class="figure-img img-fluid rounded" />
                    <figcaption class="figure-caption">Foto: Nome, Ano (arquivo.JPG)</figcaption>
                </figure>
                <?php endif; ?>
                <p class="badge badge-dark"><?php echo $row->note; ?></p>
                <?php echo html_entity_decode($row->description); ?>
                <!--pre><?php print_r($row->waypoints); ?></pre-->
                        <?php
                        }
                        mysqli_free_result($result);
                    }
                }
                ?>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h5>Tombs</h5>
                <?php
                $sql = 'SELECT
                            tb.id AS tombID, tb.name AS tomb, tb.specie_count AS n, tb.note AS tbNote,
                            wpt.id AS wptID, wpt.name AS waypoint, wpt.note AS wptNote,
                            sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                        FROM camp_tombs AS tb
                        LEFT JOIN camp_campaings AS cp
                            ON cp.id = tb.id_campaing
                        LEFT JOIN camp_waypoints AS wpt
                            ON wpt.id = tb.id_waypoint
                        LEFT JOIN sp_species AS sp
                            ON sp.id = tb.id_specie
                        WHERE cp.id = '.$id.'
                        ';
                $result = mysqli_query($mysqli, $sql);
                if(!$result->num_rows)
                {
                    echo '<p>No entries</p>';
                }
                else
                {
                ?>
                <table class="table table-striped table-hover table-sm small">
                    <thead>
                        <tr>
                            <th scope="col">Tomb</th>
                            <th scope="col">Specie</th>
                            <th scope="col">Waypoint</th>
                            <th scope="col">N</th>
                        </tr>
                    </thead>
                    <tbody>
                        <caption>Tombs</caption>
                    <?php
                    $nTotal = 0;
                    while ($row = mysqli_fetch_object($result))
                    {
                    ?>
                        <tr scope="row">
                            <td><a href="tomb.php?id=<?php echo $row->tombID; ?>"><?php echo $row->tomb; ?></a></td>
                            <td><a href="specie.php?id=<?php echo $row->spID; ?>"><?php echo $row->nomenclature; ?></a></td>
                            <td>
                                <a href="waypoint.php?id=<?php echo $row->wptID; ?>"><?php echo $row->waypoint; ?></a>
                                <?php if ($row->wptNote): ?>
                                <span data-toggle="tooltip" data-placement="top" title="<?php echo $row->wptNote; ?>"><i class="fas fa-info-circle"></i></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $row->n; ?>
                                <?php if ($row->tbNote): ?>
                                <span data-toggle="tooltip" data-placement="top" title="<?php echo $row->tbNote; ?>"><i class="fas fa-info-circle"></i></span>
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
                            <td colspan="3">Total</td>
                            <td><?php echo $nTotal; ?></td>
                        </tr>
                    </tfoot>
                <?php
                }
                mysqli_free_result($result);
                ?>
                </table>
            </div>

            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h5>Waypoints</h5>
                <?php
                $sql = 'SELECT DISTINCT wpt.id AS wptID, wpt.name AS waypoints, wpt.note AS note
                        FROM camp_tombs AS tb
                        LEFT JOIN camp_campaings AS cp
                            ON cp.id = tb.id_campaing
                        LEFT JOIN camp_waypoints AS wpt
                            ON wpt.id = tb.id_waypoint
                        WHERE tb.published = 1
                            AND cp.id = '.$id.'
                        ORDER BY wpt.id
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
                <p><?php echo $row->waypoints; ?> <span class="badge badge-light"><?php echo $row->note; ?></span></p>
                        <?php
                        }
                        mysqli_free_result($result);
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