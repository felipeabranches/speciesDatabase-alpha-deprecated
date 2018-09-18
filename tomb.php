<?php
include_once 'init.php';
$page_title = 'Tombamento';
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
                $sql = 'SELECT t.name AS tomb, t.entity AS determinator, t.date AS t_date, t.specie_count AS s_count, t.note AS note, s.date AS s_date, s.id_unit AS unit, s.name AS waypoint, s.place AS place, s.entity AS collector, s.latitude AS latitude, s.longitude AS longitude, sp.id AS spID, CONCAT(sp.genus, " ", sp.specie) AS nomenclature, c.name AS campaing
                        FROM camp_tombs AS t
                        LEFT JOIN camp_waypoints AS s
                            ON s.id = t.id_waypoint
                        LEFT JOIN sp_species AS sp
                            ON sp.id = t.id_specie
                        LEFT JOIN camp_campaings AS c
                            ON c.id = t.id_campaing
                        WHERE t.published = 1
                            AND t.id = '.$id.'
                        ';
                if($result=mysqli_query($mysqli,$sql))
                {
                    if($result->num_rows)
                    {
                        // Fetch one and one row
                        while ($row=mysqli_fetch_object($result))
                        {
                            echo '<h3>'.$row->tomb.' </h3>'."\n";
                            echo '<h5>'.$row->nomenclature.'</h5>'."\n";
                            echo '<h5>n: '.$row->s_count.'</h5>'."\n";
                        }
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
    </div>
</div>
<?php include_once 'modules/footer.php'; ?>
</body>
</html>