<?php
include_once 'init.php';
$page_title = 'Pontos de passagem';
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
                $sql = 'SELECT w.name AS name, w.latitude AS latitude, w.longitude AS longitude, w.symbol AS symbol
                        FROM camp_waypoints AS w
                        WHERE w.published = 1
                        ORDER BY w.id
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
                        <?php
                        // Fetch one and one row
                        while ($row = mysqli_fetch_object($result))
                        {
//                            echo '<pre>';
//                            print_r($row);
//                            echo '</pre>';
                            echo '<h3>'.$row->name.'</h3>';
                            echo '<p>Latitude: '.$row->latitude.', Longitude: '.$row->longitude.'</p>';
                            
                            $symbol = $row->symbol;
                            $symbol = explode(',', $symbol);
                            //print_r($symbol);
                            echo strtolower('<img src="img/'.trim($symbol[0]).'-'.trim($symbol[1]).'.jpg" />');
                                
                                
                            echo '<hr /><br />';
                            
                        }
                        // Free result set
                        mysqli_free_result($result);
                        ?>
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
