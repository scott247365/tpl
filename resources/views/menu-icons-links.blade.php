	<li class="topMenuLiCenter">
		<a href='/entries/templates'>Layout</a>
	</li>
	<li class="topMenuLiCenter">
		<a href='/tags'>Tags</a>
	</li>
	<li class="topMenuLiCenter">
		<?php 
			//dd($data); 
			$taskCount = (isset($data)) ? $data['taskCount'] : 0;
		?>
		
		<a href='/tasks'>Follow up<?php echo (isset($taskCount) && intval($taskCount) > 0) 
			? '<span style="background-color: LightGray; color: red; margin-left: 3px; font-size:.8em; padding:3px 5px; font-weight:bold;" class="badge">' . $taskCount . '</span>' 
			: '' ?> </a>
	</li>
