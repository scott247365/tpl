@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

<div class="container single-view-page">
	<h2>Add Entry</h2>
               
	<form method="POST" action="/entries/create">

		<div class="form-group">
			<input type="text" name="title" class="form-control" />
		</div>

		<div>
			<div class="form-group description-div">
				<textarea name="description" class="form-control description-text"></textarea>	
			</div>

			<div class="form-group description-div">
				<textarea name="description_language1" class="form-control description-text"></textarea>	
			</div>
		</div>

		<div style="clear: both;" class="form-group">
			<input type="checkbox" name="is_template_flag" id="is_template_flag" class="" />
			<label for="is_template_flag">Is Template</label>
		</div>
		
		<div class="form-group">
			<button type="submit" name="update" class="btn btn-primary">Add</button>
		</div>	
		
		{{ csrf_field() }}
	</form>

</div>
@endsection
