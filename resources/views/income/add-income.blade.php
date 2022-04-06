@extends('layouts.master')
@section('title')
    Clever App | Add Receivables
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Add Receivables</h6>
                        <form class="forms-sample" action="{{ route('income.store') }}" method="POST">
                            @csrf
                            <!-- Date and time picker with disbaled dates -->
                            <div class="form-group">
                                <label for="exampleInputDate">Date</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                                 id="date">
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
                            @if ($users && !empty($users)) 
                                <div class="form-group">
                                    <label for="user_id">Select User</label>
                                    <select class="form-control @error('user_id') is-invalid @enderror" name="user_id">
                                        <option selected disabled>Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                                <label for="exampleInputNumber1"> Amount</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                     id="amount" value="{{ old('amount') }}" name="amount"
                                    Placeholder="Enter Amount">
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
@push('js')
<script>
function getDate() {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();

  if(dd<10) {
      dd = '0'+dd
  } 

  if(mm<10) {
      mm = '0'+mm
  } 

  today =  yyyy + '-' + mm + '-' + dd;
  console.log(today);
  document.getElementById("date").value = today;
}


$(document).ready(function() {
  getDate();
});
</script>
@endpush
