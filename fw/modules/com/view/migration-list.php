<?php use Kernel\{View, Module}; ?>
<?php View::join(Module::pathToModule('com').'view/head') ?>

<?php //dd($migrations) ?>

<div class="container">

		<?php View::join(Module::pathToModule('com').'view/breadcrumbs') ?>
	
		<h2>Migration list</h2>

		<?php if(count($migrations)): ?>

		<?php foreach($migrations as $package => $migrationList): ?>

			<ul class="collection with-header">

	    		<li class="collection-header"><h4 class="red-text text-darken-2" title="Package name"><?= $package ?></h4></li>

			<?php foreach($migrationList as $i => $migration): ?>

					<li class="collection-item">

			        	<div>

			        		<strong title="Migration name"><?= $migration['name'] ?></strong>

			        		<div class="secondary-content" title="Action">
									
							        <p><?= $migration['path'] ?></p>
					
							</div>

						</div>

					</li>
					
			<?php endforeach; ?>

			</ul>

		<?php endforeach; ?>

		<?php else: ?>
		
			<p class="card-panel red lighten-3">Any migration was not found</p>

		<?php endif; ?>

	</div>


<?php View::join(Module::pathToModule('com').'view/footer') ?>