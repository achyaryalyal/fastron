#!/bin/bash

old_files=($(/usr/bin/php8.1 /home/bbg-spada/htdocs/spada.bbg.ac.id/admin/script-moodle-list-old-files.php))
for i in "${old_files[@]}"; do [ -f "$i" ] && rm "$i" && echo "$i deleted successfully"; done
