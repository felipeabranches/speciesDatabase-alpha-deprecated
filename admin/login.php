<?php
$loggedout = 0;
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Signin Template for Bootstrap</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../img/favicon.ico" rel="icon">
</head>

<body class="bg-light sign-in text-center">
    <div class="bg-white rounded box-shadow content">
        <img src="http://getbootstrap.com/docs/4.1/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72" class="mb-4 rounded-circle" />
        <?php if($loggedout): ?>
        <div class="alert alert-danger" role="alert">Please sign in</div>
        <?php endif; ?>

        <form class="">
            <div class="form-group">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <!--p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p-->
        </form>
    </div>
</body>
</html>
