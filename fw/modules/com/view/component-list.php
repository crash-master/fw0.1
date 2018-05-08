<?php
use Kernel\{View, Module};
?>
<?php View::join(Module::pathToModule('com').'view/head') ?>

	<div class="container">

		<?php View::join(Module::pathToModule('com').'view/breadcrumbs') ?>
	
		<h2>Component list</h2>

		<?php if(count($components)): ?>

		<?php foreach($components as $name => $component): ?>

			<ul class="collection with-header">

	    		<li class="collection-header"><h4 class="red-text text-darken-2" title="Component name"><?= $name ?></h4></li>

			<?php foreach($component as $view => $action): ?>

					<li class="collection-item">

			        	<div>

			        		<strong title="Path to view"><?= $view ?></strong>

			        		<div class="secondary-content" title="Action">

								<?php if(!is_array($action)): ?>
									
							        <p><?= $action ?></p>

								<?php else: ?>

									<?php foreach($action as $i => $data): ?>

										<p><?= $data ?></p>

									<?php endforeach; ?>

								<?php endif; ?>
					
							</div>

						</div>

					</li>
					
			<?php endforeach; ?>

			</ul>

		<?php endforeach; ?>

		<?php else: ?>
		
			<p class="card-panel red lighten-3">Components was not found</p>

		<?php endif; ?>

	</div>

<?php View::join(Module::pathToModule('com').'view/head') ?>