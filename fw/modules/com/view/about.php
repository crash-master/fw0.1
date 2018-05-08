<?php Kernel\View::join(Kernel\Module::pathToModule('com').'view/head') ?>

<div class="container">

	<?php Kernel\View::join(Kernel\Module::pathToModule('com').'view/breadcrumbs') ?>
    
    <h1>Com</h1>
    <p>Module for fw framework <em>Ver. 1.1</em> for framework ver. 5</p>
    <p><a href="/com/help">Documentation helper</a></p>
    
</div>

<?php Kernel\View::join(Kernel\Module::pathToModule('com').'view/footer') ?>