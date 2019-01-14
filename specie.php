<?php
include_once 'init.php';
$id = $_GET['id'];

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
	<title><?php echo $species->getNomenclature($id, 1); ?> - <?php echo $site_name; ?></title>
    <?php include_once $base_dir.'/modules/head.php'; ?>
</head>

<body class="bg-light">
<?php include_once $base_dir.'/modules/menu.php'; ?>
<div class="container-fluid" role="main">
    <div class="toolbar sticky-top row my-2 p-2">
        <div class="col-12">
            <!-- Nomenclature and Authoring -->
            <div class="nomenclature">
                <h4 class="specie"><?php echo $species->getNomenclature($id); ?></h4>
                <span class="taxonomist"><?php echo $species->getAuthoring($id); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-8">
            <?php
            $sql = 'SELECT
                        sp.id AS id, sp.etymology AS etymology, sp.common_name AS common_name, sp.distribution AS distribution, sp.habitat AS habitat, sp.description AS description, sp.image AS image
                    FROM sp_species AS sp
                    WHERE sp.published = 1
                        AND sp.validate = 1
                        AND sp.id = '.$id.'
                    ';
            $result = mysqli_query($mysqli, $sql);
            ?>
            <?php if(!$result->num_rows): ?>
            <!-- Alert -->
            <div class="alert alert-warning mb-0" role="alert">
                <h5>No result!</h5>
                <p>You are trying to reach a species that don't have a record on our database.</p>
                <p>There's some actions you may take:</p>
                <ul>
                    <li>Check if the passed ID on browser url realy exists</li>
                    <li>Return to the <a href="index.php" class="alert-link">species list</a> and choose the desire species.</li>
                </ul>
                <hr>
                <p class="mb-0">If you think that it's not your mistake, enter in <a href="mailto:peixespnsc@gmail.com" class="alert-link">contact</a> and let us know.</p>
            </div>
            <?php else: ?>
            <?php $row = mysqli_fetch_object($result); ?>
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php if ($row->image && file_exists($row->image)): ?>
                <!-- Image -->
                <figure class="figure">
                    <img src="<?php echo $row->image; ?>" alt="<?php echo $species->getNomenclature($id, 1); ?>" class="figure-img img-fluid rounded" />
                    <figcaption class="figure-caption">Foto: Nome, Ano (arquivo.JPG)</figcaption>
                </figure>
                <?php endif; ?>
                <!-- Others infos -->
                <dl>
                <?php if ($row->etymology): ?>
                <dt>Etimologia</dt><dd><?php echo $row->etymology; ?></dd>
                <?php endif; ?>
                <?php if ($row->common_name): ?>
                <dt>Nome popular</dt><dd><?php echo $row->common_name; ?></dd>
                <?php endif; ?>
                <?php if ($row->distribution): ?>
                <dt>Distribuição</dt><dd><?php echo $row->distribution; ?></dd>
                <?php endif; ?>
                <?php if ($row->habitat): ?>
                <dt>Habitat</dt><dd><?php echo $row->habitat; ?></dd>
                <?php endif; ?>
                </dl>
                <!-- Description -->
                <?php echo $row->description; ?>
                <?php endif; ?>
                <?php mysqli_free_result($result); ?>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <!-- Tombs -->
                <h5>Tombs</h5>
                <?php
                require_once $base_dir.'/libraries/museum/tombs.php';
                $tombs = new Tombs;
                $tbResult = mysqli_query($mysqli, $tombs->getTinyTombs($id, 'WHERE tb.published=1', 'tb.id', 'sp'));
                ?>
                <?php if(!$tbResult->num_rows): ?>
                <span>No entries</span>
                <?php else: ?>
                <table class="table table-striped table-hover table-sm small">
                    <caption>Tombs</caption>
                    <thead>
                        <tr>
                            <th scope="col">Tomb</th>
                            <th scope="col">Campaign</th>
                            <th scope="col">Waypoint</th>
                            <th scope="col">N</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nTotal = 0; ?>
                        <?php while ($tb = mysqli_fetch_object($tbResult)): ?>
                        <tr scope="row">
                            <td><a href="tomb.php?id=<?php echo $tb->tbID; ?>"><?php echo $tb->tomb; ?></a></td>
                            <td><a href="campaign.php?id=<?php echo $tb->cpID; ?>"><?php echo $tb->campaign; ?></a></td>
                            <td>
                                <a href="waypoint.php?id=<?php echo $tb->wptID; ?>"><?php echo $tb->waypoint; ?></a>
                                <?php if ($tb->wptNote): ?>
                                <span data-toggle="tooltip" data-placement="top" title="<?php echo $tb->wptNote; ?>"><i class="fas fa-info-circle"></i></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $tb->n; ?></td>
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
                <!-- Synonyms -->
                <h5>Synonyms</h5>
                <?php
                $sql = $species->getSynonyms($id);
                $synonyms = mysqli_query($mysqli, $sql);
                ?>
                <?php if(!$synonyms->num_rows): ?>
                <span>No entries</span>
                <?php else: ?>
                <ul>
                <?php while ($row = mysqli_fetch_object($synonyms)): ?>
                <li><?php echo $species->getNomenclature($row->id); ?></li>
                <?php endwhile; ?>
                </ul>
                <?php endif; ?>
                <?php mysqli_free_result($synonyms); ?>
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
