<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Entry;

class EntryController extends Controller
{
    public function index()
    {
    	$user = Auth::user();
		
    	return view('entries.index', compact('user'));
    }

    public function add()
    {
    	return view('entries.add');
    }

    public function create(Request $request)
    {
    	$entry = new Entry();
    	$entry->title = $request->title;
    	$entry->description = $request->description;
    	$entry->description_language1 = $request->description_language1;
    	$entry->user_id = Auth::id();
    	$entry->save();
    	return redirect('/'); 
    }

    public function view(Entry $entry)
    {
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {            
			return view('entries.view', compact('entry'));
        }           
        else {
             return redirect('/');
         }            	
    }
	
    public function edit(Request $request, Entry $entry)
    {
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {            
			if(isset($_GET['delete'])) {
				return view('entries.delete', compact('entry'));
			}
			
			return view('entries.edit', compact('entry'));
        }           
        else {
             return redirect('/');
         }            	
    }

    public function delete(Entry $entry)
    {	
   		$entry->delete();
		
   		return redirect('/');
    }
	
    public function update(Request $request, Entry $entry)
    {	
		//dd($request);
			
   		$entry->title = $request->title;
   		$entry->description = $request->description;
   		$entry->description_language1 = $request->description_language1;
						
    	$entry->save();
    	return redirect('/'); 
    }
}
