@extends('layouts.master')
@section('content')
    <x-page-header previousPage="Pages" currentPage="New User" previousPageLink="#" />

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body">
                    <form id="form"
                        action="{{ isset($model['resource']) ? route('users.update', ['user' => $model['resource']]) : route('users.store') }}"
                        data-redirect="{{ route('users.index') }}">
                        @csrf
                        @if (isset($model['resource']))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <x-form.input class="col-md-6" label="Name" name="name" type="text"
                                value="{{ $model['resource']?->name }}" :required="true" :errors="$errors" />

                            <x-form.input class="col-md-6" label="Email" name="email" type="email"
                                value="{{ $model['resource']?->email }}" :required="true" :errors="$errors" />

                            <x-form.input class="col-md-6" label="Password" name="password" type="password"
                                :required="true" :errors="$errors" />

                            <x-form.input class="col-md-6" label="Password Confirmation" name="password_confirmation"
                                type="password" :required="true" :errors="$errors" />
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
    <script src="{{ asset('UI/assets/v1/js/custom/form.js') }}"></script>
@endpush
