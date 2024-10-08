@extends('layouts.master')

@section('content')
    <x-page-header previousPage="Pages" currentPage="Roles" previousPageLink="#">
        <x-header-button label="New Role" :href="route('roles.create')" />
    </x-page-header>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ __('app.titles.roles') }}</h6>
                        <x-filter />
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                        {{ __('app.table.header.id') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2 text-center">
                                        {{ __('app.table.header.role') }}
                                    </th>
                                    <th class="text-secondary text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.roles.partials.rows')
                            </tbody>
                        </table>
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
