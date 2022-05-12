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
                        <h6>Employee Transactions</h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addprogress">
                                Add Progress
                            </button>
                            <button type="button" style="margin-left: 5px;" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#addexpense">
                                Add Expense
                            </button>
                            <button type="button" style="margin-left: 5px;" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#addincome">
                                Add Income
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Progress</th>
                                        <th>Expense</th>
                                        <th>Category</th>
                                        <th>Income</th>
                                        <th>By Whom</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emplyee_datas as $key => $emplyee_data)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $emplyee_data->units }}</td>
                                            @if ($emplyee_data->type == 'expense')
                                                <td>{{ $emplyee_data->amount }}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>{{ $emplyee_data->employee_category()->first()->category ?? '' }}</td>
                                            @if ($emplyee_data->type == 'income')
                                                <td>{{ $emplyee_data->amount }}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>{{ $emplyee_data->user()->first()->name ?? '' }}
                                            </td>
                                            <td>{{ $emplyee_data->date }}</td>
                                            <td>
                                                <form class="my-2"
                                                    action="{{ route('employee-transaction.destroy', $emplyee_data->id) }}"
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

                </div>
            </div>
        </div>

        <div class="modal fade transection_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
    </div>

    <!-- add progress modal -->
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
                                name="date" value="{{ date('Y-m-d') }}">
                            <span class="text-danger date_err">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="progress">Progress</label>
                            <input type="number" id="progress" class="form-control @error('progress') is-invalid @enderror"
                                name="progress" value="{{ old('progress') }}">
                            <span class="text-danger error-text progress_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitProgress" class="btn btn-primary mr-2">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- add expense modal -->
    <div class="modal fade" id="addexpense" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="forms-sample" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
                    </div>
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="exampleInputDate">Date</label>
                            <input type="hidden" name="project_id" id="project_id" value="{{ $project_id }}">
                            <input type="date" id="date_expense" class="form-control" name="date"
                                value="{{ date('Y-m-d') }}">
                            <span class="text-danger date_expense_err">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger  category_err"></span>
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" class="form-control" name="amount" placeholder="Amount.">
                            <span class="text-danger amount_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitExpense" class="btn btn-primary mr-2">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- add income modal -->
    <div class="modal fade" id="addincome" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="forms-sample" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Income</h5>
                    </div>
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="exampleInputDate">Date</label>
                            <input type="hidden" name="project_id" id="project_id" value="{{ $project_id }}">
                            <input type="date" id="date_income" class="form-control" value="{{ date('Y-m-d') }}"
                                name="date">
                            <span class="text-danger date_income_err">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="category">By Whom</label>
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger  user_id_err"></span>
                        </div>

                        <div class="form-group">
                            <label for="amount_income">Amount</label>
                            <input type="number" id="amount_income" class="form-control" name="amount"
                                placeholder="Amount.">
                            <span class="text-danger amount_income_err"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitIncome" class="btn btn-primary mr-2">Submit</button>
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
        $("#submitProgress").click(function(e) {
            e.preventDefault();
            var date = $("#date").val();
            var progress = $("#progress").val();
            var project_id = $("#project_id").val();

            $.ajax({
                type: "post",
                url: "{{ route('employee-transaction.store') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'date': date,
                    'progress': progress,
                    'project_id': project_id,
                },
                success: function(data) {
                    location.reload();
                },
                error: function(response) {
                    printErrorMsg(response.responseJSON.errors);
                }
            });

            function printErrorMsg(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                    $("#" + key).addClass('is-invalid');
                });
            }
        });

        $("#submitExpense").click(function(e) {
            e.preventDefault();
            var date_expense = $("#date_expense").val();
            var amount = $("#amount").val();
            var category = $("#category").val();
            var project_id = $("#project_id").val();

            $.ajax({
                type: "post",
                url: "{{ route('employee-transaction-expense.store') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'date_expense': date_expense,
                    'amount': amount,
                    'category': category,
                    'project_id': project_id,
                },
                success: function(data) {
                    if (data) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
                error: function(response) {
                    printErrorMsg(response.responseJSON.errors);
                }
            });

            function printErrorMsg(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                    console.log(key);

                    $("#" + key).addClass('is-invalid');
                });
            }
        });

        $("#submitIncome").click(function(e) {
            e.preventDefault();
            var date_income = $("#date_income").val();
            var amount_income = $("#amount_income").val();
            var user_id = $("#user_id").val();
            var project_id = $("#project_id").val();

            $.ajax({
                type: "post",
                url: "{{ route('employee-transaction-income.store') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'date_income': date_income,
                    'amount_income': amount_income,
                    'user_id': user_id,
                    'project_id': project_id,
                },
                success: function(data) {
                    if (data) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
                error: function(response) {
                    printErrorMsg(response.responseJSON.errors);
                }
            });

            function printErrorMsg(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                    console.log(key);

                    $("#" + key).addClass('is-invalid');
                });
            }
        });
    </script>
@endpush
