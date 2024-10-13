@extends('dashboard.layouts.master')
@section('content')
    <x-page-header previousPage="Pages" currentPage="New Role" previousPageLink="#" />

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body">
                    <form>
                        @include('dashboard.roles.partials._form')
                    </form>
                </div>
                <div class="card-footer">
                    <x-form.submit :disabled="request()->routeIs('roles.show')"/>
                </div>
            </div>
        </div>
    </div>
@endsection
