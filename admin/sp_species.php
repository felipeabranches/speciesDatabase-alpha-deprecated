<?php
include_once '../init.php';
$page_title = 'Species';
$order_by = $_GET['order_by'];

// Species class
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
            <div class="float-right">
                <a href="sp_specie.php?id=0" class="btn btn-primary btn-sm" role="button"><i class="fas fa-plus"></i>New</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php
                $sql = 'SELECT
                            s.id AS id, s.incertae_sedis AS incertae_sedis, s.validate AS validate, s.redirect AS redirect, s.published AS published, t.name AS taxon
                        FROM sp_species AS s
                        INNER JOIN sp_taxa AS t
                            ON t.id = s.id_taxon
                        ORDER BY '.$order_by.'
                        ';

                $result = mysqli_query($mysqli, $sql);
                ?>
                <?php if (!$result->num_rows): ?>
                <span>No entries</span>
                <?php else: ?>
                <!-- Table -->
                <table class="table table-striped table-hover table-sm">
                    <caption>Species</caption>
                    <thead>
                        <tr width="100%">
                            <th width="5%"><a href="sp_species.php?order_by=id">ID</a></th>
                            <th width="45%"><a href="sp_species.php?order_by=genus,specie">Species</a></th>
                            <th width="22.5%"><a href="sp_species.php?order_by=taxon,genus,specie">Taxon</a></th>
                            <th width="22.5%"><a href="sp_species.php?order_by=validate">Validate</a></th>
                            <th width="5%" colspan="2"><a href="sp_species.php?order_by=published">State</a></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_object($result)): ?>
                        <?php
                        $id = $row->id;
                        // Incertae sedis
                        $incertae_sedis = (!$row->incertae_sedis) ? '' : ' >> <em>Incertae serdis</em>';
                        // Validade
                        if (!$row->validate):
                            $redirect = (!$row->redirect) ? '' : ' (ID: '.$row->redirect.')';
                            $validate='<span class="badge badge-warning">Synonym'.$redirect.'</span>';
                        else:
                            $validate='<span class="badge badge-info">Accepted</span>';
                        endif;
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td>
                                <a href="sp_specie.php?id=<?php echo $id; ?>"><?php echo $species->getNomenclature($id); ?></a>
                                <span class="badge badge-dark"><?php echo $species->getAuthoring($id); ?></span>
                            </td>
                            <td><?php echo $row->taxon.$incertae_sedis; ?></td>
                            <td><?php echo $validate; ?></td>
                            <td><?php echo (!$row->published) ? '<i class="fas fa-toggle-off"></i>' : '<i class="fas fa-toggle-on"></i>'; ?></td>
                            <td><a data-toggle="modal" data-target="#modal-<?php echo $id; ?>"><i class="fas fa-trash-alt"></i></a></td>
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
</body>
</html>
