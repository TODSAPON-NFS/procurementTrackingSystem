@extends('layouts.dashboard')

@section('header')
    <script src="js/foundation-datepicker.js"></script>
    {{ HTML::script('datepicker_range/foundation-datepicker.js')}}
    {{ HTML::style('datepicker_range/foundation-datepicker.css')}}




	
@stop

@section('content')
	<h1 class="page-header">Summary</h1>

	<br/><br/>
    <!--<div class="form-inline" style="width: 80%; margin: 0px 15px;">-->
    <form class="form ajax" action="summary/changeDate" method="post" role="form" class="form-inline">
        <div class="form-group col-md-9">
            <div class="input-daterange input-group" id="datepicker" data-date="{{ date('Y-m-d') }}T" data-date-format="yyyy-mm-dd">
                <input type="text" class="form-control" name="start" value="" id="dpd1" style="text-align: center" readonly placeholder="Click to select date">
                <span class="input-group-addon" style="vertical-align: top;height:20px">to</span>
                <input type="text" class="form-control" name="end" value="" id="dpd2" style="text-align: center" readonly placeholder="Click to select date">
            </div>



        </div>
        {{ Form::submit('Apply', array('class' => 'btn btn-success col-md-3')) }}
    </form>
    <!--</div>-->

    <div style="margin-top: 100px">
        <div id="dateReport">

        </div>

        <div class="col-md-4">
            <div class="well" style="" id="PR">
                <span class="summary-panel-title"><strong>Total Number of PR Received:</strong></span><br/>
                <span class="summary-amount" style="color: #246D27">{{ $prCount }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="well" style="" id="PO">
                <span class="summary-panel-title"><strong>Total Number of PO Received:</strong></span><br/>
                <span class="summary-amount" style="color: #4E3A17">{{ $POCount }}</span>
            </div>
        </div>
        <div class="col-md-4" >
            <div class="well" style="" id="Cheque">
                <span class="summary-panel-title"><strong>Total Number of Cheque Received:</strong></span><br/>
                <span class="summary-amount" style="color: #1B4F69">{{ $chequeCount }}</span>
            </div>
        </div>
    </div>
    

@stop

@section('footer')
    {{ HTML::script('js/bootstrap-ajax.js');}}


    <script>
            $(function () {
                
                // implementation of disabled form fields
                var nowTemp = new Date();
                var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate() + 1, 0, 0, 0, 0);
                
                var checkin = $('#dpd1').fdatepicker(
                {
                    onRender: function (date) 
                    {
                        return date.valueOf() > now.valueOf() ? 'disabled' : '';
                    }
                }).on('changeDate', function (ev) {
                    if (ev.date.valueOf() > checkout.date.valueOf()) {
                        var newDate = new Date(ev.date)
                        newDate.setDate(newDate.getDate() + 1);
                        checkout.update(newDate);
                    }
                    checkin.hide();
                    $('#dpd2')[0].focus();
                }).data('datepicker');
                
                var checkout = $('#dpd2').fdatepicker({
                    onRender: function (date) {
                        // return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
                        if(date.valueOf() < checkin.date.valueOf() || date.valueOf() > now.valueOf())
                        {
                            return 'disabled';
                        }
       

                    }
                }).on('changeDate', function (ev) {
                    checkout.hide();
                }).data('datepicker');
            });
            
        </script>
@stop