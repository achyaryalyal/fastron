/////////////////////////////////
// Multisite Support Webp
/////////////////////////////////

add_filter('site_option_upload_filetypes',
  function ( $filetypes ) {
    $filetypes = explode( ' ', $filetypes );
    if ( ! in_array( 'webp', $filetypes, true ) ) {
      $filetypes[] = 'webp';
      $filetypes   = implode( ' ', $filetypes );
    }
 
    return $filetypes;
  }
);
