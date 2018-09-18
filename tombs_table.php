<?php
include_once 'init.php';
$page_title = 'Tombamentos';
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
        <div class="col-12">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <?php
                global $mysqli;
                $sql = 'SELECT t.id AS tombID, t.name AS tomb, t.entity AS determinator, t.date AS t_date, t.specie_count AS s_count, t.note AS note,
                        s.date AS s_date, s.id_unit AS unit, s.name AS waypoint, s.place AS place, s.entity AS collector, s.latitude AS latitude, s.longitude AS longitude,
                        sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature,
                        c.name AS campaing
                        FROM camp_tombs AS t
                        INNER JOIN camp_waypoints AS s
                            ON s.id = t.id_waypoint
                        INNER JOIN sp_species AS sp
                            ON sp.id = t.id_specie
                        INNER JOIN camp_campaings AS c
                            ON c.id = t.id_campaing
                        WHERE t.published = 1
                        ORDER BY t.id
                        ';

                if($result = mysqli_query($mysqli,$sql))
                {
                    if(!$result->num_rows)
                    {
                        echo '<span>No entries</span>';
                    }
                    else
                    {
                        ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Tombo</th>
                                <th scope="col">Ficha de campo</th>
                                <th scope="col">Espécie</th>
                                <th scope="col">Data</th>
                                <th scope="col">Drenagem</th>
                                <th scope="col">Local/Rio</th>
                                <th scope="col">Município</th>
                                <th scope="col">Coletor</th>
                                <th scope="col">Determinador</th>
                                <th scope="col">Data determinação</th>
                                <th scope="col">Latitude</th>
                                <th scope="col">Longitude</th>
                                <th scope="col">N</th>
                                <th scope="col">Obs</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Fetch one and one row
                        while ($row = mysqli_fetch_object($result))
                        {
                            echo '<tr scope="row">';
                            echo '<td><a href="tomb.php?id='.$row->tombID.'">'.$row->tomb.'</a></th>'."\n";
                            echo '<td>'.$row->campaing.'</td>'."\n";
                            echo '<td><a href="specie.php?id='.$row->spID.'">'.$row->nomenclature.'</a></td>'."\n";
                            echo '<td>'.$row->s_date.'</td>'."\n";
                            echo '<td>'.$row->unit.'</td>'."\n";
                            echo '<td>'.$row->waypoint.'</td>'."\n";
                            echo '<td>'.$row->place.'</td>'."\n";
                            echo '<td>'.$row->collector.'</td>'."\n";
                            echo '<td>'.$row->determinator.'</td>'."\n";
                            echo '<td>'.$row->t_date.'</td>'."\n";
                            echo '<td>'.$row->latitude.'</td>'."\n";
                            echo '<td>'.$row->longitude.'</td>'."\n";
                            echo '<td>'.$row->s_count.'</td>'."\n";
                            echo '<td>'.$row->note.'</td>'."\n";
                            echo '</tr>';
                        }
                        // Free result set
                        mysqli_free_result($result);
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
                    }
                }
                mysqli_close($mysqli);
                ?>
            </div>
        </div>
    </div>
</div>
<?php include_once 'modules/footer.php'; ?>
</body>
</html>
