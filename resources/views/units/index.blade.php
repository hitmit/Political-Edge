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
                        <div class="btn-group" role="group">
                            <h6 id="total_amount" class="m-2"></h6>
                            <button type="button" id="add_details"  data-id = {{ $project->id }}  class="pt-2 btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addprogress">
                               <i class="fa fa-plus"></i> Add Details
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
                                        aria-selected="true">Booths Completed</a>
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
                                                    <th>Remark</th>
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
                                                            <td>
                                                                {{isset($expense->remark) && $expense->remark != '' ? $expense->remark:'-'}}
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
                                                        <td colspan="6">No record found.</td>
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
                                                    <th>Booths Completed</th>
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

            @if (auth()->user()->role == 'employee')
                @include('progress-modal.modal',['project_id'=>$project->id])
            @endif
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
            let remark = $("#remark").val();
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
                    'remark':remark,
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
