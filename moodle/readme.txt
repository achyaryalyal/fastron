# run this command in terminal or with cron job every week
# adjust to your php version and change path with your moodle path

old_files=($(/usr/bin/php8.1 /[YOUR_MOODLE_PATH]/admin/script-moodle-list-old-files.php)) && for i in "${old_files[@]}"; do [ -f "$i" ] && rm "$i" && echo "$i deleted successfully"; done
