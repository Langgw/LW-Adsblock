<?php 
/*
 Plugin Name: LW - AdBlocker
 Plugin URI: https://langw.web.id/
 Version: 1.6
 Author: Lang W
 Author URI: http://fb.me/otaku.kreasy
 Text Domain: lw-adblocker
 Description: Showing popup with notice if someone using AdBlocker.
 Tags: dhantiadblocker, anti-adblocker, adblocker, antiadblocker, adblock, adblocker, anti, ads, advertisement, popup, modal, adblock, clean, simple, anti-adblock, anti-adblocker, ad-blocker, ad-block
*/

function lw_install() {
	$options['lw_opt_enable']		= 1;
	$options['lw_opt_title']		= 'Disable Adblock!!';

	$options['lw_opt_content']		= 'Please support us by disabling your adblocker or whitelist this site from your adblocker. Thanks!';

	$options['lw_opt_width']		= sanitize_text_field('600px');
	$options['lw_opt_buttontext']	= sanitize_text_field('Refresh');
	$options['lw_opt_linecolor']	= sanitize_text_field('blue');
	$options['lw_opt_buttoncolor']	= sanitize_text_field('red');

	update_option('lw_adblocker', $options);
}
register_activation_hook( __FILE__, 'lw_install' );

function lw_init_admin(){
	add_action('admin_menu','lw_menu');
	add_action('admin_enqueue_scripts','lw_admin_enqueue');
}
add_action('init','lw_init_admin');

function lw_menu(){
	add_submenu_page( 'options-general.php', 'Lw Adblock', 'Lw Adblock',
    'manage_options', 'options-lwadblock', 'lw_form_menu');
}

function lw_admin_enqueue(){

	wp_enqueue_script('jquery');
	
}



function lw_adblock(){
	$options = get_option('lw_adblocker');
	$title = $options['lw_opt_title'];
	$txt = $options['lw_opt_content'];
	$width = $options['lw_opt_width'];	
	$btntext = $options['lw_opt_buttontext'];	
	$linecolor = $options['lw_opt_linecolor'];	
	$btncolor = $options['lw_opt_buttoncolor'];

	$plugin_url = plugin_dir_url( __FILE__ );
	wp_enqueue_script('jquery');
	wp_enqueue_script ( 'adblock-script', $plugin_url.'assets/js/fuckadblock.min.js', array(), '1.0.0', true );
	wp_enqueue_script ( 'confirm-script', $plugin_url.'assets/js/jquery-confirm.js', array(), '3.3.0', true );

	wp_enqueue_style( 'confirm-style', $plugin_url.'assets/css/jquery-confirm.css', array(), '3.3.0', false);
	wp_add_inline_script( 'confirm-script', '
	function adBlockDetected() {
	    jQuery("body").on("contextmenu",function(e){
			return false;
		});
		jQuery("html, body").css({
		    overflow: "hidden",
		    height: "auto"
		});
		jQuery.confirm({
			title: "'.$title.'",
			content: "'.$txt.'",
			draggable: false,
			useBootstrap: false,
			columnClass: "lw-adblock",
			boxWidth: "'.$width.'",
			type: "'.$linecolor.'",
			buttons: {
				refresh: {
					text: "'.$btntext.'",
					btnClass: "btn-'.$btncolor.'",
					action: function(){
						location.reload(true);
						return false;
					}
				}
			}
		});
		
	}
	function adBlockNotDetected(){

	}
	jQuery(document).ready(function(){

		var fuckAdBlock = new FuckAdBlock({
		checkOnLoad: true,
		resetOnEnd: true
		});
		fuckAdBlock.onDetected(adBlockDetected);
		fuckAdBlock.onNotDetected(adBlockNotDetected);

	});' );
}
add_action( 'wp_enqueue_scripts', 'lw_adblock' );

function lw_style_mobile(){
	$options = get_option('lw_adblocker');
	$width = $options['lw_opt_width'];	
?>
		<style type="text/css">
			
			@media only screen and (min-width : 480px),
			@media only screen and (min-width : 320px),
			@media only screen and (max-width : 320px),
			@media only screen and (max-width : 480px) {
				.lw-adblock {
					width: 90% !important;
					height: auto !important;
					margin: 0 auto !important;
					overflow: hidden !important;
				}

			@media only screen and (min-width : 768px),
			@media only screen and (min-width : 992px),
			@media only screen and (min-width : 1200px),
			@media only screen and (max-width : 1200px),
			@media only screen and (max-width : 992px),
			@media only screen and (max-width : 768px) {
				.lw-adblock {
					width: <?= $width ?> !important;
					height: auto !important;
					margin: 0 auto !important;
					overflow: hidden !important;
				}
			}
		</style>
<?php 
add_action('wp_head','lw_style_mobile');
}

include_once 'admin-setting.php';

?>
