<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Entry;
use DB;

define('BODYSTYLE', '<span style="color:green;">');
define('ENDBODYSTYLE', '</span>');
define('EMPTYBODY', 'Empty Body');
define('BODY', 'Body');
define('INTNOTSET', -1);

class EntryController extends Controller
{
    public function index()
    {
    	//$user = Auth::user(); // original gets current user with all entries
		
		$entries = Entry::select()
			->where('user_id', '=', Auth::id())
			->where('is_template_flag', '<>', 1)
			//->orderByRaw('is_template_flag, entries.view_count DESC, entries.title')
			->orderByRaw('is_template_flag, entries.title')
			->get();
		
    	return view('entries.index', compact('entries'));
    }

    public function templates()
    {
		$entries = Entry::select()
			->where('user_id', '=', Auth::id())
			->where('is_template_flag', '=', 1)
			->orderByRaw('id')
			->get();
		
    	return view('entries.index', compact('entries'));
    }
	
    public function add()
    {
    	if (Auth::check())
        {            
			//todo $categories = Category::lists('title', 'id');
			
			return view('entries.add');
        }           
        else 
		{
             return redirect('/');
        }       
	}

    public function create(Request $request)
    {		
    	if (Auth::check())
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
			
			return redirect('/entries/gendex/' . $entry->id);
        }           
        else 
		{
             return redirect('/');
        }            	
    }

    public function view(Entry $entry)
    {
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {            
			return view('entries.view', compact('entry'));
        }           
        else 
		{
             return redirect('/');
        }            	
    }

    public function gen(Entry $entry)
    {		
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {
			$entry = $this->merge_entry($entry);
					
			return view('entries.gen', $entry);			
        }           
        else 
		{
             return redirect('/');
		}            	
    }

    public function settemplate($id)
    {
		$id = (intval($id) >= 0) ? intval($id) : 0;

		// if id set and it is changing
		if ($id > 0 && Auth::check() && intval(Auth::user()->template_id) != $id)
		{
			// template is changing
			//dd('template change');
			
			Auth::user()->template_id = $id;
			Auth::user()->save();
		}

    	return view('entries.settemplate');
	}
	
    public function gendex($id = INTNOTSET)
    {
		$id = (intval($id) >= 0) ? intval($id) : 0;
		
		if (Auth::check())
        {			
			//
			// get the template or entry to show
			//
			if ($id > 0) // get the specified article
			{
				$entry = Entry::select()
					->where('user_id', '=', Auth::id())
					->where('id', '=' , $id)
					->first();
					
				$data = $this->merge_entry($entry);	
			}
			else // get the default template
			{
				$template_id = intval(Auth::user()->template_id);
				
				if ($template_id === 0) // default template not set, use first template
				{
					$entry = Entry::select()
						->where('user_id', '=', Auth::id())
						->where('is_template_flag', '=', 1)
						->first();
						
				}
				else // get user's default template
				{
					$entry = Entry::select()
						->where('user_id', '=', Auth::id())
						->where('is_template_flag', '=', 1)
						->where('id', '=',  $template_id)
						->first();
				}
					
				$entry->description = str_replace("[[body]]", $this->fixEmpty('', BODY), $entry->description) . '<br/>';
				$entry->description_language1 = str_replace("[[body]]", $this->fixEmpty('', BODY), $entry->description_language1) . '<br/>';
					
				$data = $this->merge_entry($entry);	
			}			
			
			//
			// get entry list
			//
			$entries = Entry::select()
				->where('user_id', '=', Auth::id())
				->where('is_template_flag', '<>', 1)
				->where('view_count', '>', 0)
				//->orderByRaw('is_template_flag, entries.view_count DESC')
				->orderBy('title')
				->limit(25)
				->get();

			//
			// get template list
			//
			$templates = Entry::select('id', 'title')
				->where('user_id', '=', Auth::id())
				->where('is_template_flag', '=', 1)
				->orderBy('title')
				->get();
			
			$data['entries'] = $entries;
			$data['templates'] = $templates;
	
			//dd($data);
								
			return view('entries.gendex', $data);
        }          	
    }
	
    public function edit(Request $request, Entry $entry)
    {
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {
			// flags come from dev mysql as ints and prod mysql as strings
			$entry['is_template'] = (intval($entry->is_template_flag) === 1);

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
			$entry->description = nl2br($this->fixEmpty(trim($entry->description), EMPTYBODY));
			$entry->description_language1 = nl2br($this->fixEmpty(trim($entry->description_language1), EMPTYBODY));
			
			return view('entries.delete', compact('entry'));
        }           
        else 
		{
             return redirect('/');
		}            	
    }
	
    public function delete(Request $request, Entry $entry)
    {	
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {
			//dd($entry);
			
			$entry->delete();
		}
		
		return redirect('/entries/gendex');
    }
	
    public function update(Request $request, Entry $entry)
    {	
    	if (Auth::check() && Auth::user()->id == $entry->user_id)
        {
			//dd($request);
				
			$entry->title 					= $request->title;
			$entry->description 			= $request->description;
			$entry->description_language1 	= $request->description_language1;
			$entry->is_template_flag 		= isset($request->is_template_flag) ? 1 : 0;
			$entry->save();
			
			return redirect('/entries/gendex/' . $entry->id); 
		}
		else
		{
			return redirect('/');
		}
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

		$entries = Entry::select()->whereRaw('1 = 1')
			->where('user_id', '=', Auth::id())
			->where('is_template_flag', '=', 0)
//			->where(function ($query) use ($search) {
//				return $query
//					->where('title', 'like', '%' . $search . '%')
//					->orWhere('description', 'like', '%' . $search . '%')
//					->orWhere('description_language1', 'like', '%' . $search . '%')
//			;})
			->where('title', 'like', '%' . $search . '%')
			->orWhere('description', 'like', '%' . $search . '%')
			->orWhere('description_language1', 'like', '%' . $search . '%')
			->orderBy('title')
			->limit(25)
			->get();

		$entries = compact('entries');

		//dd($entries);
				
    	return view('entries.search', $entries);
	}
	
    public function viewcount(Entry $entry)
    {		
    	$entry->view_count++;
    	$entry->save();	
    	return view('entries.viewcount');
	}

    public function crypt()
    {		
    	return view('entries.crypt');
	}
	
	public function encrypt(Request $request)
	{
		$search = $request->get('search');

		dd($search);
		//flash('Search text')->success();

		return view('entries.crypt', $search);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////
	// Privates
	//////////////////////////////////////////////////////////////////////////////////////////
	
    private function fixEmpty(string $text, string $show)
    {	
		if (mb_strlen($text) === 0)
		{
			$text = BODYSTYLE 
			. '(' . strtoupper(__($show)) . ')'
			. ENDBODYSTYLE;			

		}
		
		return $text;
	}
	
	private function merge($template, $description, $style = false)
	{
		$body = trim($description);
		if (mb_strlen($body) == 0)
		{
			if ($style === true)
			{
				// only show empty in the view version
				$body = '(' . strtoupper(__(EMPTYBODY)) . ')';
			}
			else
			{
				// leave a space for the copy version
				$body = ' ';
			}
		}
		
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
	
	private function merge_entry(Entry $entry)
    {
		if (intval($entry->is_template_flag) === 0)
		{				
			// get the template
			$template = $this->getDefaultTemplate();
				
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
				
				return $data;
			}
			else
			{
			}
		}
		else
		{
		}	
			
		$entry->description = nl2br($entry->description);
		$entry->description_language1 = nl2br($entry->description_language1);
					
		$data = compact('entry');
		$data['description_copy'] = $entry->description;
		$data['description_copy2'] = $entry->description_language1;
		
		return $data;
	}

	private function getDefaultTemplate()
	{
		$template_id = intval(Auth::user()->template_id);
				
		if ($template_id === 0) // default template not set, use first template
		{
			$entry = Entry::select()
				->where('user_id', '=', Auth::id())
				->where('is_template_flag', '=', 1)
				->first();
		}
		else // get user's default template
		{
			$entry = Entry::select()
				->where('user_id', '=', Auth::id())
				->where('is_template_flag', '=', 1)
				->where('id', '=',  $template_id)
				->first();
		}
		
		return $entry;
	}
	
}
