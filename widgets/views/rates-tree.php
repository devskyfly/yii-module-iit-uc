<?php
/* $list [] */


use devskyfly\php56\types\Vrbl;
use yii\helpers\Url;
use devskyfly\yiiModuleIitUc\components\RatesManager;
?>

<?function ratesTreeListRender($list){?>
        <?if(!Vrbl::isEmpty($list)):?>
                	<ol class="list-group">
                	<?foreach ($list as $item):?>
                		<li class="list-group-item">
                			<?=$item['item']['active']?> 
                    		<a target="_blank"
                    			href="<?=Url::toRoute(['/iit-uc/rates/entity-edit','entity_id'=>$item['item']['id']])?>">
                    			<?=$item['item']['name']?>
                    		</a>
                    		<span>
                    			<?=RatesManager::getCost($item['item'])?> (<?=$item['item']['price']?>)
                    			<?=$item['item']['flag_for_license']=='Y'?'L':''?>
                    			<?=$item['item']['flag_for_crypto_pro']=='Y'?' CRYPTO':''?>
                    			<?=$item['item']['flag_is_terminated']=='Y'?' T':''?>
                    		</span>
                		</li>
                		<?if(isset($item['sublist'])&&(!Vrbl::isEmpty($item['sublist']))):?>
                			<li class="list-group-item">
                				<?ratesTreeListRender($item['sublist']);?>
            				</li>
                		<?endif;?>
            		<?endforeach;?>
                	</ol>
    	<?endif;?>
<?};?>

<div class="well well-lg">
<div class="row">
	<h2>Подчиненность тарифов:</h2>
</div>
<div class="row">
	<div class="col-xs-12">
    	<div>
			<?ratesTreeListRender($list);?>
    	</div>
    </div>
</div>
</div>

