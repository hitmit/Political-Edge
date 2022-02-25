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
                        <h6 class="card-title">Add Income</h6>
                        <form class="forms-sample" action="{{ route('income.store') }}" method="POST">
                            @csrf
                            <!-- Date and time picker with disbaled dates -->
                            <div class="form-group">
                                <label for="exampleInputDate">Date</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                                        value="{{ old('date') }}">
                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTime">Time</label>
                                <div class="input-group date timepicker" id="datetimepickerExample"
                                    data-target-input="nearest">
                                    <input type="time" class="form-control @error('time') is-invalid @enderror" name="time"
                                        value="{{ old('time') }}" data-target="#datetimepickerExample" />
                                    @error('time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Project</label>
                                <select class="form-control @error('project') is-invalid @enderror"
                                    id="exampleFormControlSelect1" name="project">
                                    <option selected disabled>Select your Project</option>
                                    @foreach ($projects as $name)
                                        <option value="{{ $name->id }}">{{ $name->name }}</option>
                                    @endforeach
                                </select>
                                @error('project')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputNumber1">Income Amount</label>
                                <input type="number" class="form-control @error('amt') is-invalid @enderror"
                                    id="exampleInputNumber1" id="amt" value="{{ old('amt') }}" name="amt"
                                    Placeholder="Enter Income Amount">
                                @error('amt')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Remark*</label>
                                <textarea class="form-control @error('remark') is-invalid @enderror"
                                    id="exampleFormControlTextarea1" name="remark"
                                    rows="5">{{ old('remark') }}</textarea>
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
