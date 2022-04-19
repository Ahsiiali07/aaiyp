@extends('layouts.master')
@section('main-content')
    <div class="col-md-12  mb-4">
        <div class="card text-left">

            <div class="card-body detail-page">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="card-title mb-2">Feed Details</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown">
                            <div class="user align-self-end text-right">
                                <a href="{{route('feeds')}}" class="btn btn-primary btn-rounded">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <ul>
                    <div class="office-detail-row">
                        <li class="list-group-item width-50"><strong>Title</strong></li>
                        <li class="list-group-item width-50">{{$item->title}}</li>
                    </div>
                    <div class="office-detail-row">
                        <li class="list-group-item width-50"><strong>Description</strong></li>
                        <li class="list-group-item width-50">{{$item->description}}</li>

                    </div>

                    <div class="office-detail-row">
                        <li class="list-group-item width-50"><strong>Created Date and Time</strong></li>
                        <li class="list-group-item width-50">{{ $item['created_at'] }}</li>
                    </div>


                </ul>
            </div>
        </div>
    </div>
    <!-- end of col -->
@endsection
