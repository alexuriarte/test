<?php
include_once("constants.php");

function is_running($pidfile) {
  $pid = str_replace(array("\r", "\n"), '', @file_get_contents($pidfile));

  try {
    $result = shell_exec(sprintf("ps %d", $pid));
    if (count(preg_split("/\n/", $result)) > 2) {
      return true;
    }
  } catch(Exception $e) {}

    return false;
}

function start_process($cmd, $outputfile, $pidfile) {
  exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
}
?>
