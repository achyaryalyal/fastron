function my_columns_filter( $columns ) {
    unset($columns['tags']);
    unset($columns['comments']);
    return $columns;
}
add_filter( 'manage_edit-post_columns', 'my_columns_filter', 10, 1 );
