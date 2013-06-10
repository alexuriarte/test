<?php
DEFINE("METRIC_PATH", "/tmp/metric");
DEFINE("METHOD", $_SERVER['REQUEST_METHOD']);

function write_metric($value) {
  if($fh = fopen(METRIC_PATH, "w")) {
    fwrite($fh, (string) $value);
    fclose($fh);
  } else {
    echo "Could not write to the metric path";
  }
  return $value;
}


function read_metric() {
  if($fh = fopen(METRIC_PATH, "r")) {
    $metric = fgets($fh);
    fclose($fh);
  } else {
    $metric = write_metric(0); // Default value
  }

  return $metric;
}
?>

<html>
  <head>
  </head>
  <body>
    <h1>Custom Metric App</h1>
<?
if (METHOD === "GET") { 
?>
        <p>Metric set to: <?php echo read_metric(); ?></p>
        <form action="/" method="post">
          <label for="value">Give a new value to the metric:</label>
          <input type="text" name="value"></input>
        </form>
<? 
} elseif (METHOD === "POST") {
  $value = $_POST["value"];
  if (is_numeric($value)) {
    write_metric((float) $value);
    header("Location: /");
  } else { ?>
      <p>This value (<? echo $value; ?>) is invalid.</p>
      <p>Try a number!</p>
      <p><a href="/">Please try again</a></p>
<?  
  }
} else {
  echo "Unsupported method";
}
?>
  </body>
</html>
