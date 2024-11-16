<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo $table;?>

<?php if (! $hasFailures): ?>
    <div class="mt-8">
        <a href="<?php echo site_url('update/check');?>" class="btn-main">Begin update &rarr;</a>
    </div>
<?php endif;?>