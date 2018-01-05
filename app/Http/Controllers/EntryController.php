<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Entry;
use DB;

define('BODYSTYLE', '<span style="color:green;">');
define('ENDBODYSTYLE', '</span>');

class EntryController extends Controller
{
    public function index()
    {
    	//$user = Auth::user(); // original gets current user with all entries
		
		$entries = Entry::select()
			->where('user_id', '=', Auth::id())
			//->where('is_template_flag', '<>', 1)
			->orderByRaw('is_template_flag, view_count DESC')			
			->get();
		
    	return view('entries.index', compact('entries'));
    }

    public function add()
    {
		//todo $categories = Category::lists('title', 'id');
		
    	return view('entries.add');
    }

    public function create(Request $request)
    {		
		//dd($request);
		
    	$entry = new Entry();
    	$entry->title = $request->title;
    	$entry->description = $request->description;
    	$entry->description_language1 = $request->description_language1;
    	$entry->is_template_flag = (isset($request->is_template_flag)) ? 1 : 0;
    	//$entry->uses_template_flag = (isset($request->uses_template_flag)) ? 1 : 0; //sbw
    	$entry->user_id = Auth::id();
		
		//dd($entry);		
		
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

    public function gen(Entry $entry)
    {
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {    
			if ($entry->is_template_flag === 0 || $entry->is_template_flag === "0")
			{				
				// get the template
				$template = DB::table('entries')->where('is_template_flag', 1)->first();
				
				if ($template !== null)
				{	
					$descriptionCopy = $this->merge($template->description, $entry->description);		
					$descriptionCopy2 = $this->merge($template->description_language1, $entry->description_language1);
					
					$entry->description = $this->merge($template->description, $entry->description, /* style = */ true);			
					$entry->description_language1 = $this->merge($template->description_language1, $entry->description_language1, /* style = */ true);
					//dd($entry->description);

					$data = compact('entry');
					$data['description_copy'] = $descriptionCopy;
					$data['description_copy2'] = $descriptionCopy2;					
					//dd($data);
					
					return view('entries.gen', $data);
				}
				else
				{
					return view('entries.view', compact('entry'));
				}
			}
			else
			{
				return view('entries.view', compact('entry'));
			}	
        }           
        else 
		{
             return redirect('/');
		}            	
    }

    public function edit(Request $request, Entry $entry)
    {
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {
			// flags come from dev mysql as ints and prod mysql as strings
			$entry['is_template'] = ($entry->is_template_flag === "1" || $entry->is_template_flag === 1);

			return view('entries.edit', compact('entry'));
        }           
        else 
		{
             return redirect('/');
		}            	
    }

    public function confirmdelete(Request $request, Entry $entry)
    {	
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {
			return view('entries.delete', compact('entry'));
        }           
        else 
		{
             return redirect('/');
		}            	
    }
	
    public function delete(Request $request, Entry $entry)
    {	
		//dd($entry);
		
   		$entry->delete();
		
   		return redirect('/');
    }
	
    public function update(Request $request, Entry $entry)
    {	
		//dd($request);
			
   		$entry->title 					= $request->title;
   		$entry->description 			= $request->description;
   		$entry->description_language1 	= $request->description_language1;
    	$entry->is_template_flag 		= isset($request->is_template_flag) ? 1 : 0;
    	$entry->save();
		
    	return redirect('/'); 
    }
	
	private function merge($template, $description, $style = false)
	{
		$body = trim($description);
		if (mb_strlen($body) == 0)
			$body = '(' . strtoupper(__('Empty Body')) . ')';
		
		if (mb_strlen($template) > 0)
		{
			if ($style)
				$body = BODYSTYLE . $body . ENDBODYSTYLE;
				
			$description = nl2br(str_replace("[[body]]", $body, trim($template))) . '<br/>';
		}
		else
		{
			$description = nl2br($body) . '<br/>';
		}
	
		return $description;
	}	
	
    public function search($search)
    {
		$rc = 0;
		$userId = 1;
		$entries = null;

		if (mb_strlen($search) > 0)
		{
			// strip everything except alpha-numerics, colon, and spaces
			$search = preg_replace("/[^:a-zA-Z0-9 .]+/", "", $search);
		}
		else
		{
			echo 'no search string';
			return $rc;
		}

		if (mb_strlen($search) == 0)
		{
			echo 'no search string';
			return $rc;
		}

		$entries = Entry::where('user_id', '=', Auth::id())
			//->where('is_template_flag', '=', 0)
			->where('title', 'like', '%' . $search . '%')
			->orWhere('description', 'like', '%' . $search . '%')
			//->orWhere('description_language1', 'like', '%' . $search . '%')
			->orderBy('title')
			->limit(30)
			->get();

		//dd($entries);
				
    	return view('entries.search', compact('entries'));
	}
	
    public function viewcount(Entry $entry)
    {		
    	$entry->view_count++;
    	$entry->save();	
    	return view('entries.viewcount');
	}
	
}
