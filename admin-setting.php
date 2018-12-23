<?php 
function lw_form_menu(){
	if (isset($_POST['save'])) {

		$options['lw_opt_title']			= sanitize_text_field($_POST['lw_title']);

		$pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
		$options['lw_opt_content']		= preg_replace($pattern,esc_url('$1'),$_POST['lw_txt']);

		$options['lw_opt_width']			= sanitize_text_field($_POST['lw_width']);
		$options['lw_opt_buttontext']	= sanitize_text_field($_POST['lw_buttontext']);
		$options['lw_opt_linecolor']		= sanitize_text_field($_POST['lw_linecolor']);
		$options['lw_opt_buttoncolor']	= sanitize_text_field($_POST['lw_buttoncolor']);

		update_option('lw_adblocker',$options);
		// Show a message to say we've done something
		echo '<div class="updated dh-success-messages"><p><strong>'. __("Settings saved.","dh").'</strong></p></div>';
	} 


	$options = get_option('lw_adblocker');
	$title = $options['lw_opt_title'];
	$txt = $options['lw_opt_content'];
	$width = $options['lw_opt_width'];	
	$btntext = $options['lw_opt_buttontext'];	
	$linecolor = $options['lw_opt_linecolor'];	
	$btncolor = $options['lw_opt_buttoncolor'];

	$plugin_url = plugin_dir_url( __FILE__ );

?>
<link rel="stylesheet" type="text/css" href="<?php echo $plugin_url.'assets/css/admin-style.css' ?>">
<div class="row mb-12">
<div class="col-lg-12">
  <div class="cardxss">
    <div class="card-body">
      <h5 class="card-title mb-4">Setting Lw Adblock</h5>
      <form class="forms-sample" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">Title</label>
          <input type="text" name="lw_title" class="form-control " id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Insert Your Title" value="<?= $title ?>">
          <small>Title for your notification</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Text Content</label>
          <textarea  name="lw_txt" class="form-control" id="exampleInputPassword1" placeholder="Please Disable Adblock"><?= $txt ?></textarea> 
        </div>
        <div class="form-group">
          <label for="exampleTextarea">Width</label>
          <input type="text" name="lw_width" class="form-control " id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="600px" value="<?= $width ?>">
          <small>Width in pixel. Example 600px</small>
        </div>
        <div class="form-group">
          <label for="exampleTextarea">Text Button</label>
          <input type="text" name="lw_buttontext" class="form-control " id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Refresh" value="<?= $btntext ?>">
          <small>Text button. Example "Refresh"</small>
        </div>
        <div class="form-group">
          <label for="exampleTextarea">Line Color</label>
          <select id="linecolor" name="lw_linecolor" class="form-control">
            <option value="">Default</option>
            <option value="dark">Dark</option>
            <option value="red">Red</option>
            <option value="blue">Blue</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleTextarea">Button Color</label>
          <select id="btncolor" name="lw_buttoncolor" class="form-control">
            <option value="">Default</option>
            <option value="dark">Dark</option>
            <option value="red">Red</option>
            <option value="blue">Blue</option>
          </select>
        </div>
        <div class="form-group">
          <button type="submit" name="save" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
	   jQuery('#linecolor').val("<?= $linecolor ?>");
	   jQuery('#btncolor').val("<?= $btncolor ?>");
</script>
<?php } ?>
