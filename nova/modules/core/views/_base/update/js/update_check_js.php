<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
	});
</script>