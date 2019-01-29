<?php
/* $list [] */


use devskyfly\php56\types\Vrbl;
?>

<div class="row">
    <div "col-xs-12">
        <div  class="well well-sm">
        	<div class=>
        		<h3>Подчиненные площадки:</h3>
        	</div>
        	<div>
        	<?if(!Vrbl::isEmpty($list)):?>
            	<table class="table table-striped">
            	<?$i=0;?>
            	<?foreach ($list as $item):?>
            	<?$i++;?>
            		<tr>
            			<td><?=$i?></td>
            			<td><?=$item['active']?'Y':'N'?></td>
                		<td>
                			<?=$item['name']?>
                			<span><?=$item['url']?></span>
                		</td>
            		</tr>
        		<?endforeach;?>
            	</table>
        	<?endif;?>
        	</div>
        </div>
    </div>
</div>