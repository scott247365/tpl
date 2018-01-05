<nav class="margin:0; padding:0; large-3 medium-4 columns" id="submenu">

	<div class="submenu">
		<ul class="submenu">
			{{ $slot }}
		</ul>
	</div>

	@component('control-search')
	@endcomponent
	
</nav>
