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

        $exploded_url = explode("/", $_SERVER['REQUEST_URI']);
        $current_page = count($exploded_url) < 4 ? 1 : intval(end($exploded_url));
        $nb_per_page = 20;
        $range_start = $current_page == 1 ? 0 : $nb_per_page * ($current_page - 1);

        $original_uri = '/smurll/overview';

        $select_all_query = "SELECT * FROM urls";
        $select_query = "SELECT * FROM urls LIMIT " . strval($nb_per_page) . " OFFSET " . strval($range_start);
        $select_all_result = $connection->query($select_all_query);
        $select_result = $connection->query($select_query);

        $nb_rows = $select_all_result->num_rows;
        $nb_pages = ceil($nb_rows / 20);

        $uri = !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']) ? 'https://' : 'http://';
        $uri .= $_SERVER['HTTP_HOST'];

        if ($select_all_result->num_rows > 0) {
          echo '<table><tr><th>URL</th><th>Short URL</th><th>Number of visits</th></tr>';

          while ($row = $select_result->fetch_assoc()) {
            $short_url = $uri . '/smurll/s/' . $row['url_code'];

            echo "<tr><td><a href='" . $row['org_url'] . "'>" . $row['org_url'] . "</a></td>"
            . "<td><a href='" . $short_url . "'>" . $short_url . "</a></td>"
            . "<td>" . $row['nb_visited'] . "</td><td></td></tr>";
          }

          // $_SERVER['REQUEST_URI']

          echo '</table>';
          for ($i = 1; $i <= $nb_pages; ++$i) {
            $overview_link = '/smurll/overview';
            echo "<a href='" . $uri . $overview_link . '/' . $i . "'>" . $i . "</a>";
          }
        } else if ($select_result->num_rows == 0) {
          echo 'No short URL saved.';
        } else {
          die('Error: Could not SELECT data. <br>' . $connection->error);
        }
      ?>
  </body>
</html>