<?php
  $input = $_GET['input'];
  $result = squareNumber($input);

  function squareNumber ($number) {
    return $number * $number;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Square Space</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
</head>

<body>
  <h1>Square Space</h1>
  <p>Where all your squared number dreams come true.</p>

  <h2><?php echo $input . " * " . $input . " = " . $result; ?></h2>

  <form action="square.php">
    <div class="form-group">
      <label for="input">Number to Square</label>
      <input id="input" name="input" class="form-control" type="number" />
    </div>

    <button type="submit" class="btn btn-success">Submit</button>
  </form>
</body>
</html>
