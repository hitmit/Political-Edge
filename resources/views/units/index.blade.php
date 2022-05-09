@extends('layouts.master')
@section('title')
    Clever App | Dashboard
@endsection
@section('content')
    @php
    setlocale(LC_MONETARY, 'en_IN');
    @endphp
    <div class="page-content dashboard">
        @if (session()->has('status'))
            <div class="alert alert-success">
                <div class="message">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="row  mb-4">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card add-row">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6>Progress</h6>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addprogress">
                            Add Progress
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Date</th>
                                        <th>Progress</th>
                                        <th>Advance</th>
                                        <th>Expense</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee_transactions as $key => $employee_transaction)
                                        <tr>
                                            <th>{{ ++$key }}</th>
                                            <th>{{ $employee_transaction->date }}</th>
                                            <th>{{ $employee_transaction->units }}</th>
                                            <th>{{ $employee_transaction->advance }}
                                            </th>
                                            <th>{{ $employee_transaction->expense }}
                                            </th>
                                            <td>
                                                <form class="my-2"
                                                    action="{{ route('employee-transaction.destroy', $employee_transaction->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure want to delete')"
                                                        class="delete btn btn-danger"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $employee_transactions->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade transection_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
    </div>

    <!-- Button trigger modal -->
    <div class="modal fade" id="addprogress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="forms-sample" action="{{ route('employee-transaction.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Progress</h5>
                    </div>
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="exampleInputDate">Date</label>
                            <input type="hidden" name="project_id" id="project_id" value="{{ $project_id }}">
                            <input type="date" id="date" class="form-control @error('date') is-invalid @enderror"
                                name="date" value="{{ old('date') }}">
                            <span class="text-danger date_err">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="progress">Progress</label>
                            <input type="number" id="progress" class="form-control @error('progress') is-invalid @enderror"
                                name="progress" value="{{ old('progress') }}">
                            <span class="text-danger error-text progress_err"></span>
                        </div>
                        <div class="form-group">
                            <label for="advance">Advance</label>
                            <input type="number" id="advance" class="form-control @error('advance') is-invalid @enderror"
                                name="advance" value="{{ old('advance') }}">
                        </div>
                        <div class="form-group">
                            <label for="expense">Expense</label>
                            <input type="number" id="expense" class="form-control @error('expense') is-invalid @enderror"
                                name="expense" value="{{ old('expense') }}">

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitData" class="btn btn-primary mr-2">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        $("#submitData").click(function(e) {
            e.preventDefault();
            var date = $("#date").val();
            var progress = $("#progress").val();
            var advance = $("#advance").val();
            var expense = $("#expense").val();
            var project_id = $("#project_id").val();

            $.ajax({
                type: "post",
                url: "{{ route('employee-transaction.store') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'date': date,
                    'progress': progress,
                    'advance': advance,
                    'expense': expense,
                    'project_id': project_id,
                },
                success: function(data) {
                    // $("#addprogress").modal('hide');
                    location.reload();
                },
                error: function(response) {
                    printErrorMsg(response.responseJSON.errors);
                    printErrorMsg(response.responseJSON);
                }
            });

            function printErrorMsg(msg) {
                $.each(msg, function(key, value) {
                    // console.log(key);
                    // console.log(value);
                    $('.' + key + '_err').text(value);
                });
            }
        });
    </script>
@endpush
