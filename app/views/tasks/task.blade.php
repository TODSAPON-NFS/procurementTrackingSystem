@extends('layouts.dashboard')

@section('header')
	{{ HTML::style('date_picker/bootstrap-datetimepicker.min.css')}}
    {{ HTML::script('date_picker/bootstrap-datetimepicker.js') }}
    {{ HTML::script('date_picker/bootstrap-datetimepicker.fr.js') }}
    {{ HTML::style('css/datepicker.css')}}
    {{ HTML::script('js/bootstrap-datepicker.js') }}

	{{ HTML::script('js/bootstrap.file-input.js') }} 
	<script type="text/javascript">
		function codeAddress() 
		{
			if(document.layers) document.layers['remarkd'].visibility="show";
			if(document.getElementById) document.getElementById("remarkd").style.visibility="visible";
			if(document.all) document.all.remarkd.style.visibility="visible";

			if(document.layers) document.layers['formr'].visibility="hide";
			if(document.getElementById) document.getElementById("formr").style.visibility="hidden";
			if(document.all) document.all.formr.style.visibility="hidden";
		}
		window.onload = codeAddress;
	</script>

	<style type="text/css">
		td{
		    padding:5px 10px;
		    vertical-align:top;
		    word-break:break-word;
		}
	</style>
@stop

