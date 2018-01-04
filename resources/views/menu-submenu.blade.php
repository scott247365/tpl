
<nav class="large-3 medium-4 columns" id="submenu">

	<div class="float-left">
		<ul class="submenu">
			{{ $slot }}
		</ul>
	</div>

	@component('control-search')
	@endcomponent
</nav>

