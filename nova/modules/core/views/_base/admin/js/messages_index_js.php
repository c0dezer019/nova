<script type="text/javascript" src="<?php echo base_url() . MODFOLDER .'/assets/js/jquery.quicksearch.js';?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('table.inbox_search tbody tr').quicksearch({
			position: 'append',
			attached: 'div.search_inbox',
			labelText: '',
			inputText: '<?php echo ucwords(lang("actions_search") ." ". lang("labels_inbox"));?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
		
		$('#inbox_check_all').click(function(){
			$("div.inbox input[type='checkbox']").attr('checked', $('#inbox_check_all').is(':checked'));
		});
		
		$('#loading').hide();
		$('#loaded').removeClass('hidden');
	});
</script>