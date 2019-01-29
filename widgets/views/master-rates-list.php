<?php
/* $list [] */


use devskyfly\php56\types\Vrbl;
?>

<div class="row">
	<div class="col-sm-12">
		<h3>Тарифы хозяева:</h3>
	</div>
	<div>
	<?if(!Vrbl::isEmpty($list)):?>
    	<table>
    	<?$i=0;?>
    	<?foreach ($list as $item):?>
    	<?$i++;?>
    		<tr>
    			<td><?=$i?></td>
    			<td><?=$item['active']?></td>
        		<td>
        			<a href="<?=$item['link']?>"><?=$item['name']?></a>
        		</td>
    		</tr>
		<?endforeach;?>
    	</table>
	<?endif;?>
	</div>
</div>