@section('content')

	<!--CODE REVIEW:
        - fix code indention
    -->

	<h2 class="pull-left">Task Details</h2>

	<div class="pull-right options">
		<a href="{{ URL::previous() }}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
	</div>

	<?php
		$taskdetails_id=Session::get('taskdetails_id');
		Session::forget('taskdetails_id');
		$taskd =TaskDetails::find($taskdetails_id);
		$task= Task::find($taskd->task_id);
		$doc= Document::find($taskd->doc_id);
		$purchase = Purchase::find($doc->pr_id);
	?>

	<hr class="clear" />

	<div class="panel panel-default">
		<div class="panel-body task-body">

			<table border=0 width="100%">
				<tr>
					<td>
						<h3 class="pull-left">{{$task->taskName}}</h3>
						<?php
							if($taskd->status=="New")
							{
						?>	
								{{ Form::open(['route'=>'accept_task']) }}
									{{ Form::hidden('hide_taskid',$taskdetails_id) }}
									{{Form::submit('Accept Task', ['class' => 'btn btn-sm btn-primary accept-button', 'style' => 'margin-bottom: 10px'])}}     
								{{ Form::close() }}
						<?php
							}
						?>
						<hr class="clear" />
					</td>
				</tr>

				<tr> 
					<td>
						<span style="font-weight: bold">Description: </span><br/>
						<p>{{$task->description}}</p>
					</td>
				<tr>

				<tr> 
					<td>
						<span style="font-weight: bold">Purchase Request ID-Name: </span><br/>
						<p><a href="{{ URL::to('purchaseRequest/vieweach/'.$purchase->id) }}" ><?php echo $purchase->id."-".$purchase->projectPurpose; ?> </a></p>
				
					</td>
				<tr>

				<?php
					if ($taskd->status!="New")
					{
						$date_today =date('Y-m-d H:i:s');
				?>
						@if( $date_today > $taskd->dueDate )
							<tr>
								<td>
									<span style="font-weight: bold">Due Date: </span><br/>
									<p><font color="red">{{ $taskd->dueDate; }}</font></p>
								</td>
							</tr>
						@else
							<tr>
								<td>
									<span style="font-weight: bold">Due Date: </span><br/>
									<p>{{ $taskd->dueDate; }}</p>
								</td>
							</tr>
						@endif
				<?php } else { ?>

					<tr>
						<td>
							<span style="font-weight: bold">Max Duration: </span><br/>
							{{ $task->maxDuration }}
						</td>
					</tr>

				<?php 
					}
				?>

				@if($task->taskType=='certification')
					<tr> 
						<td>
							<span style="font-weight: bold">PPMP Certification: </span><br/>
							<p>
								<input type="radio" name="radio" value="yes" />&nbsp;&nbsp;Yes &nbsp;&nbsp;
	                            <input type="radio" name="radio" value="no" />&nbsp;&nbsp;No<br />
	                        </p>
					
						</td>
					</tr>
				@elseif($task->taskType=='posting')
					<tr> 
						<td>
							<span style="font-weight: bold">Reference Number: </span><br/>
							<p>
								<input type="text" name="referenceno"  class="form-control" maxlength="100" width="80%" maxlength="100" style="margin-top: 10px;" placeholder="Enter Reference Number">
	                        </p>
					
						</td>
					</tr>
				@elseif($task->taskType=='supplier')
					<tr> 
						<td>
							<span style="font-weight: bold">Supplier: </span><br/>
							<p>
								<input type="text" name="supplier"  class="form-control" maxlength="100" width="80%" placeholder="Enter supplier" style="margin-top: 10px;">
	                        </p>
						</td>
						<td>
							<span style="font-weight: bold">Amount: </span><br/>
							<p>
								<input type="decimal" name="amount"  class="form-control" maxlength="12" width="80%" placeholder="Enter amount" style="margin-top: 10px;">
	                        </p>
						</td>
					</tr>
				@elseif($task->taskType=='cheque')
					<tr> 
						<td>
							<span style="font-weight: bold">Cheque Amount: </span><br/>
							<p>
								<input type="decimal" name="amt"  class="form-control" maxlength="12" width="80%" placeholder="Enter cheque amount" style="margin-top: 10px;">
	                        </p>
							<span style="font-weight: bold">Cheque Number: </span><br/>
							<p>
								<input type="decimal" name="amount"  class="form-control" maxlength="12" width="80%" placeholder="Enter amount" style="margin-top: 10px;">
	                        </p>
							<span style="font-weight: bold">Cheque Date: </span><br/>
							<p>
								<?php 
                                $today = date("m/d/y");
                                ?>
                                <input class="datepicker" size="16" type="text" name="date" class="form-control" value="{{$today}}" width="100%" placeholder="Enter cheque date">
                                <span class="add-on"><i class="icon-th"></i></span>
	                        </p>
						</td>
					</tr>	
				@elseif($task->taskType=='conference')
					<tr> 
						<td>
							<span style="font-weight: bold">Conference Date: </span><br/>
							<p>
								<?php 
	                            $today = date("m/d/y");
	                            ?>
	                            <input class="datepicker" size="16" type="text" name="date" class="form-control" value="{{$today}}" width="100%"  style="margin-top: 10px;">
	                            <span class="add-on"><i class="icon-th"></i></span>
	                        </p>
						</td>
					</tr>	
				@elseif($task->taskType=='published')
					<tr> 
						<td width="50%">
							<span style="font-weight: bold">Date Published: </span><br/>
							<p>
								<?php 
	                            $today = date("m/d/y");
	                            ?>
	                            <input class="datepicker" size="16" type="text" name="datepublished" class="form-control" value="{{$today}}" width="100%"  style="margin-top: 10px;">
	                            <span class="add-on"><i class="icon-th"></i></span>
	                        </p>
							<span style="font-weight: bold">End Date: </span><br/>
							<p>
								<?php 
	                            $today = date("m/d/y");
	                            ?>
	                            <input class="datepicker" size="16" type="text" name="datepublished" class="form-control" value="{{$today}}" width="100%"  style="margin-top: 10px;">
	                            <span class="add-on"><i class="icon-th"></i></span>
	                        </p>
						</td>
					</tr>
					<tr>
						<td>
							<span style="font-weight: bold">Posted By: </span><br/>
							<p>
								<input type="text" name="by"  placeholder="Enter name" class="form-control" maxlength="100" width="80%"  style="margin-top: 10px;">
	                        </p>
						</td>
					</tr>	
				@elseif($task->taskType=='documents')
					<tr> 
						<td width="50%">
							<span style="font-weight: bold">Eligibility Documents: </span><br/>
							<p>
								<?php 
	                            $today = date("m/d/y");
                                ?>
                                <input class="datepicker" size="16" type="text" name="date" class="form-control" value="{{$today}}" width="100%" style="margin-top: 10px;">
                                <span class="add-on"><i class="icon-th"></i></span>
	                        </p>
							<span style="font-weight: bold">Date of Bidding: </span><br/>
							<p>
								<input class="datepicker" size="16" type="text" name="biddingdate" class="form-control" value="{{$today}}" width="100%" style="margin-top: 10px;">
								<span class="add-on"><i class="icon-th"></i></span>
	                        </p>
						</td>
					</tr>
					<tr>
						<td>
							<span style="font-weight: bold">Checked By: </span><br/>
							<p>
								<input type="text" name="by"  class="form-control" maxlength="100" width="80%" placeholder="Enter name" style="margin-top: 10px;">
	                        </p>
						</td>
					</tr>	
				@elseif($task->taskType=='evaluation')
					<tr> 
						<td width="50%">
							<span style="font-weight: bold">Date: </span><br/>
							<p>
								<?php 
	                            $today = date("m/d/y");
                                ?>
                                <input class="datepicker" size="16" type="text" name="date" class="form-control" value="{{$today}}" width="100%" style="margin-top: 10px;">
                                <span class="add-on"><i class="icon-th"></i></span>
	                        </p>
							<span style="font-weight: bold">No. of Days Accomplished: </span><br/>
							<p>
								<input type="number" name="noofdays"  class="form-control" maxlength="100" width="80%" placeholder="Enter no. of days" style="margin-top: 10px;">
	                        </p>
						</td>
					</tr>	
				@elseif($task->taskType=='contract' || $task->taskType=='meeting')
					<tr> 
						<td width="50%">
							<span style="font-weight: bold">
								@if($task->taskType=='contract') 
									Notice of Award Date: 
								@else 
									Notice to Proceed
								@endif
							</span><br/>
							<p>
								<?php 
                                $today = date("m/d/y");
                                ?>
                                <input class="datepicker" size="16" type="text" name="date" class="form-control" value="{{$today}}" width="100%" style="margin-top: 10px;">
                                <span class="add-on"><i class="icon-th"></i></span>
	                        </p>
							<span style="font-weight: bold">No. of Days Accomplished: </span><br/>
							<p>
								<input type="number" name="noofdays"  class="form-control" maxlength="100" width="80%" placeholder="Enter no. of days accomplished" style="margin-top: 10px;">
	                        </p>
	                        <span style="font-weight: bold">
	                        	@if($task->taskType=='contract') 
	                        		Contract Agreement: 
	                        	@else
	                        		Minutes of Meeting:
	                        	@endif
	                        </span><br/>
							<p>
								<input type="text" name="contractmeeting"  class="form-control" maxlength="100" width="80%" placeholder="@if($task->taskType=='contract') Enter contract agreement @else Enter minutes of meeting @endif" style="margin-top: 10px;">
	                        </p>
						</td>
					</tr>	
				@endif

				
				
					<tr>
						<td>
							@if($task->taskType!='certification' && $task->taskType!='posting' && $task->taskType!='supplier' && $task->taskType!='cheque' && $task->taskType!='conference'
							 && $task->taskType!='published' && $task->taskType!='documents' && $task->taskType!='evaluation' && $task->taskType!='contract' && $task->taskType!='meeting')
								@if($taskd->status!="New")
								<p style="font-weight: bold">Remarks: </p>
								<?php 

									if (Session::get('errorremark'))
										echo  "<div class='alert alert-danger'>".Session::get('errorremark')."</div>";
									if (Session::get('successremark'))
										echo  "<div class='alert alert-success'>".Session::get('successremark')."</div>";
									Session::forget('errorremark');
									Session::forget('successremark');
									?>

									<div id="remarkd" onclick="show()">
										<p>
											<?php
												echo $taskd->remarks;
												if ($taskd->remarks==NULL)
												{
												?>
													No remark.
												<?php
												}
											?>
										</p>
									</div>
									<div id ="formr">
										{{ Form::open(['url'=>'remarks'], 'POST') }}
										{{ Form::textarea('remarks','', array('class'=>'form-control', 'rows'=>'3', 'maxlength'=>'255', 'style'=>'resize:vertical')) }}
										<input type ="hidden" name="taskdetails_id" value="{{$taskd->id}}">
										<div class='pull-right'>
											{{ link_to( 'task/active', 'Cancel', array('class'=>'btn btn-sm btn-default remarks-btn') ) }}
											{{ Form::submit('Submit',array('class'=>'btn btn-sm btn-success remarks-btn')) }}
										</div>
										{{ Form::close() }}
									</div>

								@endif
							@endif
								<hr class="clear" />
								<?php 

								if ($taskd->status=="Active"){
									?>
									{{ Form::open(['url'=>'done'], 'POST') }}
									<input type ="hidden" name="taskdetails_id" value="{{$taskd->id}}">
									<input type ="hidden" name="task_id" value="{{$task->id}}">
									<input type ="hidden" name="doc_id" value="{{$doc->id}}">
									<input type ="hidden" name="pr_id" value="{{$purchase->id}}">
									{{ Form::submit('Done',array('class'=>'btn btn-sm btn-success')) }}
									{{ Form::close() }}
									<?php
								}
							?>	

						</td>
					</tr>
					
						
			</table>

			<br/>
			<br/>
			<!--Upload Image-->
			{{ Form::open(array('url' => 'taskimage', 'files' => true), 'POST') }}
			<label class="create-label">Related files:</label>
            <div class="panel panel-default fc-div">
                <div class="panel-body" style="padding: 5px 20px;">
                    <br/>

                    @if(Session::get('imgsuccess'))
                        <div class="alert alert-success"> {{ Session::get('imgsuccess') }}</div> 
                    @endif

                    @if(Session::get('imgerror'))
                        <div class="alert alert-danger"> {{ Session::get('imgerror') }}</div> 
                    @endif

                    <input name="file[]" type="file"  multiple title="Select image to attach" data-filename-placement="inside"/>
                    <input name="doc_id" type="hidden" value="{{ $doc->id }}">
                    
                    <br>
                    <br>
                    
                    {{Session::forget('imgerror');}}
                    {{Session::forget('imgsuccess');}}

               		{{ Form::submit('Save',array('class'=>'btn btn-success')) }}
                </div>
            </div>
            {{Form::close()}}
            <!--End Upload Image-->
			<br/>
		</div>
	</div>
