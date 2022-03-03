@extends('layouts.master')
@section('title')
    Political edge | Add Income
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Update Expenses Details</h6>
                        <form class="forms-sample" action="{{ route('expenses.update', $expense->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="exampleInputDate">Date</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        value="{{ $expense->date }}" name="date" value="{{ old('date') }}">
                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Project</label>
                                <select class="form-control @error('project') is-invalid @enderror"
                                    name="project">
                                    <option disabled>Select your Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->name }}" @if($project->id == $expense->project_id) 'selected' @endif>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Category</label>
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                    name="category_id">
                                    <option  disabled>Select your Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if($category->id == $expense->category_id) 'selected' @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('project')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if (!empty($users)) 
                                <div class="form-group">
                                    <label for="user_id">Select User</label>
                                    <select class="form-control @error('user_id') is-invalid @enderror" name="user_id">
                                        <option selected disabled>Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if($user->id == $expense->user_id) 'selected' @endif)>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputNumber1">Amount</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                     id="amount" value="{{ $expense->amount }}" name="amount"
                                    Placeholder="Enter Income Amount">
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="amount_confirmation">Confirm Amount</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                     id="amount_confirmation" value="{{ old('amount_confirmation') }}" name="amount_confirmation"
                                    Placeholder="Confirm Amount">
                                @error('amount_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Remark</label>
                                <textarea class="form-control @error('remark') is-invalid @enderror"
                                    id="exampleFormControlTextarea1" name="remark"
                                    rows="5">{{ $expense->remark }}</textarea>
                                @error('remark')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>


    </div>
@endsection
