<?php
include_once '../init.php';
$page_title = 'Admin Panel';
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
<?php include_once 'modules/panel_table.php'; ?>
<?php include_once 'modules/menu.php'; ?>
<div class="container-fluid" role="main">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php admin_panel_table ('Species', 'CONCAT(genus, " ", specie)', 'sp_species', 'id'); ?>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php admin_panel_table ('Taxa', 'name', 'sp_taxa', 'id'); ?>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php admin_panel_table ('Taxonomists', 'name', 'sp_taxonomists', 'id'); ?>
            </div>
        </div>
    </div>
</div>
<?php include_once '../modules/footer.php'; ?>
</body>
</html>
