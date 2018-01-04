<!-- search results -->
<style>
a:hover {
	text-decoration:none
}
</style>

@foreach($entries as $entry)
<div style="padding: 3px 0px;">
	<a style="" href="/entries/gen/{{$entry->id}}">{{$entry->title}}</a>
</div>
@endforeach
