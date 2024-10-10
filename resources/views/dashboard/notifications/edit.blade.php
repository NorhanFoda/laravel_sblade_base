@extends('layouts.master')
@section('content')
    <x-page-header previousPage="Pages" currentPage="Edit Notification" previousPageLink="#"/>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body">
                    <form id="form"
                          action="{{ route('dashboard.notifications.update',$resource->id)}}"
                          data-redirect="{{ route('dashboard.notifications.index') }}">
                        @csrf
                        @method('PUT')
                        @include('dashboard.notifications.partials.form')
                    </form>
                </div>
                <div class="card-footer">
                    <x-form.submit/>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('UI/assets/v1/js/custom/form.js') }}"></script>
@endpush
