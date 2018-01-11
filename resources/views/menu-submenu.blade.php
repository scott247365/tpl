<nav class="margin:0; padding:0; large-3 medium-4 columns" id="submenu">
	
	<div class="submenu">
		<ul class="submenu">
			{{ $slot }}
			@component('menu-icons-links', ['data' => (isset($data) ? $data : null)])
			@endcomponent
		</ul>		
	</div>

	<?php 
		//dd($taskCount);
		// echo 'submenu: '; 
		//dd($templates[0]->id); 
		$templates = (isset($templates)) ? $templates : [];
	?>
	
	@component('control-search', ['templates' => $templates])
	@endcomponent
	
</nav>
