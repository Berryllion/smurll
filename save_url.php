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

  $unique_id = md5(uniqid(rand(), true));
  $short_id = substr($unique_id, 0, 8);
  $query = "INSERT INTO urls (org_url, url_code) VALUES ("
  . "'" . $_POST['input_url'] . "', "
  . "'" . $short_id . "'"
  . ")";

  if ($connection->query($query) === true) {
    echo "URL saved.";
  } else {
    die("Error: Could not INSERT data. <br>" . $connection->error);
  }

  $connection->close();
?>