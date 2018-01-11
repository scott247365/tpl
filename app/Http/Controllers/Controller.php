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
	
}
