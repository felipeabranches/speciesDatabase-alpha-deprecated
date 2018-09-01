<?php
include_once 'init.php';
$page_title = 'Espécies';
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
                <h5>Peixes</h5>
                <?php
                $sql = 'SELECT sp.id AS id, CONCAT(sp.gender, " ", sp.specie) AS nomenclature, sp.year AS year, GROUP_CONCAT(tx.name) AS taxonomists
                        FROM sp_taxonomists_map AS tx_map
                        LEFT JOIN sp_species AS sp
                            ON tx_map.id_specie = sp.id
                        LEFT JOIN sp_taxonomists AS tx
                            ON tx_map.id_taxonomist = tx.id
                        WHERE sp.published = 1
                            AND validate = 1
                        GROUP BY sp.id
                        ORDER BY sp.gender, sp.specie
                        ';
                if($result=mysqli_query($mysqli,$sql))
                {
                    if($result->num_rows)
                    {
                        echo '<ul>'."\n";
                        // Fetch one and one row
                        while ($row=mysqli_fetch_assoc($result))
                        {
                            $taxonomists = explode(',', $row['taxonomists']);
                            if (count($taxonomists) == 1)
                            {
                                $taxonomists = $row['taxonomists'];
                            }
                            else
                            {
                                $last = array_pop($taxonomists);
                                $firsts = implode(', ', $taxonomists);
                                $taxonomists = sprintf('%s & %s', $firsts, $last);
                            }
                            echo '<li>'."\n";
                            echo '<a class="badge badge-id" href="specie.php?id='.$row['id'].'" target="_blank">'.$row['nomenclature'].' </a>'."\n";
                            echo ' <span class="badge badge-light">('.$taxonomists.', '.$row['year'].')</span>'."\n";
                            /*echo ' <span class="badge badge-brd">BRD*</span>'."\n";
                            echo ' <span class="badge badge-danger">Gênero</span>'."\n";
                            echo ' <span class="changed">Leporinus mormyrops</span>'."\n";*/
                            echo '</li>'."\n";
                        }
                        echo '</ul>'."\n";
                        // Free result set
                        mysqli_free_result($result);
                    }
                    else
                    {
                        echo '<p>No entries</p>';
                    }
                }
                mysqli_close($mysqli);
                ?>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php include_once 'modules/references.php'; ?>
            </div>
            
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php include_once 'modules/captions.php'; ?>
            </div>
            
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php include_once 'modules/abbreviations.php'; ?>
            </div>
        </div>
    </div>
</div>
<?php include_once 'modules/footer.php'; ?>
</body>
</html>