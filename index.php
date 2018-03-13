<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>IFSP - Campus Avaré</title>
</head>

<body>
<?php include 'templates/nav.php'; ?>

<div class="container" id="content">
    <?php include 'templates/home.php'; ?>
</div>

<script>
        function showAbout() {
            jQuery('#content').load('templates/about.php');
        }

        function showHome() {
            jQuery('#content').load('templates/home.php');
        }
</script>
</body>
</html>
