<!DOCTYPE html>
<html>
  <head>
    <title>Smurll - Overview</title>
  </head>
  <body>
      <?php
        include('config.php');

        $connection = new mysqli(
          $config['host'],
          $config['username'],
          $config['password'],
          $config['database']
        );

        if ($connection->connect_error) {
          die('Connection failed: ' . $connection->connect_error);
        }

        $select_query = "SELECT * FROM urls";
        $select_result = $connection->query($select_query);

        if ($select_result->num_rows > 0) {
          echo '<table><tr><th>URL</th><th>Short URL</th><th>Number of visits</th></tr>';

          $uri = !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']) ? 'https://' : 'http://';
          $uri .= $_SERVER['HTTP_HOST'];

          while($row = $select_result->fetch_assoc()) {
            $short_url = $uri . '/smurll/s/' . $row['url_code'];

            echo "<tr><td><a href='" . $row['org_url'] . "'>" . $row['org_url'] . "</a></td>"
            . "<td><a href='" . $short_url . "'>" . $short_url . "</a></td>"
            . "<td>" . $row['nb_visited'] . "</td></tr>";
          }

          echo '</table>';
        } else if ($select_result->num_rows == 0) {
          echo 'No short URL saved.';
        } else {
          die('Error: Could not SELECT data. <br>' . $connection->error);
        }
      ?>
  </body>
</html>