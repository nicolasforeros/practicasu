@extends('layouts.app')

@section('content')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header font-weight-bold">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class=row>
                            <div class="col">
                                <a class="btn btn-primary btn-block" href="{{ route('company.index') }}">{{ __('Companies') }}</a>
                            </div>
                            @can('see user')
                            <div class="col">
                                <a class="btn btn-primary btn-block" href="{{ route('user.index') }}">{{ __('Users') }}</a>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
