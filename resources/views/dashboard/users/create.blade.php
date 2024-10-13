@extends('dashboard.layouts.master')
@section('title', __('messages.sidebar.users'))

@section('content')
    <x-page-header previousPage="Pages" currentPage="New User" previousPageLink="#" />

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body">
                    <form id="form"
                        action="{{ route('users.store') }}"
                        data-redirect="{{ route('users.index') }}">
                        @csrf
                        @include('dashboard.users.partials._form')
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
@endpush
