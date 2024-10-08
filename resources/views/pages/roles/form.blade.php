@extends('layouts.master')
@section('content')
    <x-page-header previousPage="Pages" currentPage="New Role" previousPageLink="#" />
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body">
                    <form id="form"
                        action="{{ $model['resource']?->id ? route('roles.update', ['role' => $model['resource']]) : route('roles.store') }}"
                        data-redirect="{{ route('roles.index') }}">
                        @csrf
                        @if ($model['resource']?->id)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <x-form.input class="col-md-12" label="Name" name="name" type="text"
                                value="{{ $model['resource']?->name }}" :required="true" :errors="$errors" />
                            <x-roles.permissions-card :permissions="$model['data']['permissions']" />
                        </div>
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
    <script src="{{ asset('UI/assets/v1/js/custom/checkbox-select.js') }}"></script>
    <script src="{{ asset('UI/assets/v1/js/custom/form.js') }}"></script>
@endpush
