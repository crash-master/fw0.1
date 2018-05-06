<? $errs = Err::any(); ?>

<? if($errs): ?>

    <ul class="list-group">
       
        <? foreach($errs as $item => $val): ?>
           
            <li class="list-group-item list-group-item-danger">
               
                <?= $val ?>
                
            </li>
            
        <? endforeach; ?>
        
    </ul>

<? endif; ?>