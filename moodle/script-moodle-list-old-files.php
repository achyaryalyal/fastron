<?php
define('CLI_SCRIPT', true);

require_once(__DIR__ . '/../config.php');

$conn = @mysqli_connect($CFG->dbhost, $CFG->dbuser, $CFG->dbpass, $CFG->dbname) or die('<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Database Error</title>
</head>
<body>
<h1>Error establishing a database connection</h1>
</body>
</html>');
//print_r($conn);die();

// Delete old file TUGAS which more than 5 months (150 days) ago
// Not delete data in database, just delete file in filedir
$num=0;
$sql = "SELECT id, contenthash, component, author, filearea, filesize, timecreated, FROM_UNIXTIME(timecreated) AS timestamp FROM `mdlip_files` WHERE component='assignsubmission_file' AND filearea='submission_files' AND from_unixtime(timecreated) < date_sub(now(), interval 150 day) ORDER BY timecreated DESC";
$query = mysqli_query($conn, $sql) or die('SQL ERROR: '.mysqli_error($conn));
while($fetch=mysqli_fetch_array($query)) {
  $num++;
  $id = isset($fetch['id']) ? $fetch['id'] : ''; // prevent notice error
  $contenthash = isset($fetch['contenthash']) ? $fetch['contenthash'] : ''; // prevent notice error
  $component = isset($fetch['component']) ? $fetch['component'] : ''; // prevent notice error
  $author = isset($fetch['author']) ? $fetch['author'] : '??'; // prevent notice error
  $filearea = isset($fetch['filearea']) ? $fetch['filearea'] : ''; // prevent notice error
  $filesize = isset($fetch['filesize']) ? $fetch['filesize'] : ''; // prevent notice error
  $timecreated = isset($fetch['timecreated']) ? $fetch['timecreated'] : ''; // prevent notice error
  $timestamp = isset($fetch['timestamp']) ? $fetch['timestamp'] : ''; // prevent notice error
  
  $fullpath = shell_exec('find '.$CFG->dataroot.' -type f -name "'.$contenthash.'" -exec ls -lh {} \; 2> /dev/null | awk \'{ print $9}\'');
  if($fullpath!='') {
    echo $fullpath;
  }
}
