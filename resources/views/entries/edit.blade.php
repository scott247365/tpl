@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
	@component('menu-icons-entry') {{ $entry->id }} @endcomponent
@endcomponent

<div class="container">
	<h1>Edit Template</h1>

	<form method="POST" action="/entries/update/{{ $entry->id }}">

		<div class="form-group entry-title-div">
			<input type="text" name="title" class="form-control" value="{{$entry->title }}" />
		</div>

		<div class="form-group entry-description-div">
			<textarea name="description" class="form-control entry-description-text">{{$entry->description }}</textarea>	
		</div>

		<div class="form-group entry-description-div">
			<textarea name="description_language1" class="form-control entry-description-text" >{{$entry->description_language1 }}</textarea>	
		</div>

		<div class="form-group">			
			<input type="checkbox" name="is_template_flag" id="is_template_flag" class="" value="{{$entry->is_template_flag }}" {{ ($entry->is_template) ? 'checked' : '' }} />
			<label for="is_template_flag">Is Template</label>
		</div>
		
		<div class="form-group">
			<button type="submit" name="update" class="btn btn-primary">Save</button>
		</div>
		
		{{ csrf_field() }}
	</form>
	
</div>

@stop
