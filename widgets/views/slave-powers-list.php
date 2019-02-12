<?php
/* $list [] */


use devskyfly\php56\types\Vrbl;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-xs-12">
        <div  class="well well-sm">
        	<div >
        		<h3>Подчиненные полномочия:</h3>
        	</div>
        	<div>
        	<?if(!Vrbl::isEmpty($list)):?>
            	<table class="table table-striped">
            	<?$i=0;?>
            	<?foreach ($list as $item):?>
            	<?$i++;?>
            		<tr>
            			<td colspan="3" class="list-group-item-info">
                			
                				<?=$item['package']['active']?> <?=$item['package']['name']?>
                			
            			</td>
            		</tr>
            		<?$j=0;?>
            		<?foreach ($item['powers'] as $power):?>
            			<?$j++;?>
                		<tr>
                			<td><?=$j?></td>
                			<td>
                    			<?=$power['active']?>
                    		</td>
                    		<td>
                    			<a target="_blank"
                    			href="<?=Url::toRoute(['/iit-uc/powers/entity-edit','entity_id'=>$power['id']])?>">
                    				<?=$power['name']?>
                    			</a>
                    		</td>
                		</tr>
            		<?endforeach;?>
        		<?endforeach;?>
            	</table>
        	<?endif;?>
        	</div>
        </div>
    </div>
</div>