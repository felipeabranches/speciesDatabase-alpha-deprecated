<!-- Bootstrap CSS -->
<?php
if($bootstrap_cdn):
?>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
<?php
else:
?>
    <link href="<?php echo $bootstrap_path; ?>/css/bootstrap.min.css" rel="stylesheet" />
<?php
endif;
?>
    <!-- Fontawesome -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <!-- speciesDatabase CSS -->
    <link href="<?php echo $base_url; ?>/css/style.min.css" rel="stylesheet" type="text/css" />
    <!-- speciesDatabase Favicon -->
    <link href="<?php echo $base_url; ?>/img/favicon.ico" rel="icon" />
