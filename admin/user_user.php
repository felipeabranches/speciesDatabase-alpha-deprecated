<?php
include_once '../init.php';
$page_title = 'User';
$id = $_GET['id'];
?>
<!doctype html>
<html lang="pt">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Feipe Abranches">
	<title><?php echo (!$id) ? 'New' : 'Edit'; ?> <?php echo $page_title; ?> :: Peixes da Serra do Cipó - MG</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link href="../css/style.css" rel="stylesheet" />
</head>

<body class="bg-light">
<?php include_once 'fields/fields.php'; ?>
<?php include_once 'modules/menu.php'; ?>
<div class="container-fluid" role="main">

<?php
// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['save']))
{
    // get form data, making sure it is valid
    $first_name = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['first_name']));
    $last_name = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['last_name']));
    $email = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['email']));
    $password = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['password']));
    $mobile = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['mobile']));
    $residencial = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['residencial']));
    $comercial = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['comercial']));
    $id_type = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['id_type']));
    $description = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['description']));
    $note = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['note']));
    $image = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['image']));
    $published = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['published']));

    // check to make sure fields are entered
    if ($name == '')
    {
        // generate error message
        $error = 'ERROR: Please fill in all required fields!';

        // if either field is blank, display the form again
        renderForm ($id, $first_name, $last_name, $email, $password, $mobile, $residencial, $comercial, $id_type, $description, $note, $image, $published, $error, $page_title);
    }
    else
    {
        if ($id == 0)
        {
            $sql = "INSERT INTO users_users (first_name, last_name, email, password, mobile, residencial, comercial, id_type, level, description, note, image, published) 
                    VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$password."', '".$mobile."', '".$residencial."', '".$comercial."', '".$id_type."', '".$id_type."', '".$description."', '".$note."', '".$image."', '".$published."')
                    "."\n";

            // save the data to the database
            if (!mysqli_query($mysqli, $sql))
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6>Falha</h6>
                        <p>'.$sql.'</p>
                        <p>'.mysqli_error($mysqli).'</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>'."\n";
            }
            else
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h6>Sucesso</h6>
                        <p>'.$sql.'</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>'."\n";
            }

            // once saved, redirect back to the view page
            header ("Location: user_users.php"); //header("refresh:3;url=user_users.php");
        }
        else
        {
            // confirm that the 'id' value is a valid integer before getting the form data
            if (is_numeric($_POST['id']))
            {
                // get form data, making sure it is valid
                $id = $_POST['id'];

                $sql = "UPDATE users_users
                        SET first_name='".$first_name."', last_name='".$last_name."', email='".$email."', password='".$password."', mobile='".$mobile."', residencial='".$residencial."', comercial='".$comercial."', id_type='".$id_type."', level='".$id_type."', description='".$description."', note='".$note."', image='".$image."', published='".$published."'
                        WHERE id = ".$id
                        ."\n";

                // save the data to the database
                if (!mysqli_query($mysqli, $sql))
                {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6>Falha</h6>
                            <p>'.$sql.'</p>
                            <p>'.mysqli_error($mysqli).'</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>'."\n";
                }
                else
                {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h6>Sucesso</h6>
                            <p>'.$sql.'</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>'."\n";
                }

                // once saved, redirect back to the view page
                header ("Location: user_users.php"); //header("refresh:3;url=user_users.php");
            }
            else
            {
                // if the 'id' isn't valid, display an error
                echo 'Error!';
            }
        }
    }
}
else
{
    if ($id == 0)
    {
        // if the form hasn't been submitted, display the form
        renderForm ('', '', '', '', '', '', '', '', '', '', '', '', '', '', $page_title);
    }
    else
    {
        // if the form hasn't been submitted, get the data from the db and display the form
        // get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
        {
            // query db
            $result = mysqli_query($mysqli, 'SELECT * FROM users_users WHERE id = '.$id)
                or die($sql_err);
            $row = mysqli_fetch_array($result);

            // check that the 'id' matches up with a row in the databse
            if($row)
            {
                // get data from db
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $email = $row['email'];
                $password = $row['password'];
                $mobile = $row['mobile'];
                $residencial = $row['residencial'];
                $comercial = $row['comercial'];
                $id_type = $row['id_type'];
                $description = $row['description'];
                $note = $row['note'];
                $image = $row['image'];
                $published = $row['published'];

                // show form
                renderForm ($id, $first_name, $last_name, $email, $password, $mobile, $residencial, $comercial, $id_type, $description, $note, $image, $published, '', $page_title);
            }
            else
            // if no match, display result
            {
                echo '<h4>Entry not found</h4>
                      <div class="alert alert-warning alert-dismissible fade show my-3" role="alert">
                        <h5>No result!</h5>
                        <p>The selected ID doesn\'t match with any row in Database</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>'."\n";
            }
        }
        else
        // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
        {
            echo 'Error!';
        }
    }
}

/*
 *  Creates the record form (new or edit)
 */
function renderForm ($id, $first_name, $last_name, $email, $password, $mobile, $residencial, $comercial, $id_type, $description, $note, $image, $published, $error, $page_title)
{
    if ($error != '')
    {
        echo '<div style="border:1px solid red; color:red; padding:4px;">'.$error.'</div>';
    }
    ?>
    <form action="" method="post">
        <?php if ($id) echo '<input type="hidden" name="id" value="'.$id.'" />'; ?>
        <div class="row my-2 p-2">
            <div class="col-12 col-md-10">
                <h4><?php echo (!$id) ? 'New' : 'Edit'; ?> <?php echo $page_title; ?></h4>
            </div>
            <div class="col-12 col-md-2 text-right">
                <button type="submit" name="save" class="btn btn-primary">Save</button>
                <a href="user_users.php" class="btn btn-outline-danger" role="button">Cancel</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <?php field_text ('First name', 'first_name', $first_name, 'Enter the User first name', 'required'); ?>
                    <?php field_text ('Last name', 'last_name', $last_name, 'Enter the User last name', 'required'); ?>
                    <?php field_email ('Email', 'email', $email, 'Enter the User email', 'required'); ?>
                    <?php field_password ('Password', 'password', $password, 'Enter a password', 'required'); ?>
                    <?php field_tel ('Mobile', 'mobile', $mobile, 'Enter the User mobile phone', 'required'); ?>
                    <?php field_tel ('Residencial', 'residencial', $residencial, 'Enter the User residencial phone', ''); ?>
                    <?php field_tel ('Comercial', 'comercial', $comercial, 'Enter the User comercial phone', ''); ?>
                    <?php field_selectDB ('Type', 'id_type', $id_type, 'name', 'users_users_types', '<option name="none" value="0">-- Choose --</option>', 0); ?>
                </div>
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <?php field_textarea ('Description', 'description', '', ''); ?>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h5>State</h5>
                    <?php field_toggle ('Published', 'published', array(1 => 'yes', 0 => 'no'), 'users_users', $id, 1, 'yesno'); ?>
                    <?php if ($id) echo '<p><strong>ID:</strong> '.$id.'</p>'; ?>
                </div>
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h5>Media</h5>
                    <?php field_text ('Image', 'image', $image, 'Enter the Image path', ''); ?>
                </div> 
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h5>Others</h5>
                    <?php field_text ('Note', 'note', $note, 'Enter some notes...', ''); ?>
                </div> 
            </div>
        </div>
    </form>
<?php
}
?>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- TinyMCE -->
<script src="http://localhost/peixes/admin/fields/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'#description',
        height: 300
    });
</script>
<!-- Fontawesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
</body>
</html>
