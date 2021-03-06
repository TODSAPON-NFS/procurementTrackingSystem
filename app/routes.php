
<?php


Route::post('setPage', ['uses' => 'SearchController@setPage', 'as'=>'/setPage']);

Route::get('/', function()
{
	return Redirect::to('login');
});

Route::get( 'janisawesome', 'BaseController@janisawesome');

//---------- Complete Table View route
Route::post( 'purchaseRequest/completeTable/active', 'SearchController@completeActiveSearch');
Route::post( 'purchaseRequest/completeTable/closed', 'SearchController@completeClosedSearch');
Route::post( 'purchaseRequest/completeTable/cancelled', 'SearchController@completeCancelledSearch');
Route::post( 'purchaseRequest/completeTable/overdue', 'SearchController@completeOverdueSearch');

Route::get( 'purchaseRequest/completeTable/active', 'SearchController@completeTableActive');
Route::get( 'purchaseRequest/completeTable/closed', 'SearchController@completeTableClosed');
Route::get( 'purchaseRequest/completeTable/cancelled', 'SearchController@completeTableCancelled');
Route::get( 'purchaseRequest/completeTable/overdue', 'SearchController@completeTableOverdue');
Route::get( 'cancelcreate', 'PurchaseRequestController@cancelcreate');

//---------- Login Routes
Route::get( 'login', 'UserController@login');
Route::get( 'logout', 'UserController@logout');
Route::post('login', 'UserController@do_login');


//---------- User CRUD Routes
Route::get('user/view', 'UserController@viewUser');
Route::post('user/edit/{id}',[ 'uses' => 'UserController@edit']);
Route::get('user/edit/{id}',[ 'uses' => 'UserController@edit_view']);
Route::post('user/editprof/{id}',[ 'uses' => 'UserController@editprof']);
Route::get('user/editprof/{id}',[ 'uses' => 'UserController@editprof_view']);
Route::get( 'user/create', 'UserController@create');
Route::post('user', 'UserController@store');
Route::post( 'user/delete', 'UserController@disable');
Route::post( 'user/activate', 'UserController@activate');

//---------- Dashboard Routes
Route::get('/dashboard', 'UserController@dashboard');


//---------- Office routes
Route::resource('offices', 'OfficeController');
Route::get('offices', 'OfficeController@index');
Route::post('offices/delete/{id}',['as' => 'offices.delete', 'uses' => 'OfficeController@deleteOffice']);
Route::post('offices/{id}/edit',['as' => 'offices.update', 'uses' => 'OfficeController@update']);

//---------- Purchase Request Routes
Route::get('purchaseRequests','PurchaseRequestController@viewAll');
Route::get('purchaseRequests','PurchaseRequestController@viewAll');
Route::get('purchaseRequest/view','PurchaseRequestController@view');
Route::post('purchaseRequest/view','SearchController@search');
Route::get('purchaseRequest/create', 'PurchaseRequestController@create');
Route::get('purchaseRequest/edit','PurchaseRequestController@edit');
Route::get( 'purchaseRequest/vieweach/{id}', 'PurchaseRequestController@vieweach');
Route::get( 'purchaseRequest/closed', 'PurchaseRequestController@viewClosed');
Route::post( 'purchaseRequest/closed', 'SearchController@searchClosed');
Route::get( 'purchaseRequest/overdue', 'PurchaseRequestController@viewOverdue');
Route::post( 'purchaseRequest/overdue', 'SearchController@searchOverdue');
Route::get( 'purchaseRequest/cancelled', 'PurchaseRequestController@viewCancelled');
Route::post( 'purchaseRequest/cancelled', 'SearchController@searchCancelled');
Route::get('/summary', 'PurchaseRequestController@viewSummary');
Route::get('/summary/store', 'PurchaseRequestController@getDateRange');
Route::post('purchaseRequest/edit/{id}',[ 'as' => 'purchaseRequest_editsubmit', 'uses' => 'PurchaseRequestController@edit_submit']);
Route::post('purchaseRequest/create', ['as' => 'purchaseRequest_submit', 'uses' => 'PurchaseRequestController@create_submit']);
Route::post('purchaseRequest/changeForm/{id}', function($id)
{

		$data = array(
		"html" => 
			"<div id='pr_form'>
				<form action='submitForm/$id' id='form' method='post'>
					<input type='hidden' id='hide_reason' name='hide_reason'>
				</form>
			</div>"
		);

	return Response::json($data);
});

Route::post('purchaseRequest/submitForm/{id}', ['as' => 'submitForm', 'uses' => 'PurchaseRequestController@changeForm']);

