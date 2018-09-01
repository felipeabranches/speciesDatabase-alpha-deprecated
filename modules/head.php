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
    <!-- speciesDatabase CSS -->
    <link href="<?php echo $base_url; ?>/css/style.min.css" rel="stylesheet" type="text/css" />
    <!-- speciesDatabase Favicon -->
    <link href="<?php echo $base_url; ?>/img/favicon.ico" rel="icon" />
