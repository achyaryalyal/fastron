<?php
require_once(__DIR__ . '/../config.php');
$output = shell_exec('du -x --max-depth=1 '.$CFG->dataroot.' | sort -n | awk \'{ print $2 }\' | xargs du -hx --max-depth=0');
echo nl2br($output);
