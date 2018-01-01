@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

<div class="container">
               
<form method="POST" action="/entries/{{ $entry->id }}">

	<div class="form-group">
		<h2 name="title" class="">{{$entry->title }}</h2>
	</div>

	<div class="form-group">
		<span name="description" class="">{{$entry->description }}</span>	
	</div>

	<div class="form-group">
		<span name="description_language1" class="">{{$entry->description_language1 }}</span>
	</div>
	
{{ csrf_field() }}
</form>

</div>
@endsection
