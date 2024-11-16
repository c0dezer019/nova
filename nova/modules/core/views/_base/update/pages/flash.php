<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if ($status == 'info'): ?>
	<div class="rounded-lg bg-warning-50 ring-1 ring-inset ring-warning-200 p-4 mb-8">
		<div class="flex items-center">
			<div class="shrink-0">
				<svg class="size-5 text-warning-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
					<path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
				</svg>
			</div>

			<div class="ml-3 flex-1 flex justify-between">
				<p class="text-sm/6 font-medium text-warning-700"><?php echo $message;?></p>
			</div>
		</div>
	</div>
<?php endif;?>

<?php if ($status == 'error'): ?>
	<div class="rounded-lg bg-danger-50 ring-1 ring-inset ring-danger-200 p-4 mb-8">
		<div class="flex items-center">
			<div class="shrink-0">
				<svg class="size-5 text-danger-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
					<path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
				</svg>
			</div>

			<div class="ml-3 flex-1 flex justify-between">
				<p class="text-sm/6 font-medium text-danger-700"><?php echo $message;?></p>
			</div>
		</div>
	</div>
<?php endif;?>