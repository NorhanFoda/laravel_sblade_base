@extends('layouts.master')
@section('title', __('messages.sidebar.users'))

@section('content')
    <x-page-header previousPage="Pages" currentPage="User" previousPageLink="#" />

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body">
                    display data here
                </div>
            </div>
        </div>
    </div>
@endsection
