@extends('layouts.auth')
@section('content')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                        {{ __('app.titles.signin') }}</h4>

                                    @include('auth.partials.social-login')

                                </div>
                            </div>
                            <div class="card-body">
                                <form class="text-start" id="form" action="{{ route('login') }}"
                                    data-redirect="{{ route('home') }}">
                                    @csrf
                                    <x-form.input inputClass="bm-3 mb-3" :label="__('app.inputs.email')" name="email" type="email"
                                        :required="true" :errors="$errors" />

                                    <x-form.input inputClass="bm-3 mb-3" :label="__('app.inputs.password')" name="password" type="password"
                                        :required="true" :errors="$errors" />

                                    <x-form.switcher :label="__('app.inputs.remember_me')" name="remember_me" :checked="true" id="rememberMe" />

                                    <div class="text-center">
                                        <x-form.submit :label="__('app.btns.signin')" />
                                    </div>
                                    <p class="mt-4 text-sm text-center">
                                        {{ __('app.messages.dont_have_account') }}
                                        <a href="../pages/sign-up.html"
                                            class="text-primary text-gradient font-weight-bold">{{ __('app.btns.signup') }}</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script src="{{ asset('UI/assets/v1/js/custom/form.js') }}"></script>
@endpush
