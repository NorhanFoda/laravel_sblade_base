@extends('dashboard.layouts.master')
@section('title', __('messages.sidebar.roles_and_permissions'))


@section('content')
    <x-page-header previousPage="Pages" currentPage="Roles" previousPageLink="#">
        <x-header-button label="New Role" :href="route('roles.create')" />
    </x-page-header>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ __('messages.titles.roles') }}</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="row">
                        <x-filter />
                    </div>
                    <div class="table-responsive p-0" id="table">
                        @include('dashboard.roles.partials._table')
                    </div>
                </div>

                <x-pagination :models="$models" />

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('UI/assets/v1/js/custom/filters.js') }}"></script>
    <script src="{{ asset('UI/assets/v1/js/custom/table.js') }}"></script>
@endpush
