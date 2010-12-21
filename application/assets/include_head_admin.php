<?php
/**
 * Admin Header
 *
 * @package		Nova
 * @category	Include
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.3
 *
 * Updated the lazy load with the jquery.elastic plugin, added the max-height
 * attribute to the style tag
 */

?><style type="text/css">
			<?php if (!is_file(APPPATH .'views/'. $current_skin .'/admin/css/jquery.facebox.css')): ?>
				@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/jquery.facebox.css';?>");
			<?php else: ?>
				@import url("<?php echo base_url() . APPFOLDER .'/views/'. $current_skin .'/admin/css/jquery.facebox.css';?>");
			<?php endif;?>
			
			@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/jquery.ui.core.css';?>");
			
			<?php if (!is_file(APPPATH .'views/'. $current_skin .'/admin/css/jquery.ui.theme.css')): ?>
				@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/jquery.ui.theme.css';?>");
			<?php else: ?>
				@import url("<?php echo base_url() . APPFOLDER .'/views/'. $current_skin .'/admin/css/jquery.ui.theme.css';?>");
			<?php endif;?>
			
			#content, #message { max-height: 650px; }
		</style>
		
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.lazy.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.ui.widget.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.ui.tabs.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/reflection.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.facebox.js';?>"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$.lazy({					
					src: '<?php echo base_url() . APPFOLDER;?>/assets/js/jquery.prettyPhoto.js',
					name: 'prettyPhoto',
					dependencies: {
						css: ['<?php echo base_url() . APPFOLDER;?>/assets/js/css/jquery.prettyPhoto.css']
					},
					cache: true
				});
				
				$.lazy({					
					src: '<?php echo base_url() . APPFOLDER;?>/assets/js/jquery.ui.sortable.min.js',
					name: 'sortable',
					dependencies: {
						js: ['<?php echo base_url() . APPFOLDER;?>/assets/js/jquery.ui.mouse.min.js']
					},
					cache: true
				});
				
				$.lazy({					
					src: '<?php echo base_url() . APPFOLDER;?>/assets/js/jquery.ui.slider.min.js',
					name: 'slider',
					dependencies: {
						css: ['<?php echo base_url() . APPFOLDER;?>/assets/js/css/jquery.ui.slider.css'],
						js: ['<?php echo base_url() . APPFOLDER;?>/assets/js/jquery.ui.mouse.min.js']
					},
					cache: true
				});
				
				$.lazy({					
					src: '<?php echo base_url() . APPFOLDER;?>/assets/js/jquery.ui.accordion.min.js',
					name: 'accordion',
					dependencies: {
						css: ['<?php echo base_url() . APPFOLDER;?>/assets/js/css/jquery.ui.accordion.css']
					},
					cache: true
				});
				
				$.lazy({					
					src: '<?php echo base_url() . APPFOLDER;?>/assets/js/jquery.elastic.js',
					name: 'elastic',
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
				
				$.facebox.settings.loadingImage = '<?php echo base_url() . APPFOLDER;?>/assets/js/images/facebox-loading.gif';
				
				$('.reflect').reflect({
					opacity: '0.3'
				});
			});
		</script>