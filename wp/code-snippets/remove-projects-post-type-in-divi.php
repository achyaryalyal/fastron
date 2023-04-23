/////////////////////////////////
// Remove Projects Post Type in Divi
/////////////////////////////////

function remove_divi_projects() {
	unregister_post_type('project');
}
add_action('init', 'remove_divi_projects');

if(!function_exists('cliff_remove_divi_project_post_type')) {
	function cliff_remove_divi_project_post_type() {
		unregister_post_type('project');
		unregister_taxonomy('project_category');
		unregister_taxonomy('project_tag');
	}
}
add_action('init', 'cliff_remove_divi_project_post_type');
