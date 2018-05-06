<?php if(count($breadcrumbs)): ?>
	
<style type="text/css">
	.breadcrumb:before{
		content: '-';
	}
</style>

<nav>
    <div class="nav-wrapper">
      <div class="col s12" style="padding-left: 20px;">
      	<?php foreach($breadcrumbs as $page => $link): ?>
        	<a href="<?= $link ?>" class="breadcrumb"><?= $page ?></a>
    	<?php endforeach; ?>
      </div>
    </div>
</nav>

<?php endif; ?>