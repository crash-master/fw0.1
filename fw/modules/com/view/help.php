<?php use Kernel\View; use Kernel\Module; ?>
<?php View::join(Module::pathToModule('com').'view/head') ?>

<script type="text/javascript" src="/<?= Module::pathToModule('com') ?>js/com.js"></script>

<div class="container">

    <?php View::join(Module::pathToModule('com').'view/breadcrumbs') ?>
    
    <h1>Com Helper</h1>
    
    <div class="col-md-12">
        <h3>Info</h3>
    </div>

    <div class="col-md-12">

        <a href="/com/help">/com/help</a>

        <p class="desciption">Get list all commands if exists</p>

    </div>
    
    <div class="col-md-12">
       
        <a href="/com/routes">/com/routes</a>
        
        <p class="desciption">Get list all routes</p>
        
    </div>

    <div class="col-md-12">
       
        <a href="/com/components">/com/components</a>
        
        <p class="desciption">Get list all components</p>
        
    </div>

    <div class="col-md-12">
        <h3>Migrations</h3>
    </div>

    <div class="col-md-12">

        <a href="#" data-row="/com/migrations/up/{name}">/com/migrations/up/{name}</a>

        <p class="desciption">Set migration with name '{name}'</p>

    </div>
    
    <div class="col-md-12">

        <a href="#" data-row="/com/migrations/down/{name}">/com/migrations/down/{name}</a>

        <p class="desciption">Unset migration with name '{name}'</p>

    </div>
    
    <div class="col-md-12">

        <a href="/com/migrations/up">/com/migrations/up</a>

        <p class="desciption">Set all migration</p>

    </div>
    
    <div class="col-md-12">

        <a href="/com/migrations/down">/com/migrations/down</a>

        <p class="desciption">Unset all migration</p>

    </div>

    <div class="col-md-12">

        <a href="#" data-row="/com/migrations/refresh/{name}">/com/migrations/refresh/{name}</a>

        <p class="desciption">Refresh migration with name '{name}'</p>

    </div>

    <div class="col-md-12">

        <a href="/com/migrations/refresh">/com/migrations/refresh</a>

        <p class="desciption">Refresh all migrations</p>

    </div>

    <div class="col-md-12">

        <a href="/com/migrations/list">/com/migrations/list</a>

        <p class="desciption">View migration list</p>

    </div>
    
    <div class="col-md-12">
        <h3>Create</h3>
    </div>

    <div class="col-md-12">

        <a href="#" data-row="/com/create/controller/{name}">/com/create/controller/{name}</a>

        <p class="desciption">Create controller with name '{name}'</p>

    </div>
    
    <div class="col-md-12">

        <a href="#" data-row="/com/create/model/{name}">/com/create/model/{name}</a>

        <p class="desciption">Create model with name '{name}'</p>

    </div>
    
    <div class="col-md-12">

        <a href="#" data-row="/com/create/set/{name}">/com/create/set/{name}</a>

        <p class="desciption">Create set with name '{name}'</p>

    </div>
    
    <div class="col-md-12">

        <a href="#" data-row="/com/create/migration/{name}">/com/create/migration/{name}</a>

        <p class="desciption">Create migration with name '{name}'</p>

    </div>
    
</div>

<br>
<br>
<br>

<?php View::join(Module::pathToModule('com').'view/footer') ?>