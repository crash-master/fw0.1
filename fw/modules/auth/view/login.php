<?php View::join('default-layouts/head') ?>

<div class="container">

    <div class="col-md-6 col-md-offset-3">

        <form action="<?= linkTo('AuthController@login'); ?>" method="post" role="form">

            <h1>Log In</h1>

            <div class="form-group"><input type="email" name="email" class="form-control" placeholder="E-mail"></div>
            <div class="form-group"><input type="password" name="password" class="form-control" placeholder="Password"></div>
            <div class="form-group"><button class="btn btn-success">Log In</button></div>

        </form>

    </div>
    
    <div class="col-md-6 col-md-offset-3">
    
        <?php View::join('default-layouts/errs') ?>
    
    </div>

</div>

<?php View::join('default-layouts/footer') ?>