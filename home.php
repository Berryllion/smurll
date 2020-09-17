<!DOCTYPE html>
<html>
  <head>
    <title>Smurll</title>
  </head>
  <body>
    <form method='post' name='form-url' id='form-url'>
      <label for='input-url'>Enter URL to shorten:</label>
      <input type='url' name='input-url' id='input-url' />
      <input type="submit">
    </form>
    <a href='' id='short-url'></a>
  </body>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(function() {
      $('#form-url').on('submit', function(e) {
        if ($("#form-url [name='input-url']").val() === '') {
          $("#form-url [name='input-url']").css("border", "1px solid red");
          return false;
        }

        $.ajax({
          type: 'post',
          url: 'save_url.php',
          data: $('#form-url').serialize(),
          success: function(short_url) {
            $('#short-url').attr("href", short_url).text(short_url);
          },
        });

        e.preventDefault();
      });
    });
  </script>
</html>