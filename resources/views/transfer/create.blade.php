@extends('layouts.master')
@section('title')
    Clever App | Transfer amount
@endsection
@section('content')
    <div class="page-content">
        @include('include/error')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Transfer amount</h6>
                        <div class="table-responsive my-2">
                            <form class="forms-sample" action="{{ route('transfer.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputDate">Users</label>
                                    <div class="input-group" id="user">

                                        <select name="receiver_id" id="user"
                                            class="form-control @error('receiver_id') is-invalid @enderror">
                                            <option value="">--Select User--</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('receiver_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputDate">Enter amount</label>
                                    <div class="input-group" id="user">
                                        <input type="text" class="form-control @error('amount_send') is-invalid @enderror"
                                            name="amount_send" value="{{ old('amount_send') }}">
                                        @error('amount_send')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
