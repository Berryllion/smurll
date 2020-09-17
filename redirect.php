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
  $select_query = "SELECT org_url FROM urls WHERE url_code='" . $url_code . "'";
  $select_result = $connection->query($select_query);

  if ($select_result->num_rows == 1) {
    $row = $select_result->fetch_assoc();
    $org_url = $row['org_url'];
    $update_query = "UPDATE urls SET nb_visited = nb_visited + 1 WHERE url_code='" . $url_code . "'";

    if ($connection->query($update_query) === true) {
      header('Location: ' . $org_url);
    } else {
      die("Error: Could not UPDATE data. <br>" . $connection->error);
   }
  } else {
    echo 'This short URL does not exist.';
  }

  $connection->close();
  exit;
?>