@extends('layouts.app')

@section('content')

@component('menu-submenu', ['taskCount' => $taskCount])
	@component('menu-icons-start')@endcomponent
@endcomponent

	<div class="container">
	<h1>Edit</h1>

<form method="POST" action="/tasks/update/{{ $task->id }}">

	<div class="form-group">
		<input type="text" name="description" class="form-control" value="{{$task->description }}"></input>
	</div>

	<div class="form-group">
		<textarea name="link" class="form-control">{{$task->link }}</textarea>	
	</div>	

	<div class="form-group">
		<button type="submit" name="update" class="btn btn-primary">Update task</button>
	</div>
{{ csrf_field() }}
</form>

</div>

@stop
