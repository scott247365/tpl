@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

<div class="single-view-page container">
               
<form method="POST" action="/entries/encrypt">

	<div class="form-group">
		<label name="" class="">Enter Text:</label>	
		<input type="text" name="search" class="form-control" value="" />
	</div>
		
	<div class="form-group">
		<button type="submit" name="submit" class="btn btn-primary">Submit</button>
	</div>
	
{{ csrf_field() }}
</form>

</div>
@endsection