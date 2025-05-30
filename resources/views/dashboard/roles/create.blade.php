@extends('dashboard.layouts.master')
@section('title', __('messages.sidebar.roles_and_permissions'))

@section('content')
    <x-page-header previousPage="Pages" currentPage="New Role" previousPageLink="#" />

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body">
                    <form id="form"
                        action="{{ route('roles.store') }}"
                        data-redirect="{{ route('roles.index') }}">
                        @csrf
                        @include('dashboard.roles.partials._form')
                    </form>
                </div>
                <div class="card-footer">
                    <x-form.submit />
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('UI/assets/v1/js/custom/form.js') }}"></script>
    <script src="{{ asset('UI/assets/v1/js/custom/checkbox-select.js') }}"></script>
@endpush
