@extends('layouts.master')
@section('title')
    Clever App | Update User
@endsection
@section('content')
    <form id="signupForm" action="{{ route('users.update', $user->id) }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card add-row">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="">Update User Details</h6>
                            <div>
                                <input type="checkbox" {{ $user->role == 'is_manager' ? 'checked' : '' }}
                                    class="form-check-input" name="is_manager" value="1" id="manager" /><label
                                    for="manager">Is Manager</label>
                            </div>
                        </div>
                        <div class="card-body">


                            <fieldset>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $user->name }}" type="text">
                                    @error('name')
                                        <span class="invalid-feedback" rolRe="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Username</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" type="text" value="{{ $user->email }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Mobile No.</label>
                                    <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ $user->phone }}" type="number">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Confirm password</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" autocomplete="new-password">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </fieldset>

                        </div>
                    </div>
                </div>


            </div>


        </div>
    </form>
@endsection
