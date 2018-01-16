
@if(isset($templates) && count($templates) > 0)
<div class="float-left" style="margin-top: 10px; margin-left: 20px; max-width:200px;">

	<form method="POST" action="/entries/switch">

		<?php 
			/*
				echo 'search: <br/>';
				dd($templates); 
				window.location.href = parms + cat;
				this.value
				
					@if ($entry->id === Auth::user()->template_id) :
						<option value="{{ $entry->id }}">{{ $entry->title }}</option>
					@else
						<option value="{{ $entry->id }}">{{ $entry->title }}</option>
					@endif
			*/
		?>

		<div class="input-group">
		
			<select name="template" id="template" class="form-control" onchange="onTemplateChange(this.value)">
					<option value="-1">No Layout</option>
				@foreach($templates as $entry)
					<option value="{{ $entry->id }}" {{ ($entry->id === intval(Auth::user()->template_id)) ? 'selected' : '' }}>{{ $entry->title }}</option>
				@endforeach
			</select>			
		</div>
		
		{{ csrf_field() }}
	</form>		

</div>		
@endif

<div class="clear"></div>

