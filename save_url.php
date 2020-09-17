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
  $select_query = "SELECT org_url FROM urls WHERE url_code='" . $short_id . "'";
  $select_result = $connection->query($select_query);

  if ($select_result->num_rows == 1) {
    die("Error: Short URL code already in database.");
  }

  $insert_query = "INSERT INTO urls (org_url, url_code) VALUES ("
  . "'" . $_POST['input-url'] . "', "
  . "'" . $short_id . "')";

  if ($connection->query($insert_query) === true) {
    $uri = !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']) ? 'https://' : 'http://';
    $uri .= $_SERVER['HTTP_HOST'];
    $short_url = $uri . '/smurll/s/' . $short_id;

    echo $short_url;
  } else {
    die("Error: " . $insert_query . "<br>" . $connection->error);
  }

  $connection->close();
?>