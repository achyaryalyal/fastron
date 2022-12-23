#!/bin/bash
# change [YOUR_MOODLE_PATH] with your moodle wwwroot path

old_files=($(/usr/bin/php8.1 /[YOUR_MOODLE_PATH]/admin/script-moodle-list-old-files.php))
for i in "${old_files[@]}"; do [ -f "$i" ] && rm "$i" && echo "$i deleted successfully"; done
