<?php
include_once 'init.php';
$page_title = 'Espécie';
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
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php
                $sql = 'SELECT sp.id AS id, sp.gender AS gender, sp.specie AS specie, sp.dubious AS dubious, sp.year AS year, sp.revised AS revised, sp.etymology AS etymology, sp.common_name AS common_name, sp.distribution AS distribution, sp.habitat AS habitat, sp.description AS description, sp.image AS image, GROUP_CONCAT(tx.name) AS taxonomists
                        FROM sp_taxonomists_map AS tx_map
                        LEFT JOIN sp_species AS sp
                            ON tx_map.id_specie = sp.id
                        LEFT JOIN sp_taxonomists AS tx
                            ON tx_map.id_taxonomist = tx.id
                        WHERE sp.published = 1
                            AND sp.validate = 1
                            AND sp.id = '.$id.'
                        ';
                $result = mysqli_query($mysqli, $sql);

                if(!$result->num_rows)
                {
                ?>
                <h4 class="alert-heading">Specie not found</h4>
                <div class="alert alert-warning my-4" role="alert">
                    <h5>No result!</h5>
                    <p>You are trying to reach a specie that don\'t have a record on our database.</p>
                    <p>There\'s some actions you may take:</p>
                    <ul>
                        <li>Check if the passed ID on browser url realy exists</li>
                        <li>Return to the <a href="species.php" class="alert-link">species list</a> and choose the desire spicie.</li>
                    </ul>
                    <hr>
                    <p class="mb-0">If you think that it\'s not your mistake, enter in <a href="mailto:peixespnsc@gmail.com" class="alert-link">contact</a> and let us know.</p>
                </div>
                <?php
                }
                else
                {
                    while($row = mysqli_fetch_object($result))
                    {
                        $dubious = $row->dubious;
                        switch ($dubious) {
                            case 0:
                                $dubious = '';
                                $abbr = '';
                                break;
                            case 1:
                                $dubious = ' aff.';
                                $abbr = ' <abbr title="affinis">aff.</abbr>';
                                break;
                            case 2:
                                $dubious = ' cf.';
                                $abbr = ' <abbr title="conferre">cf.</abbr>';
                                break;
                            case 3:
                                $dubious = ' sp.';
                                $abbr = ' <abbr title="specie">sp.</abbr>';
                                break;
                            default:
                                $dubious = '';
                                $abbr = '';
                                break;                                
                        }
                        $nomenclature = $row->gender;
                        $nomenclature .= $abbr;
                        $nomenclature .= ' '.$row->specie;
                        
                        $taxonomist = explode(',', $row->taxonomists);
                        if (count($taxonomist) == 1)
                        {
                            $taxonomist = $row->taxonomists;
                        }
                        else
                        {
                            $last = array_pop($taxonomist);
                            $firsts = implode(', ', $taxonomist);
                            $taxonomist = sprintf('%s & %s', $firsts, $last);
                        }
                        if(!$row->revised)
                        {
                            $identification = $taxonomist.', '.$row->year;
                        }
                        else
                        {
                            $identification = '('.$taxonomist.', '.$row->year.')';
                        }
                    ?>
                <div class="nomenclature">
                    <h4 class="specie"><?php echo $nomenclature; ?></h4>
                    <span class="taxonomist"><?php echo $identification; ?></span>
                </div>
                <figure class="figure">
                    <img src="<?php echo $row->image; ?>" alt="<?php echo $row->gender.$dubious.' '.$row->specie; ?>" class="figure-img img-fluid rounded" />
                    <figcaption class="figure-caption">Foto: Nome, Ano (arquivo.JPG)</figcaption>
                </figure>
                <dl>
                    <?php
                    if ($row->etymology)
                    {
                    ?>
                    <dt>Etimologia</dt><dd><?php echo $row->etymology; ?></dd>
                    <?php
                    }
                    if ($row->common_name)
                    {
                    ?>
                    <dt>Nome popular</dt><dd><?php echo $row->common_name; ?></dd>
                    <?php
                    }
                    if ($row->distribution)
                    {
                    ?>
                    <dt>Distribuição</dt><dd><?php echo $row->distribution; ?></dd>
                    <?php
                    }
                    if ($row->habitat)
                    {
                    ?>
                    <dt>Habitat</dt><dd><?php echo $row->habitat; ?></dd>
                    <?php
                    }
                    ?>
                </dl>
                    <?php
                        echo $row->description;
                    }
                }
                mysqli_free_result($result);
                ?>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h5>Tombos</h5>
                <?php
                $sql = 'SELECT t.id AS tombID, t.name AS tomb, t.specie_count AS n
                        FROM camp_tombs AS t
                        LEFT JOIN sp_species AS s
                            ON t.id_specie = s.id
                        WHERE s.id = '.$id.'
                        ';
                $result = mysqli_query($mysqli, $sql);
                if(!$result->num_rows)
                {
                    echo '<p>No entries</p>';
                }
                else
                {
                ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Tombo</th>
                            <th scope="col">N</th>
                        </tr>
                    </thead>
                    <?php
                    $nTotal = 0;
                    echo '<tbody>';
                    while ($row = mysqli_fetch_object($result))
                    {
                        echo '<tr scope="row">';
                        echo '<td><a href="tomb.php?id='.$row->tombID.'">'.$row->tomb.'</a></td>';
                        echo '<td>'.$row->n.'</td>';
                        echo '</tr>';
                        $nTotal += $row->n;
                    }
                    echo '</tbody>';
                    echo '<tfoot scope="row">';
                    echo '<tr>';
                    echo '<td>Total</td>';
                    echo '<td>'.$nTotal.'</td>';
                    echo '</tr>';
                    echo '</tfoot>';
                }
                mysqli_free_result($result);
                ?>
                </table>
            </div>

            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h5>Sinônimos</h5>
                <?php
                $sql = 'SELECT s.gender AS gender, s.specie AS specie
                        FROM sp_species AS s
                        WHERE s.validate = 0
                            AND s.redirect = '.$id.'
                        ';
                $result = mysqli_query($mysqli, $sql);
                if(!$result->num_rows)
                {
                    echo '<p>No entries</p>';
                }
                else
                {
                    echo '<ul>';
                    while ($row = mysqli_fetch_object($result))
                    {
                        echo '<li>'.$row->gender.' '.$row->specie.'</li>';
                    }
                    echo '</ul>';
                }
                mysqli_free_result($result);
                ?>
            </div>
        </div>
    </div>
</div>
<?php include_once 'modules/footer.php'; ?>
</body>
</html>