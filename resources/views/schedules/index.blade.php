
@extends($layout)
@section('scripts')
{!! Html::script('/assets/js/schedules_index.js') !!}
@stop
@section('content')
	<div class="jumbotron">
		<h1>Schedules</h1>
		<ol class="breadcrumb">
			<li class="active">Schedules Overview</li>
			<li><a href="{!! route('schedules_add') !!}">Set an Schedule</a></li>
		</ol>
	</div>
	<div class="table-responsive">
	<table id="schedule_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Description</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="schedule_table_body">
			@foreach($schedules as $schedule)
			<tr>
				<td>{!! $schedule->id !!}</td>
				<td>{!! $schedule->title !!}</td>
				<td>{!! $schedule->description !!}</td>
				<td>{!! $schedule->status_html !!}</td>
				<td><a href="{!! action('SchedulesController@getEdit',$schedule->id) !!}">Edit</a>/
					{!! Form::open(array('action' => 'SchedulesController@postDelete', 'class'=>'remove-form','id'=>'form-'.$schedule->id,'role'=>"form",'files'=> true)) !!}
					{!! Form::hidden('schedule_id', $schedule->id) !!}
					<a class="remove"  data-toggle="modal" data-target="#myModal" schedule-id="{!!$schedule->id!!}" count="{!!$schedule->item_count!!}">Remove</a></td>
					{!! Form::close() !!}</td>
					
				</tr>

				@endforeach
			</tbody>
		</table>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="z-index:99999">
				<div class="modal-content">
					<div class="modal-header alert alert-warning">
						Warning!
					</div>
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-danger remove-btn">Remove</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
@stop