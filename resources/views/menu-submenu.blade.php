<nav class="margin:0; padding:0; large-3 medium-4 columns" id="submenu">
	
	<div class="submenu">
		<ul class="submenu">
			{{ $slot }}
			@component('menu-icons-links')
			@endcomponent
		</ul>		
	</div>

	<?php 
		// echo 'submenu: '; 
		//dd($templates[0]->id); 
		$templates = (isset($templates)) ? $templates : [];
	?>
	
	@component('control-search', ['templates' => $templates])
	@endcomponent
	
</nav>
