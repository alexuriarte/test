<?php
include_once("constants.php");

function pid_from_file($pidfile) {
  return str_replace(array("\r", "\n"), '', @file_get_contents($pidfile));
}

function is_running($pidfile) {
  $pid = pid_from_file($pidfile);

  if ($pid === "") {
    return false;
  }

  try {
    // Very insecure, but we don't really care here.
    $result = shell_exec(sprintf("ps %d", $pid));
    if (count(preg_split("/\n/", $result)) > 2) {
      return true;
    }
  } catch(Exception $e) {}
  return false;
}

function start_process($cmd, $outputfile, $pidfile) {
  exec(sprintf("%s > %s 2>&1 & echo $! > %s", $cmd, $outputfile, $pidfile));
}

function kill_process($pidfile) {
  $pid = pid_from_file($pidfile);
  posix_kill($pid, SIGTERM);
}

function get_n_cpus() {
  $cpuinfo = file_get_contents('/proc/cpuinfo');
  preg_match_all('/^processor/m', $cpuinfo, $matches);
  return count($matches[0]);
}
?>
