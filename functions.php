<?php
include_once("constants.php");

function pid_from_file($pidfile) {
  return str_replace(array("\r", "\n"), '', @file_get_contents($pidfile));
}

function get_pids_for_group($parent_pid) {
  // Get the children
  $pids = explode("\n", shell_exec(sprintf("ps --ppid %s -o pid=", $parent_pid)));

  // Add the parent
  array_push($pids, shell_exec(sprintf("ps --pid %s -o pid=", $parent_pid)));

  // Filter out empty strings!
  return array_filter($pids, "strlen");
}

function is_running($pidfile) {
  $pid = pid_from_file($pidfile);
  $pids = get_pids_for_group($pid);
  return count($pids) > 0;
}

function start_process($cmd, $outputfile, $pidfile) {
  exec(sprintf("%s > %s 2>&1 & echo $! > %s", $cmd, $outputfile, $pidfile));
}

function kill_process($pidfile) {
  $parent_pid = pid_from_file($pidfile);
  $pids = get_pids_for_group($parent_pid);

  foreach($pids as $pid) {
    exec(sprintf("kill %s", $pid));
  }
}

function get_n_cpus() {
  $cpuinfo = file_get_contents('/proc/cpuinfo');
  preg_match_all('/^processor/m', $cpuinfo, $matches);
  return count($matches[0]);
}
?>
