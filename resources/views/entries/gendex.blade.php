@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
	@component('menu-icons-entry') {{ $entry->id }} @endcomponent
@endcomponent

<div style="margin-top: 20px;" class="container">

<div style="width: 30%; min-width: 400px; margin-right: 20px;" class="float-left">
	@if (Auth::check())
		<table class="table table-striped">
			<tbody>
			@foreach($entries as $listentry)
				<tr>
					<td style="width:20px;">
						<a href='/entries/edit/{{$listentry->id}}'><span class="glyphCustom glyphicon glyphicon-edit"></span></a>
					</td>
					<td>
						<a href="/entries/gendex/{{$listentry->id}}">{{$listentry->title}}</a>
						
						<?php if (intval($listentry->view_count) > 0) : ?>
							<span style="color:#8CB7DD; margin-left: 5px; font-size:.9em;" class="glyphCustom glyphicon glyphicon-copy"><span style="font-family:verdana; margin-left: 2px;" >{{ $listentry->view_count }}</span></span>
						<?php endif; ?>
						
					</td>
					<td>
						<a href='/entries/confirmdelete/{{$listentry->id}}'><span class="glyphCustom glyphicon glyphicon-trash"></span></a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		<h3>You need to log in. <a href="/login">Click here to login</a></h3>
	@endif 
</div>

<style>

.entry-div-page {
	border: solid 1px rgb(232, 232, 232);
    border-radius: 6px;	
	padding: 10px;
	background-color: rgb(247, 247, 247);
}

</style>

<div style="min-width: 500px; width: 65%" class="float-left">
<form method="POST" action="/entries/gen/{{ $entry->id }}">

	<div class="form-group">
		<h2 style="font-size: 1.8em; margin:0;" name="title" class="">{{$entry->title }}</h2>
	</div>
	
	<div class="entry-div">
	
		<div class="entry entry-div-page">
			<a href='#' onclick="javascript:copyToClipboardAndCount('entry', 'entryCopy', '/entries/viewcount/{{$entry->id}}')";>
				<span class="glyphCustom glyphicon glyphicon-copy"></span>
			</a>
			<span name="description" class="">{!! $entry->description !!}</span>	
			<span class="entry-copy" id="entryCopy">{!! $description_copy !!}</span>		
		</div>
		
		<div class="entry entry2 entry-div-page">
			<a href='#' onclick="javascript:copyToClipboardAndCount('entry2', 'entryCopy2', '/entries/viewcount/{{$entry->id}}')";>
				<span class="glyphCustom glyphicon glyphicon-copy"></span>
			</a>
			<span name="description_language1" class="">{!! $entry->description_language1 !!}</span>
			<span class="entry-copy" id="entryCopy2">{!! $description_copy2 !!}</span>		
		</div>
	</div>
	
{{ csrf_field() }}
</form>
</div>
	
</div>
@endsection