//Checklist Rowtype Routes
Route::get('purchaseRequest/edit/taskedit/{id}',[ 'uses' => 'PurchaseRequestController@taskedit']);
Route::get('purchaseRequest/edit/taskcanceledit/{id}',[ 'uses' => 'PurchaseRequestController@taskcanceledit']);
Route::post('checklistedit', ['uses' => 'PurchaseRequestController@checklistedit', 'as'=>'checklistedit']);
Route::post('certification', ['uses' => 'PurchaseRequestController@certification']);
Route::post('posting', ['uses' => 'PurchaseRequestController@posting']);
Route::post('supplier', ['uses' => 'PurchaseRequestController@supplier']);
Route::post('cheque', ['uses' => 'PurchaseRequestController@cheque']);
Route::post('published', ['uses' => 'PurchaseRequestController@published']);
Route::post('documents', ['uses' => 'PurchaseRequestController@documents']);
Route::post('evaluations', ['uses' => 'PurchaseRequestController@evaluations']);
Route::post('conference', ['uses' => 'PurchaseRequestController@conference']);
Route::post('contractmeeting', ['uses' => 'PurchaseRequestController@contractmeeting']);
Route::post('rfq', ['uses' => 'PurchaseRequestController@rfq']);
Route::post('dateby', ['uses' => 'PurchaseRequestController@dateby']);
Route::post('datebyremark', ['uses' => 'PurchaseRequestController@datebyremark']);
Route::post('dateonly', ['uses' => 'PurchaseRequestController@dateonly']);
Route::post('philgeps', ['uses' => 'PurchaseRequestController@philgeps']);
//End Checklist Rowtype Routes


Route::post('insertaddon', ['uses' => 'PurchaseRequestController@insertaddon']);
Route::post('editaddon', ['uses' => 'PurchaseRequestController@editaddon']);
Route::get( 'purchaseRequest/edit/{id}', ['uses'=>'PurchaseRequestController@editpagecall']);


//---------- Designation Routes
Route::resource('designation', 'DesignationController');
Route::get('designation', 'DesignationController@index');
Route::post('designation/delete/{id}',['as' => 'designation.delete', 'uses' => 'DesignationController@deleteDesignation']);
Route::post('designation/{id}/edit',['as' => 'desingation.update', 'uses' => 'DesignationController@update']);
Route::get('designation/{id}/members', ['as'=>'designation_members', 'uses' => 'DesignationController@members']);
Route::post('designation/assign',['as'=>'designation.assign', 'uses' => 'DesignationController@assign']);
Route::post('designation/{id}/members', ['as'=>'designation_members_save', 'uses' => 'DesignationController@save_members']);


//---------- Workflow Routes
Route::get('workflow', function(){
	return View::make('workflows.workflowdash');
});


//---------- Roles Create Routes (Disabled)
Route::get('task/new', 'TaskController@newTask');
Route::post('deladdtask', 'TaskController@deladdtask');
Route::post('addtask', [ 'uses' => 'TaskController@addtask']);
Route::post('task/new', ['as' => 'accept_task', 'uses' => 'TaskController@assignTask']);
Route::post('remarks', 'TaskController@remarks');
Route::post('done', 'TaskController@done');
Route::post('taskimage', ['uses'=>'TaskController@taskimage', 'as'=>'taskimage']);	
Route::get('task/active', 'TaskController@active');
Route::get('task/overdue', 'TaskController@overdue');
Route::get('task/{id}', [ 'uses' => 'TaskController@taskpagecall']);


//---------- Image Module Components
Route::post('newcreate', ['uses' => 'PurchaseRequestController@create_submit', 'as'=>'/newcreate']);

Route::post('autoupload', ['uses' => 'PurchaseRequestController@autoupload', 'as'=>'/autoupload']);
Route::post('autouploadsaved', ['uses' => 'PurchaseRequestController@autouploadsaved', 'as'=>'/autouploadsaved']);

Route::post('newedit', ['uses' => 'PurchaseRequestController@edit_submit', 'as'=>'/newedit']);
Route::post('addimage', ['uses' => 'PurchaseRequestController@addimage']);
Route::post('delimage', ['uses'=> 'PurchaseRequestController@delimage']);


//---------- AJAX Routes

Route::post('workflow/submit/{id}', 'AjaxController@workflowSubmit');

Route::post('workflow/replace/{id}', function($id)
{
	$desc = Task::find($id);
	$data = array(
		"html" => "<div id='description_body'>  $desc->description </h6> </p></div>"
	);
	return Response::json($data);
}); 

Route::post('summary/changeDate', 'AjaxController@SummarySubmit');

Route::get('back', function()
{
	$destination = Session::get('backTo');
	
	if(!Session::get('backTo'))
		return redirect::to('dashboard');
	else
		return redirect::to($destination);
});
