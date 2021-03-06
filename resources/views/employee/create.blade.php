@extends('layouts.master')
@section('title')
    Clever App | Add Employee
@endsection
@section('content')
    <form id="signupForm" action="{{ route('employee.store') }}" method="POST" s>
        @csrf
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card add-row">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="">Add Employee</h6>
                            <div>
                                <input type="checkbox" class="form-check-input" name="is_manager" value="1"
                                    id="manager" /><label for="manager">Is Manager</label>
                            </div>
                        </div>
                        <div class="card-body">

                            <fieldset>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" type="text">
                                    @error('name')
                                        <span class="invalid-feedback" rolRe="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Username</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" type="text" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Mobile No.</label>
                                    <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" type="number">
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
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm password</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <label for="users">Projects</label><br>
                                    <table>
                                        @foreach ($projects as $project)
                                            <tr>
                                                <td style="width: 32%;  padding-bottom: 5px;">
                                                    <input type="checkbox" name="projects[]" class="form-check"
                                                        value="{{ $project->id }}">
                                                </td>
                                                <td>{{ $project->name }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
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
