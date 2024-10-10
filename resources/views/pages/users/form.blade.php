@extends('layouts.master')
@section('content')
    <x-page-header previousPage="Pages" currentPage="New User" previousPageLink="#" />

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body">
                    {{-- {{ dd($model['data']['roles']) }} --}}
                    <form id="form"
                        action="{{ $model['resource']?->id ? route('users.update', ['user' => $model['resource']]) : route('users.store') }}"
                        data-redirect="{{ route('users.index') }}">
                        @csrf
                        @if ($model['resource']?->id)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-6 mb-3 bm-3">
                                <x-form.input label="Name" name="name" type="text"
                                    value="{{ $model['resource']?->name }}" :required="true" :errors="$errors" />
                            </div>
                            <div class="col-md-6 mb-3 bm-3">
                                <x-form.input label="Email" name="email" type="email"
                                    value="{{ $model['resource']?->email }}" :required="true" :errors="$errors" />
                            </div>
                            <div class="col-md-6 mb-3 bm-3">
                                <x-form.input label="Password" name="password" type="password" :required="true"
                                    :errors="$errors" />
                            </div>
                            <div class="col-md-6 mb-3 bm-3">
                                <x-form.input label="Password Confirmation" name="password_confirmation" type="password"
                                    :required="true" :errors="$errors" />
                            </div>
                            <div class="col-md-6 mb-3 bm-3">
                                <x-form.select name="role_id" :options="$model['data']['roles']" :required="true" :errors="$errors" />
                            </div>
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
