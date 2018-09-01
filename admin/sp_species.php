<?php
include_once '../init.php';
$page_title = 'Species';
$page_count = 10;
$order_by = $_GET['order_by'];
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
        <div class="col-12 col-md-10">
            <h4><?php echo $page_title; ?></h4>
        </div>
        <div class="col-12 col-md-2">
            <a href="sp_specie.php?id=0" class="btn btn-primary float-right" role="button">New</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <table class="table table-striped table-hover table-sm">
                    <tr width="100%">
                        <th width="5%"><a href="sp_species.php?order_by=id">ID</a></th>
                        <th width="50%"><a href="sp_species.php?order_by=gender,specie">Name</a></th>
                        <th width="20%"><a href="sp_species.php?order_by=taxon">Taxon</a></th>
                        <th width="20%"><a href="sp_species.php?order_by=validate">Validate</a></th>
                        <th width="5%" colspan="2"><a href="sp_species.php?order_by=published">State</a></th>
                    </tr>
                    <?php
                    $sql = 'SELECT s.id AS id, s.gender AS gender, s.specie AS specie, s.dubious AS dubious, s.incertae_sedis AS incertae_sedis, s.validate AS validate, s.redirect AS redirect, s.published AS published, t.name AS taxon
                            FROM sp_species AS s
                            INNER JOIN sp_taxa AS t
                            ON t.id = s.id_taxon
                            ORDER BY '.$order_by.'
                            ';

                    if ($result=mysqli_query ($mysqli,$sql))
                    {
                        if ($result->num_rows)
                        {
                            // Fetch one and one row
                            while ($row = mysqli_fetch_assoc ($result))
                            {
                                // Nomenclature
                                switch($row['dubious'])
                                {
                                    case 1:
                                        $dubious = ' <abbr title="affinis">aff.</abbr>';
                                        break;
                                    case 2:
                                        $dubious = ' <abbr title="conferre">cf.</abbr>';
                                        break;
                                    case 3:
                                        $dubious = ' <abbr title="specie">sp.</abbr>';
                                        break;
                                    case 0:
                                    default:
                                        $dubious = '';
                                }
                                $nomenclature = '<em>'.$row['gender'].$dubious.' '.$row['specie'].'</em>';
                                // Incertae sedis
                                $incertae_sedis = ($row['incertae_sedis']) ? ' >> <em>Incertae serdis</em>' : '';
                                // Validade
                                if ($row['validate'])
                                {
                                    $validate='<span class="badge badge-info">Accepted</span>';
                                }
                                else
                                {
                                    $redirect = ($row['redirect']) ? ' (ID: '.$row['redirect'].')' : '';
                                    $validate='<span class="badge badge-warning">Synonym'.$redirect.'</span>';
                                }
                                // Published
                                if ($row['published'])
                                {
                                    $published='<i class="fas fa-toggle-on"></i>';
                                }
                                else
                                {
                                    $published='<i class="fas fa-toggle-off"></i>';
                                }
                                echo '<tr>';
                                echo '<td>'.$row['id'].'</td>';
                                echo '<td><a href="sp_specie.php?id='.$row['id'].'">'.$nomenclature.'</a></td>';
                                echo '<td>'.$row['taxon'].$incertae_sedis.'</td>';
                                echo '<td>'.$validate.'</td>';
                                echo '<td>'.$published.'</td>';
                                echo '<td><a data-toggle="modal" data-target="#modal-'.$row['id'].'"><i class="fas fa-trash-alt"></i></a></td>';
                                echo '</tr>';
                                echo '<!-- Modal -->
                                    <div class="modal" id="modal-'.$row['id'].'" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete <strong>'.$nomenclature.'</strong> (ID: '.$row['id'].')?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="modules/sp_species_delete.php?id='.$row['id'].'" class="btn btn-danger">Delete</a>
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            }
                            // Free result set
                            mysqli_free_result ($result);
                        }
                        else
                        {
                            echo '<tr><td colspan="6">No entries</td></tr>';
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once '../modules/footer.php'; ?>
<!-- Fontawesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</body>
</html>
