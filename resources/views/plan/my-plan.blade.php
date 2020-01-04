@extends('layout')

@section('title', 'My Plan')

@inject('carbon', 'Carbon\Carbon')

@section('content')

    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">My plan</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Plan heading</div>
                        <div class="panel-body">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet animi architecto assumenda
                                aut consequatur debitis dicta dolor, ea error et fuga laudantium magnam omnis optio quibusdam
                                sapiente sunt tenetur ut?
                            </p>
                        </div>

                        <!-- Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Plan name</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Auto renew</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="text-uppercase">{{ $plan->plan_name }}</span> </td>
                                    <td>{{ $plan->created_at->toDayDateTimeString() }}</td>
                                    <td>{{ $plan->finished_at->toDayDateTimeString() }}</td>
                                    <td>NZ$ 9.99</td>
                                    <td>
                                        @if( $plan->finished_at->gt( $carbon->now() ) )
                                            <span class="label label-success">Active</span>
                                        @else
                                            <span class="label label-danger">Ended</span>
                                        @endif
                                    </td>
									<td>
                                        @if( $plan->active )
                                            <span class="label label-success">On</span>
                                        @else
                                            <span class="label label-danger">Off</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
						<a href="{{ route('site.plan.active') }}" class="btn btn-primary waves-effect waves-light">
						@if( $plan->active )
							Cancel subscription
						@else
							Auto renew subscription
						@endif
						</a>
                        <a href="{{ route('site.plan.buy') }}" class="btn btn-primary waves-effect waves-light">Extend existing plan</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>

@endsection