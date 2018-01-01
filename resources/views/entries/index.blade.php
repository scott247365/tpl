@extends('layouts.app')

@section('content')

@component('menu-submenu')
	@component('menu-icons-start')@endcomponent
@endcomponent

<div class="container">
                @if (Auth::check())
                        <table class="table">
                        <tbody>@foreach($user->entries as $entry)
                            <tr>
								<td>
									<a href='/entries/edit/{{$entry->id}}'><span class="glyphCustom glyphicon glyphicon-edit"></span></a>
								</td>
                                <td>
                                    <a href="/entries/view/{{$entry->id}}">{{$entry->title}}</a>
                                </td>
                                <td>
									<a href='/entries/delete/{{$entry->id}}'><span class="glyphCustom glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                            
    
                        @endforeach</tbody>
                        </table>
                @else
                    <h3>You need to log in. <a href="/login">Click here to login</a></h3>
                @endif
               
</div>
@endsection
