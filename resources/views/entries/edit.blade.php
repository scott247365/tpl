@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

	<div class="container">
	<h1>Edit</h1>

<form method="POST" action="/entries/update/{{ $entry->id }}">

	<div class="form-group">
		<textarea name="title" class="form-control">{{$entry->title }}</textarea>
	</div>

	<div class="form-group">
		<textarea name="description" class="form-control">{{$entry->description }}</textarea>	
	</div>

	<div class="form-group">
		<textarea name="description_language1" class="form-control">{{$entry->description_language1 }}</textarea>	
	</div>

	<div class="form-group">
		<button type="submit" name="update" class="btn btn-primary">Update Entry</button>
	</div>
{{ csrf_field() }}
</form>

</div>

@stop
