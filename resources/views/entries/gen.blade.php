@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

<div class="container">
               
<form method="POST" action="/entries/gen/{{ $entry->id }}">

	<div class="form-group">
		<h2 name="title" class="">{{$entry->title }}</h2>
	</div>
	
	<div class="entry-div">
		<a href='#' onclick="javascript:copyToClipboardAndCount('entry', 'entryCopy', '/entries/updateviews/{{$entry->id}}')";>
			<span class="glyphCustom glyphicon glyphicon-copy"></span>
		</a>
	
		<div class="entry">
			<span name="description" class="">{!! $entry->description !!}</span>	
			<span class="entry-copy" id="entryCopy">{!! $description_copy !!}</span>		
		</div>

		<a href='#' onclick="javascript:copyToClipboardAndCount('entry2', 'entryCopy2', '/entries/updateviews/{{$entry->id}}')";>
			<span class="glyphCustom glyphicon glyphicon-copy"></span>
		</a>
		
		<div class="entry entry2">
			<span name="description_language1" class="">{!! $entry->description_language1 !!}</span>
			<span class="entry-copy" id="entryCopy2">{!! $description_copy2 !!}</span>		
		</div>
	</div>
	
{{ csrf_field() }}
</form>

</div>
@endsection
