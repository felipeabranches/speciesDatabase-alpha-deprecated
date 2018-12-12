<?php
include_once '../init.php';
include_once '../libraries/fields/fields.php';
$page_title = 'Tomb';
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
	<title><?php echo (!$id) ? 'New' : 'Edit'; ?> <?php echo $page_title; ?> - <?php echo $site_name; ?></title>
    <?php include_once '../modules/head.php'; ?>
</head>

<body class="bg-light">
<?php include_once 'modules/menu.php'; ?>
<div class="container-fluid" role="main">

<?php
// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['save']))
{
    // get form data, making sure it is valid
    $name = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['name']));
    $id_campaing = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['id_campaing']));
    $id_waypoint = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['id_waypoint']));
    $id_specie = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['id_specie']));
    $specie_count = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['specie_count']));
    $entity = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['entity']));
    $date = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['date']));
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
        renderForm ($id, $name, $id_campaing, $id_waypoint, $id_specie, $specie_count, $entity, $date, $description, $note, $image, $published, $error, $page_title);
    }
    else
    {
        if ($id == 0)
        {
            $sql = "INSERT INTO camp_tombs (name, id_campaing, id_waypoint, id_specie, specie_count, entity, date, description, note, image, published) 
                    VALUES ('".$name."', '".$id_campaing."', '".$id_waypoint."', '".$id_specie."', '".$specie_count."', '".$entity."', '".$date."', '".$description."', '".$note."', '".$image."', '".$published."')
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
            header ("Location: camp_tombs.php"); //header("refresh:3;url=camp_tombs.php");
        }
        else
        {
            // confirm that the 'id' value is a valid integer before getting the form data
            if (is_numeric($_POST['id']))
            {
                // get form data, making sure it is valid
                $id = $_POST['id'];

                $sql = "UPDATE camp_tombs
                        SET name='".$name."', id_campaing='".$id_campaing."', id_waypoint='".$id_waypoint."', id_specie='".$id_specie."', specie_count='".$specie_count."', entity='".$entity."', date='".$date."', description='".$description."', note='".$note."', image='".$image."', published='".$published."'
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
                header ("Location: camp_tombs.php"); //header("refresh:3;url=camp_tombs.php");
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
        renderForm ('', '', '', '', '', '', '', '', '', '', '', '', '', $page_title);
    }
    else
    {
        // if the form hasn't been submitted, get the data from the db and display the form
        // get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
        {
            // query db
            $result = mysqli_query($mysqli, 'SELECT * FROM camp_tombs WHERE id = '.$id)
                or die($sql_err);
            $row = mysqli_fetch_array($result);

            // check that the 'id' matches up with a row in the databse
            if($row)
            {
                // get data from db
                $name = $row['name'];
                $id_campaing = $row['id_campaing'];
                $id_waypoint = $row['id_waypoint'];
                $id_specie = $row['id_specie'];
                $specie_count = $row['specie_count'];
                $entity = $row['entity'];
                $date = $row['date'];
                $description = $row['description'];
                $note = $row['note'];
                $image = $row['image'];
                $published = $row['published'];

                // show form
                renderForm ($id, $name, $id_campaing, $id_waypoint, $id_specie, $specie_count, $entity, $date, $description, $note, $image, $published, '', $page_title);
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
function renderForm ($id, $name, $id_campaing, $id_waypoint, $id_specie, $specie_count, $entity, $date, $description, $note, $image, $published, $error, $page_title)
{
    if ($error != '')
    {
        echo '<div style="border:1px solid red; color:red; padding:4px;">'.$error.'</div>';
    }
    ?>
    <form action="" method="post">
        <?php if ($id) echo '<input type="hidden" name="id" value="'.$id.'" />'; ?>
        <div class="toolbar sticky-top row my-2 p-2">
            <div class="col-12 col-md-10">
                <h4><?php echo (!$id) ? 'New' : 'Edit'; ?> <?php echo $page_title; ?></h4>
            </div>
            <div class="col-12 col-md-2 text-right">
                <button type="submit" name="save" class="btn btn-primary">Save</button>
                <a href="camp_tombs.php?order_by=id" class="btn btn-outline-danger" role="button">Cancel</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <?php field_text ('Name', 'name', $name, 'Enter the Tomb name', 'required'); ?>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <?php field_selectDB ('Campaing', 'id_campaing', $id_campaing, 'name', 'camp_campaings', 'camp_tombs', 'id', '<option>-- Choose --</option>', 0); ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?php field_selectDB ('Waypoint', 'id_waypoint', $id_waypoint, 'CONCAT(name, " - ", note)', 'wpt_waypoints', 'camp_tombs', 'id', '<option>-- Choose --</option>', 0); ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?php field_selectDB ('Specie', 'id_specie', $id_specie, 'CONCAT(genus, " ", specie)', 'sp_species', 'camp_tombs', 'id', '<option>-- Choose --</option>', 0); ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?php field_number ('Specie count', 'specie_count', $specie_count, 'Enter the Specie count', '1', '999', '1'); ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?php field_text ('Entity', 'entity', $entity, 'Enter the Tomb\'s Entity name', ''); ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?php field_date ('Date', 'date', $date, 'Enter the Tomb\'s Date in YYYY-MM-DD format', ''); ?>
                        </div>
                    </div>
                </div>
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <?php field_textarea ('Description', 'description', $description, '', ''); ?>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h5>State</h5>
                    <?php field_toggle ('Published', 'published', array(1 => 'yes', 0 => 'no'), 'camp_tombs', $id, 1, 'yesno'); ?>
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
<?php include_once '../modules/footer.php'; ?>
<!-- TinyMCE -->
<script src="<?php echo $tinymce_path; ?>/tinymce/js/tinymce/tinymce.min.js"></script>
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
