<?php
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
