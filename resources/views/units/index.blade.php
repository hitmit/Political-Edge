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
                        <h6>{{ $project->name }}</h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <h6 id="total_amount" style="margin-right:10px;">
                            </h6>
                            <button type="button" class="pt-2 btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addprogress">
                                Add Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item mb-3 mr-2">
                                    <a class="nav-link active show" id="active_expense" data-toggle="tab" href="#expenses"
                                        role="tab" aria-controls="expenses" aria-selected="true">Expense</a>
                                </li>
                                <li class="nav-item mb-3 mr-2">
                                    <a class="nav-link" data-toggle="tab" id="active_advance" href="#advance" role="tab"
                                        aria-controls="advance" aria-selected="false">Advance</a>
                                </li>
                                <li class="nav-item mb-3 mr-2">
                                    <a class="nav-link" data-toggle="tab" id="active_progress" href="#progress"
                                        role="tab" <a class="nav-link" data-toggle="tab" id="active_progress"
                                        href="#progress" role="tab" aria-controls="progress"
                                        aria-selected="true">Progress</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3 mx-0">
                                <div class="tab-pane active show" id="expenses" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>SNO</th>
                                                    <th>Expense</th>
                                                    <th>Category</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($expenses))
                                                    @foreach ($expenses as $key => $expense)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            @if ($expense->type == 'expense')
                                                                <td>{{ $expense->amount }}</td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                            <td>{{ $expense->employee_category()->first()->category ?? '' }}
                                                            </td>
                                                            <td>{{ $expense->date }}</td>
                                                            <td>
                                                                <form class="my-2"
                                                                    action="{{ route('employee-transaction.destroy', $expense->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        onclick="return confirm('Are you sure want to delete')"
                                                                        class="delete btn btn-danger"><i class="fa fa-trash"
                                                                            aria-hidden="true"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">No record found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="advance" role="tabpanel" aria-labelledby="">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>SNO</th>
                                                    <th>Advance</th>
                                                    <th>By Whom</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($incomes))
                                                    @foreach ($incomes as $key => $income)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $income->amount }}</td>
                                                            <td>{{ $income->user()->first()->name ?? '' }}
                                                            <td>{{ $income->date }}</td>
                                                            <td>
                                                                <form class="my-2"
                                                                    action="{{ route('employee-transaction.destroy', $income->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        onclick="return confirm('Are you sure want to delete')"
                                                                        class="delete btn btn-danger"><i class="fa fa-trash"
                                                                            aria-hidden="true"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">No record found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress" role="tabpanel" aria-labelledby="">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>SNO</th>
                                                    <th>Progress</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($progress) > 0)
                                                    @foreach ($progress as $key => $progres)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $progres->units }}</td>
                                                            <td>{{ $progres->date }}</td>
                                                            <td>
                                                                <form class="my-2"
                                                                    action="{{ route('employee-transaction.destroy', $progres->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        onclick="return confirm('Are you sure want to delete')"
                                                                        class="delete btn btn-danger"><i class="fa fa-trash"
                                                                            aria-hidden="true"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">No record found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade transection_modal" tabindex="-1" role="dialog"
                    aria-labelledby="gridSystemModalLabel">
                </div>
            </div>

            <!-- add progress modal -->
            <div class="modal fade" id="addprogress" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="forms-sample" action="{{ route('employee-transaction.store') }}" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Progress</h5>
                            </div>
                            <div class="modal-body">

                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputDate">Date</label>
                                    <input type="hidden" name="project_id" id="project_id"
                                        value="{{ $project_id }}">
                                    <input type="date" id="date"
                                        class="form-control @error('date') is-invalid @enderror" name="date"
                                        value="{{ date('Y-m-d') }}">
                                    <span class="text-danger date_err">
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="progress_data">Progress</label>
                                    <input type="number" id="progress_data"
                                        class="form-control @error('progress_data') is-invalid @enderror"
                                        name="progress_data" value="{{ old('progress_data') }}">
                                    <span class="text-danger error-text progress_err"></span>
                                </div>

                                <h5 style="text-align: center" class="modal-title">Expense</h5>
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <table class="table">
                                        @foreach ($categories as $key => $category)
                                            <tr>
                                                <td><input type="hidden" name="expense_category[]" id="expense_category"
                                                        style="border: none" readonly
                                                        value="{{ $category->id }}">{{ $category->category }}</td>

                                                <td style="width: 50%;  padding-bottom: 5px;">
                                                    <input type="number" name="expense_amount[{{ $category->id }}]"
                                                        id="expense_amount[{{ $category->id }}]"
                                                        placeholder="Enter amount." title="Amount" class="form-control">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <h5 style="text-align: center" class="modal-title">Advance</h5>
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
                                <button type="submit" id="submitProgress" class="btn btn-primary mr-2">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
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
            var project_id = $("#project_id").val();

            var user_id = $("#user_id").val();

            var date = $("#date").val();
            var progress = $("#progress_data").val();

            var amount_income = $("#amount_income").val();
            var expense_amount = [];
            var expense_category_arr = [];
            var category_id = [];

            $('input[name="expense_category[]"]').each(function() {
                expense_category_arr.push(this.value);
            });

            for (let index = 1; index <= expense_category_arr.length; index++) {
                if ($("input[name='expense_amount[" + index + "]']").val() != '') {
                    expense_amount.push($("input[name='expense_amount[" + index + "]']").val());
                    category_id.push(index);
                }
            }

            $.ajax({
                type: "post",
                url: "{{ route('employee-transaction.store') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'date': date,
                    'progress': progress,
                    'project_id': project_id,
                    'expense_amount': expense_amount,
                    'category_id': category_id,
                    'amount_income': amount_income,
                    'user_id': user_id,
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
                    $('.is-invalid').focus();
                });
            }
        });

        function clearProgress(arg) {
            var id = arg.getAttribute('id');
            $('.' + id + '_err').text('');
            $("#" + id).removeClass('is-invalid');
        }
    </script>

    <script>
        $('#total_amount').text('Total Expense: ' + {{ $employee_total_expense }});


        $('#active_advance').click(function() {
            $('#total_amount').text('Total Advance: ' + {{ $employee_total_advance }});
        });
        $('#active_progress').click(function() {
            $('#total_amount').text('Total Progress: ' + {{ $employee_total_progress }});
        });
        $('#active_expense').click(function() {
            $('#total_amount').text('Total Expense: ' + {{ $employee_total_expense }});
        })
    </script>
@endpush
