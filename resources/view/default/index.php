<script type="text/javascript">var studentFlag = false;</script>
<?php View::join('default/head'); ?>
<?php View::join('site/header') ?>
<?php if(!Auth::is(['role','student']) and !Auth::is(['role','manager'])): View::join('site/main_nav'); ?>
<?php else: ?>

<script type="text/javascript">
    $(document).ready(function(){$('button.menu').click().css('display','none');});
    studentFlag = true;
</script>

<?php endif; ?>
<?php View::join('site/main_table') ?>
<?php View::join('default/footer'); ?>