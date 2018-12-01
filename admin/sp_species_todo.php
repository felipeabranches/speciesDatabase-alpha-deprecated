<?php
include_once '../init.php';
$page_title = 'Species To Do';
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
                                    sp.id AS id, CONCAT(sp.genus, " ", sp.specie) AS nomenclature, sp.image
                                FROM sp_species AS sp
                                LEFT JOIN camp_tombs AS tb
                                    ON tb.id_specie = sp.id
                                WHERE sp.published = 1
                                    AND tb.published = 1
                                GROUP BY sp.id
                                ORDER BY sp.genus, sp.specie
                                ;';
                        $result = mysqli_query($mysqli, $sql);
                        ?>
                        <?php $spCount = 0; ?>
                        <?php if (!$result->num_rows): ?>
                        <p class="card-text">No entries</p>
                        <?php else: ?>
                        <ul class="card-text">
                            <?php while ($sp = mysqli_fetch_object($result)): ?>
                                <?php if (!$sp->image || !file_exists('../'.$sp->image)): ?>
                                    <li><a href="sp_specie.php?id=<?php echo $sp->id; ?>" target="_blank"><?php echo $sp->nomenclature; ?></a></li>
                                    <?php $spCount++; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                        <?php mysqli_free_result($result); ?>
                    </div>
                    <div class="card-footer">Total: <?php echo $spCount; ?></div>
                </div>

                <div class="card">
                    <h5 class="card-header">Common Name</h5>
                    <div class="card-body">
                        <?php
                        $sql = 'SELECT
                                    sp.id AS id, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                                FROM sp_species AS sp
                                LEFT JOIN camp_tombs AS tb
                                    ON tb.id_specie = sp.id
                                WHERE sp.published = 1
                                    AND sp.common_name = ""
                                    AND tb.published = 1
                                GROUP BY sp.id
                                ORDER BY sp.genus, sp.specie
                                ;';
                        $result = mysqli_query($mysqli, $sql);
                        ?>
                        <?php $spCount = 0; ?>
                        <?php if (!$result->num_rows): ?>
                        <p class="card-text">No entries</p>
                        <?php else: ?>
                        <ul class="card-text">
                            <?php while ($sp = mysqli_fetch_object($result)): ?>
                                <li><a href="sp_specie.php?id=<?php echo $sp->id; ?>" target="_blank"><?php echo $sp->nomenclature; ?></a></li>
                                <?php $spCount++; ?>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                        <?php mysqli_free_result($result); ?>
                    </div>
                    <div class="card-footer">Total: <?php echo $spCount; ?></div>
                </div>

                <div class="card">
                    <h5 class="card-header">Etymology</h5>
                    <div class="card-body">
                        <?php
                        $sql = 'SELECT
                                    sp.id AS id, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                                FROM sp_species AS sp
                                LEFT JOIN camp_tombs AS tb
                                    ON tb.id_specie = sp.id
                                WHERE sp.published = 1
                                    AND sp.etymology = ""
                                    AND tb.published = 1
                                GROUP BY sp.id
                                ORDER BY sp.genus, sp.specie
                                ;';
                        $result = mysqli_query($mysqli, $sql);
                        ?>
                        <?php $spCount = 0; ?>
                        <?php if (!$result->num_rows): ?>
                        <p class="card-text">No entries</p>
                        <?php else: ?>
                        <ul class="card-text">
                            <?php while ($sp = mysqli_fetch_object($result)): ?>
                                <li><a href="sp_specie.php?id=<?php echo $sp->id; ?>" target="_blank"><?php echo $sp->nomenclature; ?></a></li>
                                <?php $spCount++; ?>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                        <?php mysqli_free_result($result); ?>
                    </div>
                    <div class="card-footer">Total: <?php echo $spCount; ?></div>
                </div>
                
                <div class="card">
                    <h5 class="card-header">Habitat</h5>
                    <div class="card-body">
                        <?php
                        $sql = 'SELECT
                                    sp.id AS id, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                                FROM sp_species AS sp
                                LEFT JOIN camp_tombs AS tb
                                    ON tb.id_specie = sp.id
                                WHERE sp.published = 1
                                    AND sp.habitat = ""
                                    AND tb.published = 1
                                GROUP BY sp.id
                                ORDER BY sp.genus, sp.specie
                                ;';
                        $result = mysqli_query($mysqli, $sql);
                        ?>
                        <?php $spCount = 0; ?>
                        <?php if (!$result->num_rows): ?>
                        <p class="card-text">No entries</p>
                        <?php else: ?>
                        <ul class="card-text">
                            <?php while ($sp = mysqli_fetch_object($result)): ?>
                                <li><a href="sp_specie.php?id=<?php echo $sp->id; ?>" target="_blank"><?php echo $sp->nomenclature; ?></a></li>
                                <?php $spCount++; ?>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                        <?php mysqli_free_result($result); ?>
                    </div>
                    <div class="card-footer">Total: <?php echo $spCount; ?></div>
                </div>
                
                <div class="card">
                    <h5 class="card-header">Distribution</h5>
                    <div class="card-body">
                        <?php
                        $sql = 'SELECT
                                    sp.id AS id, CONCAT(sp.genus, " ", sp.specie) AS nomenclature
                                FROM sp_species AS sp
                                LEFT JOIN camp_tombs AS tb
                                    ON tb.id_specie = sp.id
                                WHERE sp.published = 1
                                    AND sp.distribution = ""
                                    AND tb.published = 1
                                GROUP BY sp.id
                                ORDER BY sp.genus, sp.specie
                                ;';
                        $result = mysqli_query($mysqli, $sql);
                        ?>
                        <?php $spCount = 0; ?>
                        <?php if (!$result->num_rows): ?>
                        <p class="card-text">No entries</p>
                        <?php else: ?>
                        <ul class="card-text">
                            <?php while ($sp = mysqli_fetch_object($result)): ?>
                                <li><a href="sp_specie.php?id=<?php echo $sp->id; ?>" target="_blank"><?php echo $sp->nomenclature; ?></a></li>
                                <?php $spCount++; ?>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                        <?php mysqli_free_result($result); ?>
                    </div>
                    <div class="card-footer">Total: <?php echo $spCount; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php mysqli_close($mysqli); ?>
<?php include_once '../modules/footer.php'; ?>
</body>
</html>