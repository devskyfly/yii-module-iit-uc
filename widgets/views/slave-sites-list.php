<?php
/* $list [] */


use devskyfly\php56\types\Vrbl;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-xs-12">
        <div  class="well well-sm">
        	<div >
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
            			<td><?=$item['active']?></td>
                		<td>
                			<a href="<?=Url::toRoute(['/iit-uc/sites/entity-edit','entity_id'=>$item['id']])?>" target="_blank">
                				<?=$item['name']?>
                			</a>
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