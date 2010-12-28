<?php
/**
 * Wiki Header
 *
 * @package		Nova
 * @category	Include
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.3
 *
 * Cleaned up the file a little bit
 */

// pull in the config file
$this->load->config('thresher');

// grab the type of parsing
$parse = $this->config->item('parsetype');

$faceboxcss = ( ! is_file(APPPATH.'views/'.$current_skin.'/wiki/css/jquery.facebox.css'))
	? base_url().APPFOLDER.'/assets/js/css/jquery.facebox.css'
	: base_url().APPFOLDER.'/views/'.$current_skin.'/wiki/css/jquery.facebox.css';
	
$uiTheme = ( ! is_file(APPPATH .'views/'.$current_skin.'/wiki/css/jquery.ui.theme.css'))
	? base_url().APPFOLDER.'/assets/js/css/jquery.ui.theme.css'
	: base_url().APPFOLDER.'/views/'.$current_skin.'/wiki/css/jquery.ui.theme.css';

?><style type="text/css">
			@import url("<?php echo base_url().APPFOLDER.'/assets/js/css/jquery.ui.core.css';?>");
			@import url('<?php echo $faceboxcss;?>');
			@import url('<?php echo $uiTheme;?>');
			@import url("<?php echo base_url().APPFOLDER.'/assets/js/markitup/skins/simple/style.css';?>");
			@import url("<?php echo base_url().APPFOLDER.'/assets/js/markitup/sets/'.$parse.'/style.css';?>");
			
			ul, ol { margin: 1em; padding: .5em; }
			ul li, ol li { margin: 2px; }
			ul { list-style: disc; }
			ol { list-style: decimal; }
			
			.panel-handle ul, .panel-handle ol, .panel-body ul { margin: 0; padding: 0; list-style: none; }
			.panel-handle ul li, .panel-handle ol li { margin: 0; }
			
			.label-system {
				padding: 1px 3px;
				
				background: #2d90c3;
				color: #fff;
				text-shadow: 0 1px 0 rgba(0, 0, 0, .3);
				font-size: 75%;
				border: 1px solid #26749c;
				
				border-radius: 2px;
				-moz-border-radius: 2px;
			}
		</style>
			
		<script type="text/javascript" src="<?php echo base_url().APPFOLDER.'/assets/js/jquery.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().APPFOLDER.'/assets/js/jquery.lazy.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().APPFOLDER.'/assets/js/jquery.ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().APPFOLDER.'/assets/js/jquery.ui.widget.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().APPFOLDER.'/assets/js/jquery.facebox.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().APPFOLDER.'/assets/js/markitup/jquery.markitup.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().APPFOLDER.'/assets/js/markitup/sets/'.$parse.'/set.js';?>"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$.lazy({					
					src: '<?php echo base_url().APPFOLDER;?>/assets/js/jquery.ui.tabs.min.js',
					name: 'tabs',
					cache: true
				});
				
				$('a#userpanel').toggle(function(){
					$('div.panel-body').slideDown('normal', function(){
						$('.panel-trigger div.ui-icon').removeClass('ui-icon-triangle-1-s');
						$('.panel-trigger div.ui-icon').addClass('ui-icon-triangle-1-n');
					});
					return false;
				}, function(){
					$('div.panel-body').slideUp('normal', function(){
						$('.panel-trigger div.ui-icon').removeClass('ui-icon-triangle-1-n');
						$('.panel-trigger div.ui-icon').addClass('ui-icon-triangle-1-s');
					});
					return false;
				});
				
				$.facebox.settings.loadingImage = '<?php echo base_url().APPFOLDER;?>/assets/js/images/facebox-loading.gif';
				
				$('.markitup').markItUp(mySettings);
			});
		</script>