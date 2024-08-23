<?php
require __DIR__ . '/wp-config.php';

global $wpdb;

$t_posts = $table_prefix.'posts';
$t_users = $table_prefix.'users';
$domain = $_SERVER['SERVER_NAME'];
$nm_kampus = 'UBBG';

//echo '<h1>Berita '.$nm_kampus.'</h1>';
$sql = "SELECT A.ID, B.display_name, A.post_title, A.post_date, A.post_name FROM $t_posts A, $t_users B WHERE A.post_author=B.ID AND A.post_type='post' AND A.post_status='publish' ORDER BY A.post_date DESC";
$num=0;
$result = $wpdb->get_results ($sql);
if(is_array($result) && count($result)>0) {
    echo '<ul>';
    foreach ($result as $print) {
        $num++;
        echo '<li><a href="https://'.$domain.'/'.$print->post_name.'" target="_blank">'.$print->post_title.'</a></li>';
    }
    echo '</ul>';
}
else {
    echo '<h3 style="color:red;text-align:center;">Belum ada berita</h3>';
}

//echo '<h1>Laman '.$nm_kampus.'</h1>';
$sql = "SELECT A.ID, B.display_name, A.post_title, A.post_date, A.post_name FROM $t_posts A, $t_users B WHERE A.post_author=B.ID AND A.post_type='page' AND A.post_status='publish' ORDER BY A.post_title ASC";
$num=0;
$result = $wpdb->get_results ($sql);
if(is_array($result) && count($result)>0) {
    echo '<ul>';
    foreach ($result as $print) {
        $num++;
        echo '<li><a href="https://'.$domain.'/'.$print->post_name.'" target="_blank">'.$print->post_title.'</a></li>';
    }
    echo '</ul>';
}
else {
    echo '<h3 style="color:red;text-align:center;">Belum ada laman</h3>';
}
