@extends('layouts.master')
@section('main-content')
    <div class="col-md-12  mb-4">
        <div class="card text-left">

            <div class="card-body detail-page">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="card-title mb-2">Leader Details</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown">
                            <div class="user align-self-end text-right">
                                <a href="{{route('leaders')}}" class="btn btn-primary btn-rounded">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table office-table-view">
                    <ul class="list-group">

                        <div class="office-detail-row">
                            <li class="list-group-item width-50"><strong>FirstName</strong></li>
                            <li class="list-group-item width-50">{{$item['firstname']}}</li>
                        </div>

                        <div class="office-detail-row">
                            <li class="list-group-item width-50"><strong>LastName</strong></li>
                            <li class="list-group-item width-50">{{$item['lastname']}}</li>
                        </div>
                        <div class="office-detail-row">
                            <li class="list-group-item width-50"><strong>E-Mail</strong></li>
                            <li class="list-group-item width-50">{{$item['email']}}</li>
                        </div>
                        <div class="office-detail-row">
                            <li class="list-group-item width-50"><strong>Mobile</strong></li>
                            <li class="list-group-item width-50">{{$item['mobile']}}</li>
                        </div>
                        <div class="office-detail-row">
                            <li class="list-group-item width-50"><strong>Is Verified</strong></li>
                            <li class="list-group-item width-50">
                                @if($item['is_verified'])
                                    <i class="nav-icon i-Checked-User font-weight-bold"></i>
                                @endif
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- end of col -->
@endsection
