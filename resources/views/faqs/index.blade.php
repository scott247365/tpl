@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
	@component('menu-icons-links', ['data' => (isset($data) ? $data : null)])@endcomponent	
	@component('control-search')@endcomponent	
@endcomponent

<div class="container">
	@if (Auth::check())
		<h1>Faqs</h1>
		<a href="/faqs/add" class="btn btn-primary">Add</a>
		<table class="table">
			<tbody>@foreach($faqs as $faq)
				<tr>
					<td style="width:10px;">
						<a href='/faqs/edit/{{$faq->id}}'><span class="glyphCustom glyphicon glyphicon-edit"></span></a>
					</td>
					<td style="width:10px; padding-right:20px;">
						<a href='/faqs/confirmdelete/{{$faq->id}}'><span class="glyphCustom glyphicon glyphicon-trash"></span></a>
					</td>
					<td>
						<a target="" href="/faqs/view/{{$faq->id}}">{{$faq->title}}</a>
					</td>
				</tr>
			@endforeach</tbody>
		</table>
	@else
		<h3>You need to log in. <a href="/login">Click here to login</a></h3>
	@endif
               
</div>
@endsection
