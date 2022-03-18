/////////////////////////////////
// Remove Some Columns from Post and Page
/////////////////////////////////

function my_columns_filter( $columns ) {
    unset($columns['tags']);
    unset($columns['comments']);
	unset($columns['wpseo-score']);
	unset($columns['wpseo-score-readability']);
	unset($columns['wpseo-title']);
	unset($columns['wpseo-metadesc']);
	unset($columns['wpseo-focuskw']);
	unset($columns['wpseo-links']);
	unset($columns['wpseo-linked']);
    return $columns;
}
add_filter( 'manage_edit-post_columns', 'my_columns_filter', 10, 1 );
add_filter( 'manage_edit-page_columns', 'my_columns_filter', 10, 1 );
