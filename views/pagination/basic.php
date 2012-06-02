<?php 
$first = '<<&nbsp;';
$prev = '前のページ';
$next = '次のページ';
$last = '&nbsp;>>';
?>

<p class="pagination">

	<?php if ($first_page !== FALSE): ?>
		<a href="<?php echo $url.$first_page ?>" rel="first"><?php echo $first ?></a>
	<?php else: ?>
		<?php //echo $first ?>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo $url.$previous_page ?>" rel="prev"><?php echo $prev ?></a>
	<?php else: ?>
		<?php //echo $prev ?>
	<?php endif ?>

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<strong><?php echo $i ?></strong>
		<?php else: ?>
			<a href="<?php echo $url.$i ?>"><?php echo $i ?></a>
		<?php endif ?>

	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?>
		<a href="<?php echo $url.$next_page ?>" rel="next"><?php echo $next ?></a>
	<?php else: ?>
		<?php //echo $next ?>
	<?php endif ?>

	<?php if ($last_page !== FALSE): ?>
		<a href="<?php echo $url.$last_page ?>" rel="last"><?php echo $last ?></a>
	<?php else: ?>
		<?php //echo $last ?>
	<?php endif ?>

</p><!-- .pagination -->