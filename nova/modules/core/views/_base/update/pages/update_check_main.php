<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<div class="space-y-8">
	<?php if (filled($update['notes'])): ?>
		<div class="bg-info-50 rounded-lg" data-slot="info">
			<div class="p-6 prose prose-a:no-underline prose-h3:text-info-800 prose-p:text-info-700 max-w-none">
				<h3>What's new in this release?</h3>
				<p><?php echo $update['notes'];?></p>
			</div>
		</div>
	<?php endif;?>

	<div class="flex items-start justify-between">
		<div class="prose">
			<h3>Get the new files</h3>
			<p>The first thing you'll need to do is download the new Nova files from the Anodyne site (make sure that you download the same genre as you have installed). Once you've downloaded the files, follow the directions in the <a href="https://anodyne-productions.com/docs/2.7/update-guide" target="_blank" class="underline text-gray-600 hover:text-gray-950">update guide</a>.</p>
		</div>
		<div class="ml-6 flex shrink-0 items-center">
			<a href="<?php echo $update['link'];?>" class="btn-sec">Get the files</a>
		</div>
	</div>

	<div class="flex items-start justify-between">
		<div class="prose">
			<h3>Already have the new files?</h3>
			<p>If you've already downloaded the files and uploaded them to your server, but just need to update your database, you can start the update process now.</p>
		</div>
		<div class="ml-6 flex shrink-0 items-center">
			<a href="<?php echo site_url('update/run');?>" id="next" class="btn-main">Update Nova now &rarr;</a>
		</div>
	</div>
</div>
