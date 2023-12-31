@extends('owner.template')
@section('main')
<div class="margin-top-85">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			
			
			<!-- Custom css -->
			{{-- <link rel="stylesheet" href="{{URL::to('/')}}/public/backend/dist/css/custom.css"> --}}

			<!-- AdminLTE Skins. Choose a skin from the css/skins
				folder instead of downloading all of them to reduce the load. -->
			
		
		
	<div class="row m-0">
		{{-- sidebar start--}}
		@include('owner.common.sidebar')
		{{--sidebar end--}}
		<div class="col-lg-10 p-0">
			<div class="container-fluid min-height">
				<div class="row">
					<!-- ./col -->
					<!-- ./col -->
					
					<div class="col-lg-4 col-xs-6">
					  <!-- small box -->
					  <div class="small-box bg-aqua">
						<div class="inner">
						  <h3>{{ $total_reservations_count ?? 0}}</h3>
			
						  <p>Total Reservations</p>
						</div>
						<div class="icon">
						  <i class="fa fa-plane"></i>
						</div>
						<a href="{{ url('owner/my-bookings') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>
					</div>
					<!-- ./col -->

					<!-- ./col -->
					
					<div class="col-lg-4 col-xs-6">
					  <!-- small box -->
					  <div class="small-box bg-red">
						<div class="inner">
						  <h3>{{ $today_reservations_count ?? 0}}</h3>
			
						  <p>Today Reservations</p>
						</div>
						<div class="icon">
						  <i class="fa fa-plane"></i>
						</div>
						<a href="{{ url('owner/my-bookings') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					  </div>
					</div>
					<!-- ./col -->
				  </div>
				  <!-- /.row -->
				  <!-- /.content -->
				 
			
				  <!-- /.content -->
				  <div class="row">
					<div class="col-md-12">
					  <!-- LINE CHART -->
					  <div class="box box-info">
						<div class="box-header with-border">
						  <h3 class="box-title">Latest Bookings</h3>
						</div>
						<div class="box-body">
						<div class="table-responsive">
						  <table class="table table-bordered">
							  <thead>
								<tr>
								  <th>Host Name</th>
								  <th>Guest Name</th>
								  <th>Property Name</th>
								  <th>Total Amount</th>
								  <th>Date</th>
								  <th width="5%">Status</th>
								</tr>
							  </thead>
							  <tbody>
							  @if(!empty($bookingList))
								@foreach($bookingList  as $booking)
								  <tr>
									<td><a href="{{url('owner/bookings/detail/'.$booking->id)}}" >{{$booking->host_name}}</a></td>
									<td><a href="{{ url('owner/edit-customer/'.$booking->user_id) }}">{{$booking->guest_name}}</a></td>
									<td><a href="{{url('owner/listing/'.$booking->property_id).'/basics'}}" >{{$booking->property_name}}</a></td>
									<td>{!! moneyFormat($booking->symbol, $booking->total_amount) !!}</td>
									<td>{{dateFormat($booking->created_at)}}</td>
									<td>{{$booking->status}}</td>
								  </tr>
								  @endforeach
								@endif
							  </tbody>
							</table>
						</div>
						</div>
						<!-- /.box-body -->
					  </div>
					  <!-- /.box -->
					</div>
				  </div>
			</div>
		</div>
	</div>
</div>

@endsection