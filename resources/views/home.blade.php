@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User {{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} as <strong>User</strong>
                    @if (Auth::guard('web')->check())
                        <p class="text-success">You are logged in as <strong>User</strong></p>
                    @else
                    <p class="text-danger">You are logged out as <strong>User</strong></p>
                    @endif
                    @if (Auth::guard('admin')->check())
                    <p class="text-success">You are logged in as <strong>Admin</strong></p>
                    @else
                    <p class="text-danger">You are logged out as <strong>Admin</strong></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
