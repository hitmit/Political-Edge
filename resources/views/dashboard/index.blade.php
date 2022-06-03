@extends('layouts.master')
@section('title')
    Clever App | Dashboard
@endsection
@section('content')
    @php
    setlocale(LC_MONETARY, 'en_IN');
    @endphp
    <div class="page-content dashboard">
        @if (auth()->user()->role == 'admin')
            <div class="row  mb-4">
                <div class="col-lg-12 col-xl-12 stretch-card">
                    <div class="card add-row">
                        <div class="card-header">
                            <h6 class="card-title">Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Acc</th>
                                            <th>Others</th>
                                            <th>Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>A</th>
                                            <td>
                                                {{ str_replace(['INR', '.00'], '', money_format('%i', round(($a3 * 2) / 3) + $total_internal)) }}
                                            </td>
                                            <td>
                                                {{ str_replace(['INR', '.00'], '', money_format('%i', round(($b3 * 2) / 3))) }}
                                            </td>
                                            <td>
                                                {{ str_replace(['INR', '.00'], '', money_format('%i', round(($c3 * 2) / 3))) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>B</th>
                                            <td>
                                                {{ str_replace(['INR', '.00'], '', money_format('%i', round(($a3 * 1) / 3) + $total_internal)) }}
                                            </td>
                                            <td>
                                                {{ str_replace(['INR', '.00'], '', money_format('%i', round(($b3 * 1) / 3))) }}
                                            </td>
                                            <td>
                                                {{ str_replace(['INR', '.00'], '', money_format('%i', round(($c3 * 1) / 3))) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'user')
            <div class="row  mb-4">
                <div class="col-lg-12 col-xl-12 stretch-card">
                    <div class="card add-row">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-2 col-12">
                                    <h6 class="card-title">Users</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Receivables</th>
                                            <th>Internal</th>
                                            <th>Expenses</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            @php
                                                $incomes = $user
                                                    ->transections()
                                                    ->where('type', 'income')
                                                    ->sum('amount');
                                                $expenses = $user
                                                    ->transections()
                                                    ->where('type', 'expense')
                                                    ->sum('amount');
                                                $transfer = $user->totalReceived() - $user->totalSend();
                                            @endphp
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $incomes)) }}
                                                </td>
                                                <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $transfer)) }}
                                                </td>
                                                <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $expenses)) }}
                                                </td>
                                                <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $incomes + $transfer - $expenses)) }}
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
            <div class="row mb-4">
                <div class="col-lg-12 col-xl-12 stretch-card">
                    <div class="card add-row">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-2 col-12">
                                    <h6 class="card-title">Projects</h6>
                                </div>
                                <div class="col-lg-10 col-12">
                                    <div class="row txt-r">
                                        @if (auth()->getUser()->role == 'admin')
                                            <div class="col">
                                                <h6 class="">Expected</h6>
                                                <p class="num-pt">
                                                    {{ str_replace(['INR', '.00'], '', money_format('%i', $total_expected_revenue)) }}
                                                </p>
                                            </div>
                                            <div class="col">
                                                <h6 class="">Receivables</h6>
                                                <p class="num-pt">
                                                    {{ str_replace(['INR', '.00'], '', money_format('%i', $total_income)) }}
                                                </p>
                                            </div>

                                            <div class="col">
                                                <h6 class="">Balance</h6>
                                                <p class="num-pt">
                                                    {{ str_replace(['INR', '.00'], '', money_format('%i', $total_expected_revenue - $total_income)) }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Project</th>
                                            @if (auth()->getUser()->role == 'admin')
                                                <th>Expected</th>
                                            @endif
                                            <th>Receivables</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $key => $project)
                                            @php
                                                $exrev = $project->expected_revenue;
                                                $balance =
                                                    $exrev -
                                                    $project
                                                        ->transections()
                                                        ->where('type', 'income')
                                                        ->sum('amount');
                                                if (auth()->getUser()->role == 'admin') {
                                                    $incomes = $project
                                                        ->transections()
                                                        ->where('type', 'income')
                                                        ->sum('amount');
                                                } else {
                                                    $incomes = $project
                                                        ->transections()
                                                        ->where('type', 'income')
                                                        ->where('user_id', auth()->getUser()->id)
                                                        ->sum('amount');
                                                }
                                                
                                            @endphp
                                            @if (auth()->getUser()->role == 'admin')
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td><span class="cursor-pointer btn-modal"
                                                            data-container=".transection_modal"
                                                            data-href="{{ route('project.show', $project->id) }}">{{ $project->name }}</span>
                                                    </td>
                                                    @if (auth()->getUser()->role == 'admin')
                                                        <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $exrev)) }}
                                                        </td>
                                                    @endif
                                                    <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $incomes)) }}
                                                    </td>
                                                    <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $balance)) }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td><span class="cursor-pointer btn-modal"
                                                            data-container=".transection_modal"
                                                            data-href="{{ route('project.show', $project->id) }}">{{ $project->name }}</span>
                                                    </td>
                                                    @if (auth()->getUser()->role == 'admin')
                                                        <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $exrev)) }}
                                                        </td>
                                                    @endif
                                                    <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $incomes)) }}
                                                    </td>
                                                    <td>{{ str_replace(['INR', '.00'], '', money_format('%i', $balance)) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->getUser()->role == 'employee')
            <div class="row mb-4">
                <div class="col-lg-12 col-xl-12 stretch-card">
                    <div class="card add-row">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-2 col-12">
                                    <h6 class="card-title">Projects</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Projects</th>
                                            <th>Units</th>
                                            <th>Unit Completed</th>
                                            <th>Progress (%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $key => $project)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $project->project()->first()->name }}</td>
                                                <td>{{ $project->units }}</td>
                                                <td>{{ $project->employee_transactions()->sum('units') }} /
                                                    {{ $project->units }}</td>
                                                <td>{{ round($project->units == 0 ? 0 : ($project->employee_transactions()->sum('units') / $project->units) * 100, 2) }}
                                                    {{-- <td>{{ ($project->employee_transactions()->sum('units') / $project->units) * 100 }} --}}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('project.details', $project->id) }}"
                                                            class="btn btn-info">
                                                            <i class="fa fa-eye" aria-hidden="true"></i> View
                                                        </a>
                                                        <a href="#" class="btn btn-sm btn-primary" id="addProgress"
                                                            data-bs-toggle="modal" data-bs-target="#addprogress"
                                                            data-id="{{ $project->id }}" class="btn btn-primary">
                                                            Add Progress
                                                        </a>
                                                    </div>
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
        @endif

        <div class="modal fade transection_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
    </div>

    <!-- add progress modal -->
    <div class="modal fade" id="addprogress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- for increasing the size --}}
        {{-- modal-dialog modal-lg add to this is below line of code --}}
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
                            <input type="hidden" name="project_id" id="project_id">
                            <input type="date" id="date" class="form-control @error('date') is-invalid @enderror"
                                name="date" value="{{ date('Y-m-d') }}">
                            <span class="text-danger date_err">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="progress">Progress</label>
                            <input type="number" id="progress" class="form-control @error('progress') is-invalid @enderror"
                                name="progress" onkeyup="clearProgress(this)" value="{{ old('progress') }}">
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
                                                id="expense_amount[{{ $category->id }}]" placeholder="Enter amount."
                                                title="Amount" class="form-control">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <h5 style="text-align: center" class="modal-title">Income</h5>
                        <div class="form-group">
                            <label for="category">By Whom</label>
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach ($employee_users as $user)
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
@endsection



@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        $(document).on("click", "#addProgress", function() {
            window.project_id = $(this).data('id');
        });
        $("#submitProgress").click(function(e) {
            e.preventDefault();

            var project_id = window.project_id;
            console.log(project_id  + "dd");
            var user_id = $("#user_id").val();

            var date = $("#date").val();
            var progress = $("#progress").val();

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
@endpush
