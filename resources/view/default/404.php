<?php View::join('default-layouts/head'); ?>

<div class="col-md-6 col-md-offset-3 col-xs-6 col-xs-offset-3">
	<p>:(</p>
	<p>Sorry, 404</p>
	<p>Link <span><?= Request::getUrl() ?></span> not found</p>
	<a href="#" onclick="history.go(-1);return false;">Go back</a>
</div>

<?php View::join('default-layouts/footer'); ?>