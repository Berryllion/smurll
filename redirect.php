<?php
  include('config.php');

  $connection = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database']
  );

  if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
  }

  $exploded_url = explode("/", $_SERVER['REQUEST_URI']);
  $url_code = end($exploded_url);
  $query = "SELECT org_url FROM urls WHERE url_code='" . $url_code . "'";
  $result = $connection->query($query);

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $org_url = $row['org_url'];

    header('Location: ' . $org_url);
  } else {
    echo 'This short URL does not exits.';
  }

  $connection->close();
  exit;
?>