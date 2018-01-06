@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

<div class="container">
	<h1 style="color: #337AB7; font-size:1.3em; margin-left:10px; margin-top:5px;">Templates ({{ count($entries) }})</h1>
	@if (Auth::check())
		<table class="table table-striped">
			<tbody>
			@foreach($entries as $entry)
				<tr>
					<td style="width:20px;">
						<a href='/entries/edit/{{$entry->id}}'><span class="glyphCustom glyphicon glyphicon-edit"></span></a>
					</td>
					<td>
						<a href="/entries/gendex/{{$entry->id}}">{{$entry->title}}</a>
						
						<?php if (intval($entry->view_count) > 0) : ?>
							<span style="color:#8CB7DD; margin-left: 5px; font-size:.9em;" class="glyphCustom glyphicon glyphicon-copy"><span style="font-family:verdana; margin-left: 2px;" >{{ $entry->view_count }}</span></span>
						<?php endif; ?>
						
					</td>
					<td>
						<a href='/entries/confirmdelete/{{$entry->id}}'><span class="glyphCustom glyphicon glyphicon-trash"></span></a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		<h3>You need to log in. <a href="/login">Click here to login</a></h3>
	@endif       
</div>
@endsection
