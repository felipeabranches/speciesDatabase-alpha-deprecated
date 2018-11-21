<?php
include_once 'init.php';
$id = $_GET['id'];
$order_by = $_GET['order_by'];

include_once 'libraries/species/taxonomists.php';
$taxonomists = new Taxonomists;

$page_title = 'Taxonomists';
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
        if ($result = mysqli_query($mysqli, $taxonomists->getTaxonomists($id, $order_by)))
        {
            if (!$result->num_rows)
            {
                echo '<p>No entries</p>';
            }
            else
            {
                // Fetch one and one row
                while ($row=mysqli_fetch_object($result))
                {
                ?>
        <div class="col-12 col-md-3">
            <div class="card mt-3 mb-3">
                <?php if ($row->image): ?>
                <img class="card-img-top" src="<?php echo $row->image; ?>" alt="<?php echo $row->author; ?>">
                <?php endif; ?>
                <div class="card-header">
                    <h5 class="float-left"><?php echo $row->author; ?></h5>
                    <a href="taxonomist.php?id=<?php echo $row->ttID; ?>" role="button" class="btn btn-primary btn-sm float-right">Details</a>
                </div>
                <!--div class="card-body">
                    <?php echo $row->description; ?>
                </div>
                <div class="card-footer">
                    <span class="badge badge-secondary"><?php echo $row->note; ?></span>
                    <span class="float-right">ID#<span class="badge badge-secondary badge-pill"><?php echo $row->ttID; ?></span></span>
                </div-->
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
