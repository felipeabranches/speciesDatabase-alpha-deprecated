<?php
include_once 'init.php';
$page_title = 'Campaigns';
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
    <div class="toolbar sticky-top row my-2 p-2">
        <div class="col-12">
            <h4><?php echo $page_title; ?></h4>
        </div>
    </div>
    <div class="row">
        <?php
        $sql = 'SELECT
                    c.id AS cID, c.name AS campaign, c.entity AS cEntity, c.date AS cDate, c.image AS image, c.note AS note
                FROM camp_campaings AS c
                WHERE c.published = 1
                ORDER BY c.id
                ';
        if($result=mysqli_query($mysqli,$sql))
        {
            if(!$result->num_rows)
            {
                echo '<p>No entries</p>';
            }
            else
            {
                // Fetch one and one row
                while ($row=mysqli_fetch_object($result))
                {
                ?>
        <div class="col-12 col-md-4">
            <div class="card mt-3 mb-3">
                <?php if($row->image): ?>
                <img class="card-img-top" src="<?php echo $row->image; ?>" alt="<?php echo $row->campaign; ?>">
                <?php endif; ?>
                <div class="card-header">
                    <h5 class="float-left"><?php echo $row->campaign; ?></h5>
                    <a href="campaign.php?id=<?php echo $row->cID; ?>" class="btn btn-primary btn-sm float-right">Details</a>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Collector</dt>
                        <dd><?php echo $row->cEntity; ?></dd>
                        <dt>Date</dt>
                        <dd><?php echo $row->cDate; ?></dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <span class="badge badge-secondary"><?php echo $row->note; ?></span>
                    <span class="float-right">ID: <span class="badge badge-secondary badge-pill"><?php echo $row->cID; ?></span></span>
                </div>
            </div>
        </div>
                <?php
                }
                // Free result set
                mysqli_free_result($result);
            }
        }
        mysqli_close($mysqli);
        ?>
    </div>
</div>
<?php include_once 'modules/footer.php'; ?>
</body>
</html>