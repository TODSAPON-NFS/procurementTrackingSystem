<?php

class TaskController extends Controller {

	public function newTask()
	{
		$user_id = Auth::user()->id;
		$user_designations = UserHasDesignation::whereUsersId($user_id)->get();

		return View::make('tasks.new_tasks')
				->with('user_designations',$user_designations);
		//return $user_designations;
	}

	public function active()
	{


		$user_id = Auth::user()->id;
		$user_designations = UserHasDesignation::whereUsersId($user_id)->get();

		return View::make('tasks.active_tasks')
				->with('user_designations',$user_designations);
	}

	public function overdue()
	{
		$user_id = Auth::user()->id;
		$user_designations = UserHasDesignation::whereUsersId($user_id)->get();

		return View::make('tasks.overdue_tasks')
				->with('user_designations',$user_designations);
	}

	public function viewTask()
	{
		return View::make('tasks.task');
	}

	public function assignTask()
	{
		$id = Input::get('hide_taskid');
		$user_id = Auth::user()->id;
		$taskDetails = TaskDetails::find($id);
		$taskDetails->assignee_id = $user_id;
		$taskDetails->status = "Active";
		
		$task_row = Task::find($taskDetails->task_id);
		$addToDateReceived = $task_row->maxDuration;

		// Get date today and the due date;
		$dateReceived = date('Y-m-d H:i:s');
		$dueDate = date('Y-m-d H:i:s', strtotime("$addToDateReceived days" ));

		$taskDetails->dateReceived = $dateReceived;
		$taskDetails->dueDate = $dueDate;

		$taskDetails->save();

		return Redirect::to("task/$id");
	}
}