<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P!X Movie Database</title>
    <link rel="stylesheet" href="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']); ?>/assets/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/index.php?module=dashboard" class="nav-brand">P!X</a>
            <div class="nav-menu">
                <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/index.php?module=dashboard">🏠 Dashboard</a>
                <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/index.php?module=film">🎬 Film</a>
                <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/index.php?module=aktor">👥 Aktor</a>
                <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/index.php?module=bioskop">🏢 Bioskop</a>
                <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/index.php?module=jadwal">📅 Jadwal</a>
            </div>
        </div>
    </nav>