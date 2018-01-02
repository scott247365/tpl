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
    	$user = Auth::user();
		
    	return view('entries.index', compact('user'));
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
    	$entry->uses_template_flag = (isset($request->uses_template_flag)) ? 1 : 0;
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
			if ($entry->uses_template_flag === 1)
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
			
   		$entry->title 					= $request->title;
   		$entry->description 			= $request->description;
   		$entry->description_language1 	= $request->description_language1;
    	$entry->is_template_flag 		= isset($request->is_template_flag) ? 1 : 0;
    	$entry->uses_template_flag 		= isset($request->uses_template_flag) ? 1 : 0;
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
}
