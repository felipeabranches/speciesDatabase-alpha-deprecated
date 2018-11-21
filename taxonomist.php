<?php
include_once 'init.php';
$id = $_GET['id'];

include_once 'libraries/species/taxonomists.php';
$taxonomist = new Taxonomists;
$ttResult = mysqli_query($mysqli, $taxonomist->getTaxonomist($id));
$tt = mysqli_fetch_object($ttResult);
$spResult = mysqli_query($mysqli, $taxonomist->getSpecies($id));
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="<?php echo $author; ?>">
	<title><?php echo (!$ttResult->num_rows) ? 'No entries' : $tt->author; ?> - <?php echo $site_name; ?></title>
    <?php include_once 'modules/head.php'; ?>
</head>

<body class="bg-light">
<?php include_once 'modules/menu.php'; ?>
<div class="container-fluid" role="main">
    <div class="toolbar sticky-top row my-2 p-2">
        <div class="col-12">
            <?php if (!$ttResult->num_rows): ?>
            <h4>No entries</h4>
            <?php else: ?>
            <h4 class="float-left"><?php echo $tt->author; ?></h4>
            <span class="float-right">ID#<span class="badge badge-secondary badge-pill"><?php echo $tt->ttID; ?></span></span>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!$ttResult->num_rows): ?>
    <div class="row">
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <p>No entries</p>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php if ($tt->image): ?>
                <img class="card-img-top" src="<?php echo $tt->image; ?>" alt="<?php echo $tt->author; ?>">
                <?php endif; ?>
                <span class="badge badge-secondary"><?php echo $tt->note; ?></span>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php echo $tt->description; ?>
            </div>
        </div>
        <?php mysqli_free_result($ttResult); ?>
        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h5>Species</h5>
                <?php if (!$spResult->num_rows): ?>
                <p>No entries</p>
                <?php else: ?>
                <table class="table table-striped table-hover table-sm small">
                    <caption>Species</caption>
                    <thead>
                        <tr>
                            <th scope="col">Specie</th>
                            <th scope="col">Year</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $spTotal = 0;
                    while ($sp = mysqli_fetch_object($spResult)):
                        ?>
                        <tr scope="row">
                            <td><a href="specie.php?id=<?php echo $sp->spID; ?>" target="_blank"><?php echo $sp->nomenclature; ?></a></td>
                            <td><?php echo $sp->year; ?></td>
                        </tr>
                        <?php
                        $spTotal++;
                    endwhile;
                    ?>
                    </tbody>
                    <tfoot>
                        <tr scope="row">
                            <td colspan="2">Total: <?php echo $spTotal; ?> species</td>
                        </tr>
                    </tfoot>
                </table>
                <?php endif; ?>
                <?php mysqli_free_result($spResult); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php mysqli_close($mysqli); ?>
</div>
<?php include_once 'modules/footer.php'; ?>
</body>
</html>