<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Faq;

class FaqsController extends Controller
{
    public function index()
    {
		$faqs = Faq::select()
			->where('user_id', '=', Auth::id())
			->orderByRaw('faqs.id ASC')
			->get();
		
    	return view('faqs.index', ['faqs' => $faqs, 'data' => $this->viewData]);
    }
	
    public function add()
    {
    	return view('faqs.add', ['data' => $this->viewData]);
    }

    public function create(Request $request)
    {
    	$faq = new Faq();
    	$faq->title = $request->title;
    	$faq->link = $request->link;
    	$faq->description = $request->description;
    	$faq->user_id = Auth::id();
    	$faq->save();
		
    	return redirect('/faqs'); 
    }

    public function edit(Faq $faq)
    {
    	if (Auth::check() && Auth::user()->id == $faq->user_id)
        {
			return view('faqs.edit', ['faq' => $faq, 'data' => $this->viewData]);			
        }
        else 
		{
             return redirect('/faqs');
		}            	
    }
	
    public function update(Request $request, Faq $faq)
    {	
    	if (Auth::check() && Auth::user()->id == $faq->user_id)
        {
			$faq->title = $request->title;
			$faq->link = $request->link;
			$faq->description = $request->description;
			$faq->save();
			
			return redirect('/faqs/'); 
		}
		else
		{
			return redirect('/');
		}
    }

    public function confirmdelete(Faq $faq)
    {	
    	if (Auth::check() && Auth::user()->id == $faq->user_id)
        {			
			return view('faqs.confirmdelete', ['faq' => $faq, 'data' => $this->viewData]);				
        }           
        else 
		{
             return redirect('/faqs');
		}            	
    }
	
    public function delete(Faq $faq)
    {	
    	if (Auth::check() && Auth::user()->id == $faq->user_id)
        {			
			$faq->delete();
		}
		
		return redirect('/faqs');
    }	

    public function view(Faq $faq)
    {	
    	if (Auth::check() && Auth::user()->id == $faq->user_id)
        {			
			$faq->description = $this->formatLinks(nl2br($faq->description));
			
			return view('faqs.view', ['faq' => $faq, 'data' => $this->viewData]);				
        }           
        else 
		{
             return redirect('/faqs');
		}            	
    }	
	
}
