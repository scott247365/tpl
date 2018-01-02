@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

<div class="container">
	<h1>Edit</h1>

	<form method="POST" action="/entries/update/{{ $entry->id }}">

		<div class="form-group">
			<input type="text" name="title" class="form-control" value="{{$entry->title }}" />
		</div>

		<div class="form-group description-div">
			<textarea name="description" class="form-control description-text">{{$entry->description }}</textarea>	
		</div>

		<div class="form-group description-div">
			<textarea name="description_language1" class="form-control description-text" >{{$entry->description_language1 }}</textarea>	
		</div>

		<div class="form-group">
			<input type="checkbox" name="uses_template_flag" id="uses_template_flag" class="" value="{{$entry->uses_template_flag }}" {{ ($entry->uses_template_flag === 1) ? 'checked' : '' }} />
			<label for="uses_template_flag">Uses Template</label>
									
			<span>&nbsp;&nbsp;</span>
			
			<input type="checkbox" name="is_template_flag" id="is_template_flag" class="" value="{{$entry->is_template_flag }}" {{ ($entry->is_template_flag === 1) ? 'checked' : '' }} />
			<label for="is_template_flag">Is Template</label>
		</div>
		
		<div class="form-group">
			<button type="submit" name="update" class="btn btn-primary">Save</button>
		</div>
		
		{{ csrf_field() }}
	</form>
	
</div>

@stop
