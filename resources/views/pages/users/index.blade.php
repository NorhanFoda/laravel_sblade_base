@extends('layouts.master')

@section('content')
    <x-page-header previousPage="Pages" currentPage="Users" previousPageLink="#">
        <x-header-button label="New User" :href="route('users.create')" />
    </x-page-header>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Users</h6>
                        <x-filter embed="roles:id,roles.permissions:id" />
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                        Author
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2">
                                        Function
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder text-center">
                                        Employed
                                    </th>
                                    <th class="text-secondary text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.users.partials.rows')
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
