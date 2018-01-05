<script>

function clearSearch()
{
	$('#searchList').hide();
	$('#search').val('');
	$('#search').focus();
}

function onInput()
{
	var val = $('#search').val();
		
	if (val.length >= 3)
	{
		search('/entries/search/' + val);
	}
	else
	{
		$('#searchList').hide();
	}
}

function search(url) 
{
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() 
	{
		if (this.status == 200)
		{
			//alert(this.responseText);
		}
					
		if (this.readyState == 4 && this.status == 200) 
		{	
			/*
			alert(
				'call response: ' + this.responseText +
				', length: ' + this.responseText.length 
				+ ', char: ' + this.responseText.charCodeAt(0) 
				+ ' ' + this.responseText.charCodeAt(1)
			);
			*/
			
			if (this.responseText.search("search result") != -1) // make sure it's not the login page after a session timeout
			{
				//
				// search results
				//
				//alert(this.responseText.length + ': ' + this.responseText);
				if (this.responseText.length > 27) // valid search results more than: "<!-- search results -->  "
				{
					//alert(this.requestText);
					
					$('#searchList').show();
					$('#searchList').html(this.responseText);
				}
				else // no results
				{
					$('#searchList').hide();
				}
			}
			else
			{
				//
				// login screen
				//
				//alert('timeout');
				window.location = '/';
			}
		}
	};
	
	xhttp.open("GET", url, true);
	xhttp.send();
}

</script>

<style>
/* this is to override the textbox button position so it doesn't overwrite the right border of the textbox */

.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    margin-left: 0px;
    z-index: 2;
}
</style>

<div class="float-left" style="margin-top: 10px; margin-left: 20px; max-width:200px;">

	<form method="POST" action="/entries/search">
	
		<div class="input-group">
			<input type="text" id="search" name="search" class="form-control" placeholder="Search" value="" oninput="onInput();" autocomplete="off" />
			
			<span class="input-group-btn">
				<button style="width:50%;border:1px solid LightGray;" onclick="clearSearch()" class="btn btn-secondary" type="button">
					<span style="padding:0;margin:0;margin-left:-7px;color:gray" class="glyphCustom glyphicon glyphicon-remove"></span>
				</button>
			</span>
		</div>
		
		{{ csrf_field() }}
	</form>		
		
</div>

<div id="searchList" style="margin-left: 10px; display:none; padding-top: 15px;" class="dropdown">

</div>		

<div class="clear"></div>