@stop

@section('footer')
	<script type="text/javascript">
		$('input[type=file]').bootstrapFileInput();
		    $('.file-inputs').bootstrapFileInput();
			function isNumberKey(evt)
			{
				var charCode = (evt.which) ? evt.which : event.keyCode
				if(charCode == 44 || charCode == 46)
					return true;

				if (charCode > 31 && (charCode < 48 || charCode > 57))
					return false;

				return true;
			}
		function show(){
			if(document.layers) document.layers['formr'].visibility="show";
			if(document.getElementById) document.getElementById("formr").style.visibility="visible";
			if(document.all) document.all.formr.style.visibility="visible";

			if(document.layers) document.layers['remarkd'].visibility="hide";
			if(document.getElementById) document.getElementById("remarkd").style.visibility="hidden";
			if(document.all) document.all.remarkd.style.visibility="hidden";
		}
	</script>

	<!-- Script for date and time picker -->
    <script type="text/javascript">
	    $('.form_datetime').datetimepicker({
	            //language:  'fr',
	            weekStart: 1,
	            todayBtn:  1,
	            autoclose: 1,
	            todayHighlight: 1,
	            startView: 2,
	            forceParse: 0,
	            showMeridian: 1
	        });
	    $('.form_date').datetimepicker({
	        language:  'fr',
	        weekStart: 1,
	        todayBtn:  1,
	        autoclose: 1,
	        todayHighlight: 1,
	        startView: 2,
	        minView: 2,
	        forceParse: 0
	    });
	    $('.form_time').datetimepicker({
	        language:  'fr',
	        weekStart: 1,
	        todayBtn:  1,
	        autoclose: 1,
	        todayHighlight: 1,
	        startView: 1,
	        minView: 0,
	        maxView: 1,
	        forceParse: 0
	    });

	    function fix_formatDateRec()
	    {
	        document.getElementById('disabled_datetimeDateRec').value = document.getElementById('dtp_input2').value;
	         
	    }

	    function fix_format()
	    {
	        document.getElementById('disabled_datetime').value = document.getElementById('dtp_input1').value;
	    }

		function fix_format2()
		{
		    var counter = 0;
		    while(counter != 100)
		    {
		        counter++;
		        var name = "disabled_datetime2" + counter;
		        var name2 = "dtp_input2" + counter;
		        document.getElementById(name).value =
		        document.getElementById(name2).value;
		    }
		}

		$('.datepicker').datepicker();
    </script>
@stop

