<?php
include_once '../init.php';
$page_title = 'Species To Do';
$clause = ' AND tb.published = 1';

require_once $base_dir.'/libraries/species/species.php';
$species = new Species();
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
        </div>
    </div>

    <div class="row">
        <div class="col-12 my-2">
            <div class="card-columns">
                <div class="card">
                    <h5 class="card-header">Images</h5>
                    <div class="card-body">
                        <?php
                        $sql = 'SELECT
                                    sp.id AS id, sp.image
                                FROM sp_species AS sp
                                LEFT JOIN camp_tombs AS tb
                                    ON tb.id_specie = sp.id
                                WHERE sp.published = 1
                                    '.$clause.'
                                GROUP BY sp.id
                                ORDER BY sp.genus, sp.specie
                                ;';
                        $result = mysqli_query($mysqli, $sql);
                        $spCount = 0;
                        ?>
                        <?php if (!$result->num_rows): ?>
                        <p class="card-text">No entries</p>
                        <?php else: ?>
                        <ul class="card-text">
                            <?php while ($sp = mysqli_fetch_object($result)): ?>
                            <?php if (!$sp->image || !file_exists('../'.$sp->image)): ?>
                            <li><a href="sp_specie.php?id=<?php echo $sp->id; ?>" target="_blank"><?php echo $species->getNomenclature($sp->id); ?></a></li>
                            <?php $spCount++; ?>
                            <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <div>Falta: <?php echo $spCount; ?></div>
                        <?php $conclude = round(((($spCount/$result->num_rows)*100)-100)*(-1)); ?>
                        <div>Concluído: <?php echo $conclude; ?>%</div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $conclude; ?>%" aria-valuenow="<?php echo $conclude; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $conclude; ?>%</div>
                        </div>
                    </div>
                </div>
                <?php mysqli_free_result($result); ?>

                <?php
                $blockTitle = 'Common Name';
                $field = 'common_name';
                $clause = $clause;
                include $base_dir.'/admin/modules/species_todo/card.php';
                ?>

                <?php
                $blockTitle = 'Etymology';
                $field = 'etymology';
                $clause = $clause;
                include $base_dir.'/admin/modules/species_todo/card.php';
                ?>

                <?php
                $blockTitle = 'Habitat';
                $field = 'habitat';
                $clause = $clause;
                include $base_dir.'/admin/modules/species_todo/card.php';
                ?>

                <?php
                $blockTitle = 'Distribution';
                $field = 'distribution';
                $clause = $clause;
                include $base_dir.'/admin/modules/species_todo/card.php';
                ?>
            </div>
        </div>
    </div>
</div>
<?php mysqli_close($mysqli); ?>
<?php include_once $base_dir.'/modules/footer.php'; ?>
</body>
</html>