@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

<div class="container">
                <h2>Add Entry</h2>
               
<form method="POST" action="/entries/create">

    <div class="form-group">
        <textarea name="title" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <textarea name="description" class="form-control"></textarea>  
    </div>

    <div class="form-group">
        <textarea name="description_language1" class="form-control"></textarea>  
    </div>
	
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Add Entry</button>
    </div>
{{ csrf_field() }}
</form>


</div>
@endsection
