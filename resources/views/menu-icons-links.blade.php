
<?php 

//debug($filter . ', ' . $recordCount . ', ' . $filterString . ', ' . SHOW_ALL) 

if (!isset($filterString))
	$filterString = '';

?>

	<li class="topMenuLiCenter"><a href='/entries/index/default'><?= __('Popular') ?>&nbsp;<?= isset($recordCount) && $recordCount > 0 && ($filter == 20 || $filter == 0) && $filterString !== SHOW_ALL ? '(' . $recordCount . ')' : ''; ?></a></li><!-- Popular -->

	<li class="topMenuLiCenter"><a href='/entries/index/all'><?= __('All') ?>&nbsp;<?= isset($recordCount) && ($filterString === SHOW_ALL) ? '(' . $recordCount . ')' : ''; ?></a></li><!-- all -->

<?php if (false) : ?>

	<li class="topMenuLiCenter"><a href='/entries/index/<?= TYPE1 ?>'><?= __(TAG1) ?>&nbsp;<?= isset($recordCount) && ($filter == TYPE1) ? '(' . $recordCount . ')' : ''; ?></a></li><!-- emails -->

	<li class="topMenuLiCenter"><a href='/entries/index/<?= TYPE6 ?>'><?= __(TAG6) ?>&nbsp;<?= isset($recordCount) && ($filter == TYPE6) ? '(' . $recordCount . ')' : ''; ?></a></li><!-- canned -->

	<li class="topMenuLiCenter"><a href='/entries/index/<?= TYPE5 ?>'><?= __(TAG5) ?>&nbsp;<?= isset($recordCount) && ($filter == TYPE5) ? '(' . $recordCount . ')' : ''; ?></a></li><!-- steps -->

<?php endif; ?>
	
	<li class="topMenuLiCenter"><a href='/entries/index/<?= TYPE3 ?>'><?= __(TAG3) ?>&nbsp;<?= isset($recordCount) && ($filter == TYPE3) ? '(' . $recordCount . ')' : ''; ?></a></li><!-- notes -->

	<li class="topMenuLiCenter"><a href='/entries/index/<?= TYPE7 ?>'><?= __(TAG7) ?>&nbsp;<?= isset($recordCount) && ($filter == TYPE7) ? '(' . $recordCount . ')' : ''; ?></a></li><!-- templates -->
