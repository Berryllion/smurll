<!DOCTYPE html>
<html>
  <head>
    <title>Smurll</title>
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

      echo "Connected to server.";

      $connection->close();
    ?>
  </head>
  <body>
    <form method='post' name='form_url' id='form_url'>
      <label for='input_url'>Enter URL to shorten:</label>
      <input type='url' name='input_url' id='input_url' />
      <input type="submit">
    </form>
  </body>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
  $(function() {
    $('#form_url').on('submit', function(e) {
      if ($("#form_url [name='input_url']").val() === '') {
        $("#form_url [name='input_url']").css("border", "1px solid red");
        return false;
      }

      $.ajax({
        type: 'post',
        url: 'save_url.php',
        data: $('#form_url').serialize(),
        success: function(e) {
         alert(e);
        },
      });

      e.preventDefault();
    });
  });
  </script>
</html>