<?php
include_once '../init.php';
$page_title = 'Users';
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
            <a href="users_user.php?id=0" class="btn btn-primary float-right" role="button">New</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class=" my-3 p-3 bg-white rounded box-shadow">
                <table class="table table-striped table-hover table-sm">
                    <tr width="100%">
                        <th width="5%"><a href="users_users.php?order_by=id">ID</a></th>
                        <th width="55%"><a href="users_users.php?order_by=name">Name</a></th>
                        <th width="35%"><a href="users_users.php?order_by=username">Username</a></th>
                        <th width="35%"><a href="users_users.php?order_by=email">Email</a></th>
                    </tr>
                    <?php
                    $sql = 'SELECT uu.id AS id,uu.name AS name,uu.username AS username,uu.email AS email 
                            FROM users_users AS uu
                            ORDER BY uu.'.$order_by.'
                            ';

                    if($result=mysqli_query($mysqli,$sql))
                    {
                        if($result->num_rows)
                        {
                            // Fetch one and one row
                            while($row = mysqli_fetch_assoc($result))
                            {
                              
                                echo '<tr>';
                                echo '<td>'.$row['id'].'</td>';
                                echo '<td><a href="users_user.php?id='.$row['id'].'">'.$row['name'].'</a></td>';
                                echo '<td>'.$row['username'].'</td>';
                                echo '<td>'.$row['email'].'</td>';
                                echo '<td><a data-toggle="modal" data-target="#modal-'.$row['id'].'"><i class="fas fa-trash-alt"></i></a></td>';
                                echo '</tr>'."\n";
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
                                                    <p>Are you sure you want to delete <strong>'.$row['name'].'</strong> (ID: '.$row['id'].')?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="modules/users_users_delete.php?id='.$row['id'].'" class="btn btn-danger">Delete</a>
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            }
                            // Free result set
                            mysqli_free_result($result);
                        }
                    }
                    else
                    {
                        echo '<tr><td colspan="4">No entries</td></tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Fontawesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</body>
</html>
