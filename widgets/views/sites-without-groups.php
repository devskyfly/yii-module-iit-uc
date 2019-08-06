<?php
/* $list [] */


use devskyfly\php56\types\Vrbl;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-xs-12">
        <div  class="well well-sm">
        	<div >
        		<h3>Площадки без привязки к группе:</h3>
        	</div>
        	<div>
        	<?if(!Vrbl::isEmpty($list)):?>
            	<table class="table table-striped">
				<tr>
					<th>Активность</th>
					<th>Показывать в калькуляторе</th>
					<th>Площадка</th>
				</tr>
            	<?$i=0;?>
            	<?foreach ($list as $item):?>
            	<?$i++;?>
            		<tr>
						<td class="list-item-active">
							<?=$item['active']?>
						</td>
						<td class="list-item-show-in-calc">
							<?=$item['flag_show_in_calc']?>
						</td>
						<td class="list-item-info">
							<a href="<?=Url::toRoute(['/iit-uc/sites/entity-edit','entity_id'=>$item['id']])?>">
								<?=$item['name']?>
							</a>
						</td>
            		</tr>
        		<?endforeach;?>
            	</table>
        	<?endif;?>
        	</div>
        </div>
    </div>
</div>