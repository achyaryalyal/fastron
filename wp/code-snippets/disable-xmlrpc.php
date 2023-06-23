/////////////////////////////////
// Disable XMLRPC
/////////////////////////////////

# disable pingbacks
function stop_pings ($vectors) {
  unset( $vectors['pingback.ping'] );
  return $vectors;
}
add_filter('xmlrpc_methods', 'stop_pings');

# prevent all authentication requests via xmlrpc
add_filter('xmlrpc_enabled', '__return_false');
