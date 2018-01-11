	<li class="topMenuLiCenter">
		<a href='/entries/templates'>Layout</a>
	</li>
	<li class="topMenuLiCenter">
		<?php 
			//dd($data); 
			$taskCount = (isset($data)) ? $data['taskCount'] : 0;
		?>
		
		<a href='/tasks'>Follow up<?php echo (isset($taskCount) && intval($taskCount) > 0) ? ' (' . $taskCount . ')' : '' ?> </a>
	</li>
