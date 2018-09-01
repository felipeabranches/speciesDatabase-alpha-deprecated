<?php
include_once '../init.php';
include_once '../libraries/fields/fields.php';
$page_title = 'Specie';
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
    $gender = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['gender']));
    $specie = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['specie']));
    $incertae_sedis = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['incertae_sedis']));
    $dubious = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['dubious']));
    $etymology = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['etymology']));
    $common_name = mysqli_real_escape_string($mysqli, $_POST['common_name']);
    $id_taxon = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['id_taxon']));
    $id_taxonomist = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['id_taxonomist']));
    $year = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['year']));
    $revised = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['revised']));
    $validate = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['validate']));
    $redirect = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['redirect']));
    $habitat = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['habitat']));
    $distribution = mysqli_real_escape_string($mysqli, $_POST['distribution']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $note = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['note']));
    $image = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['image']));
    $published = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['published']));

    // check to make sure both fields are entered
    if ($gender == '' || $id_taxon == '')
    {
        // generate error message
        $error = 'ERROR: Please fill in all required fields!';

        // if either field is blank, display the form again
        renderForm ($id, $gender, $specie, $incertae_sedis, $dubious, $etymology, $common_name, $id_taxon, $id_taxonomist, $year, revised, $validate, $redirect, $habitat, $distribution, $description, $note, $image, $published, $error, $page_title);
    }
    else
    {
        if ($id == 0)
        {
            $sql = "INSERT INTO sp_species (gender, specie, incertae_sedis, dubious, etymology, common_name, id_taxon, year, revised, validate, redirect, habitat, distribution, description, note, image, published)
                    VALUES ('".$gender."', '".$specie."', '".$incertae_sedis."', '".$dubious."', '".$etymology."', '".$common_name."', '".$id_taxon."', '".$year."', '".$revised."', '".$validate."', '".$redirect."', '".$habitat."', '".$distribution."', '".$description."', '".$note."', '".$image."', '".$published."')"
                    ."\n";

            // New sp_taxonomists_map
            /*
            $id_specie = $mysqli->insert_id;
            echo gettype ($id_taxonomist);
            if (gettype($id_taxonomist) == "string"){
                // Integer value to array of single value
                $id_taxonomist = array($id_taxonomist);
            }
            else if (gettype($id_taxonomist) == "integer"){
                // Integer value to array of single value
                $id_taxonomist = array($id_taxonomist);
            }
            
            $values = map_values($id_specie, $id_taxonomist);
            echo map_values($id_specie, $id_taxonomist);
            $sql .= "INSERT INTO sp_taxonomists_map (id_specie, id_taxonomist)
                    VALUES ".$values."";
                    */

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
            //header('Location: sp_species.php'); //header("refresh:3;url=sp_species.php");
        }
        else
        {
            // confirm that the 'id' value is a valid integer before getting the form data
            if (is_numeric($_POST['id']))
            {
                // get form data, making sure it is valid
                $id = $_POST['id'];

                $sql = "UPDATE sp_species
                        SET gender='".$gender."', specie='".$specie."', incertae_sedis='".$incertae_sedis."', dubious='".$dubious."', etymology='".$etymology."', common_name='".$common_name."', id_taxon='".$id_taxon."', year='".$year."', revised='".$revised."', validate='".$validate."', redirect='".$redirect."', habitat='".$habitat."', distribution='".$distribution."', description='".$description."', note='".$note."', image='".$image."', published='".$published."'
                        WHERE id = ".$id
                        ."\n";

                // Update sp_taxonomists_map
                /*
                $id_specie = $id;
                $values = map_values($id_specie, $id_taxonomist);
                echo map_values($id_specie, $id_taxonomist);
                $sql .= 'UPDATE sp_taxonomists_map
                        SET id_specie="'.$id_specie.'", ="'.$id_taxonomist.'"
                        ';
                        */

                // save the data to the database
                if(!mysqli_query($mysqli, $sql))
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
                //header('Location: sp_species.php'); //header("refresh:3;url=sp_species.php");
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
        renderForm('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $page_title);
    }
    else
    {
        // if the form hasn't been submitted, get the data from the db and display the form
        // get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
        if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
        {
            // query db
            $result = mysqli_query($mysqli, 'SELECT * FROM sp_species WHERE id = '.$id)
                or die($sql_err);
            $row = mysqli_fetch_array($result);

            // check that the 'id' matches up with a row in the databse
            if($row)
            {
                // get data from db
                $gender = $row['gender'];
                $specie = $row['specie'];
                $incertae_sedis = $row['incertae_sedis'];
                $dubious = $row['dubious'];
                $etymology = $row['etymology'];
                $common_name = $row['common_name'];
                $id_taxon = $row['id_taxon'];
                $year = $row['year'];
                $revised = $row['revised'];
                $validate = $row['validate'];
                $redirect = $row['redirect'];
                $habitat = $row['habitat'];
                $distribution = $row['distribution'];
                $description = $row['description'];
                $note = $row['note'];
                $image = $row['image'];
                $published = $row['published'];

                // show form
                renderForm ($id, $gender, $specie, $incertae_sedis, $dubious, $etymology, $common_name, $id_taxon, '', $year, $revised, $validate, $redirect, $habitat, $distribution, $description, $note, $image, $published, '', $page_title);
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
 *  Make the pairs of a single value with multiples values
 */
function map_values($single, $multiples) {
    $pairs = array();

    foreach ($multiples as $mult) {
        $pairs[] = sprintf("(%s, %s)", $single, $mult);
    }

    return implode(',', $pairs);
}
/*
 *  Creates the record form (new or edit)
 */
function renderForm ($id, $gender, $specie, $incertae_sedis, $dubious, $etymology, $common_name, $id_taxon, $id_taxonomist, $year, $revised,  $validate, $redirect, $habitat, $distribution, $description, $note, $image, $published, $error, $page_title)
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
                <a href="sp_species.php" class="btn btn-outline-danger" role="button">Cancel</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h5>Classification</h5>
                    <div class="row">
                        <div class="col col-md-4">
                            <?php field_text ('Gender', 'gender', $gender, 'Enter the Gender', 'required'); ?>
                        </div>
                        <div class="col col-md-4">
                            <?php field_text ('Specie', 'specie', $specie, 'Enter the Specie', ''); ?>
                        </div>
                        <div class="col col-md-4">
                            <?php field_select ('Dubious specie', 'dubious', array(1 => 'aff.', 2 => 'cf.', 3 => 'sp.'), 'sp_species', $id, 0, '<option name="no" value="0">-- No --</option>', 0); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-8">
                            <?php field_selectDB ('Taxon', 'id_taxon', $id, 'name', 'sp_taxa', 'sp_species', 'id', '<option>-- Choose --</option>', 0); ?>
                        </div>
                        <div class="col col-md-4">
                            <?php field_toggle ('<em>Incertae Sedis</em>', 'incertae_sedis', array(1 => 'yes', 0 => 'no'), 'sp_species', $id, 0, 'yesno'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-8">
                            <?php field_selectDB ('Taxonomists', 'id_taxonomist', $id, 'name', 'sp_taxonomists', 'sp_taxonomists_map', 'id_specie', '<option>-- None --</option>', 1); ?>
                        </div>
                        <div class="col col-md-4">
                            <?php field_toggle ('Revised', 'revised', array(1 => 'yes', 0 => 'no'), 'sp_species', $id, 0, 'yesno'); ?>
                            <?php field_text ('Year', 'year', $year, 'Enter the identification Year in YYYY format', ''); ?>
                        </div>
                    </div>
                </div>
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <?php field_textarea ('Description', 'description', $description, ''); ?>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h5>State</h5>
                    <?php field_toggle ('Published', 'published', array(1 => 'yes', 0 => 'no'), 'sp_species', $id, 1, 'yesno'); ?>
                    <?php if ($id) echo '<p><strong>ID:</strong> '.$id.'</p>'; ?>
                </div>
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h5>Media</h5>
                    <?php field_text ('Image', 'image', $image, 'Enter the Image path', ''); ?>
                </div>
                <div class="my-3 p-3 bg-white rounded box-shadow">
                    <h5>Others</h5>
                    <?php field_text ('Common Name', 'common_name', $common_name, 'Enter the Common Name', ''); ?>
                    <?php field_textarea ('Etymology', 'etymology', $etymology, '', ''); ?>
                    <?php field_textarea ('Habitat', 'habitat', $habitat, ''); ?>
                    <?php field_textarea ('Distribution', 'distribution', $distribution, ''); ?>
                    <?php field_toggle ('Validate', 'validate', array(1 => 'accepted', 0 => 'synonym'), 'sp_species', $id, 1, 0); ?>
                    <?php field_selectDB ('Redirect', 'redirect', $id, 'CONCAT(gender, " ", specie)', 'sp_species', 'sp_species', 'id', '<option value="0">-- Choose --</option>', 0); ?>
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
