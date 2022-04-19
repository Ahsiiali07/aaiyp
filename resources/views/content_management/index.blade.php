@extends('layouts.master')
@section('page-css')
    <link rel="stylesheet" href="{{asset('public/assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row p-3 items-align-center">
                        <div class="col-md-6">
                            <h4 class="card-title">Content Managment</h4>
                        </div>
                    </div>

                    <section>
                        <div id="itemlist">
                            @include('content_management._list')
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom-js')
    <script>
        {{-- Date Created Filter Datepicker --}}
        $(".filter-create-date").datepicker({
            showButtonPanel: true,
            format: 'd-mm-yyyy',
            autoHide: true,
        });
    </script>
@endsection
@section('page-js')
    <script src="{{asset('public/assets/js/vendor/sweetalert2.min.js')}}"></script>
@endsection
