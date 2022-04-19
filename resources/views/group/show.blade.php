@extends('layouts.master')
@section('main-content')
    <div class="col-md-12  mb-4">
        <div class="card text-left">

            <div class="card-body detail-page">
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <h4 class="card-title"> Group Details</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown">
                            <div class="user align-self-end text-right">
                                <a href="{{route('groups')}}" class="btn btn-primary btn-rounded">Back</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="office-detail-row">
                    <li class="list-group-item width-50"><strong>Group Name</strong></li>
                    <li class="list-group-item width-50">{{$item->name}}</li>
                </div>
                <div class="office-detail-row">
                    <li class="list-group-item width-50"><strong>Description</strong></li>
                    <li class="list-group-item width-50">{{$item->description}}</li>
                </div>
                <div class="office-detail-row">
                    <li class="list-group-item width-50"><strong>Category</strong></li>
                    <li class="list-group-item width-50">{{$item->category_id ? $item->category->name: ''}}</li>
                </div>

                <div class="row align-items-center mt-4 mb-4">
                    <div class="col-md-6">
                        <h4 class="card-title">All Users</h4>
                    </div>

                    <div class="col-md-6 text-right">
{{--                        <div class="text-right">--}}
{{--                            <a href="{{route('notes-create', $item->id)}}" class="btn btn-primary btn-rounded">--}}
{{--                                Create Notes--}}
{{--                            </a>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="ajax-listing">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>

                                <th class="text-center">User</th>
                                <th class="text-center">Joined At</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($items->count())
                                @foreach($items as $gitem)
                                    <tr>

                                        <td class="text-center">{{$gitem['user_id'] ? $gitem->users->firstname:''}}</td>
                                        <td class="text-center">{{ $gitem['created_at'] }}</td>
                                        <td class="text-center">
                                            <a href="{{route('groupuser-show', [$item->id, $gitem->id])}}"
                                               class="text-success">
                                                <i class="nav-icon i-Eye1 font-weight-bold"></i>
                                            </a>
{{--                                            <a href="{{route('notes-edit', [$item->id ,$nitem->id])}}"--}}
{{--                                               class="text-success">--}}
{{--                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>--}}
{{--                                            </a>--}}
                                            <form id="delete-form-{{$gitem->id}}" method="post" class="delete-form"
                                                  action="{{route('groupuser-delete', [$item->id, $gitem->id])}}">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="text-danger submit p-0" type="submit">
                                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" align="center">
                                        <strong class="red-text">Record not found</strong>
                                    </td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of col -->
@endsection
@section('page-js')
    <script src="{{asset('public/assets/js/vendor/sweetalert2.min.js')}}"></script>
@endsection
