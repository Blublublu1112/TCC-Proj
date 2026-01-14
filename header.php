<?php
// header.php - Simple page header and layout start
// Determine base path for links if needed, but relative paths usually work best
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Simple Online Item Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Use relative path for CSS so it works in /TCC-Proj/ or root -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <h1><a href="index.php">Item Management</a></h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="add.php" class="btn">Add Item</a>
      </nav>
    </div>
  </header>
  <main class="container">
