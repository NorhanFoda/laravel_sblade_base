@extends('layouts.master')

@section('content')
<!-- Page Heading -->
<x-page-header title="Users" >
    <x-slot name="headerButtons">
        <x-header-button href="#" label="generate report" icon="fa-download fa-sm text-white-50"/>
    </x-slot>
</x-page-header>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <x-filter/>           

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @include('pages.users.partials.rows')
                </tbody>
            </table>

            <x-pagination :models="$models" />
            
        </div>
    </div>
</div>
@endsection

@push('css')
    <link href="{{asset('UI/assets/v1/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('UI/assets/v1/css/custom/pagination.css')}}" rel="stylesheet">
@endpush

@push('js')
    <!-- Page level plugins -->
    <script src="{{asset('UI/assets/v1/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('UI/assets/v1/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('UI/assets/v1/js/demo/datatables-demo.js')}}"></script>
    <script src="{{asset('UI/assets/v1/js/custom/datatable.js')}}"></script>
    <script src="{{asset('UI/assets/v1/js/custom/filters.js')}}"></script>
    
@endpush