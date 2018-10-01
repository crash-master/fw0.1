<?php use Kernel\{View, Module}; ?>
<?php View::join(Module::pathToModule('com').'view/head') ?>

	<div class="container">

		<?php View::join(Module::pathToModule('com').'view/breadcrumbs') ?>
	
		<h2>Route list</h2>

		<?php foreach($routes as $method => $routeList): ?>
			<?php if(count($routeList)): ?>

			<ul class="collection with-header">

	    		<li class="collection-header"><h4 class="red-text text-darken-2" title="Method name"><?= $method ?></h4></li>

			<?php foreach($routeList as $route => $action): ?>

				<li class="collection-item">

		        	<div>

		        		<strong <?php if($method == 'get'): ?> title="Route" <?php else: ?> title="Post row" <?php endif; ?>><?= $route ?></strong>

		        		<div class="secondary-content">

							<?php if($method == 'get'): ?>

						    	<span title="Action"><?= is_string($action) ? $action : 'anonymous function(){}' ?></span>

							<?php else: ?>
								
								<?php if($action['route']): ?>

						    		<span title="Route"><?= $action['route'] ?></span> : <span title="Action"><?= $action['action'] ?></span>

						    	<?php else: ?>

						    		<span title="Action"><?= $action['action'] ?></span>

						    	<?php endif; ?>

							<?php endif; ?>
				
						</div>

					</div>

				</li>
			<?php endforeach; ?>

			</ul>
			<?php endif; ?>
		<?php endforeach; ?>

	</div>

<?php View::join(Module::pathToModule('com').'view/footer') ?>