<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Auth;
use App\Task;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $viewData = [];
	
	public function __construct ()
	{
		$taskCount = Task::select()
			//->where('user_id', '=', Auth::id())
			->count();

		$this->viewData['taskCount'] = $taskCount;
		//dd($this->taskCount);
	}
	
	protected function formatLinks($text)
	{
		$lines = explode("\r\n", $text);
		//dd($text);
		$text = "";
		
		foreach($lines as $line)
		{
			preg_match('/\[(.*?)\]/', $line, $title);		// replace the chars between []
			preg_match('/\((.*?)\)/', $line, $link);	// replace the chars between ()
			
			if (sizeof($title) > 0) // if its a link
			{
				$text .= '<a href=' . $link[1] . ' target="_blank">' . $title[1] . '</a><br/>';
			}
			else if (mb_strlen($line) === 0) // blank line
			{
				$text .= $line; // . '\r\n';
			}
			else // regular line with text
			{
				$text .= $line; // . '\r\n';
			}
		}
		
		return $text;
	}	
	
}
