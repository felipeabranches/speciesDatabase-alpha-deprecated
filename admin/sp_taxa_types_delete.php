<?php
// connect to the database
include_once '../../includes/connect.php';

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get id value
    $id = $_GET['id'];

    // delete the entry
    $result = mysqli_query($mysqli, 'DELETE FROM sp_taxa_types WHERE id = '.$id) or die(mysqli_error());

    // redirect back to the view page
    header("Location: sp_taxa_types.php");
}
else
{
    // if id isn't set, or isn't valid, redirect back to view page
    header("Location: sp_taxa_types.php");
}
?>
