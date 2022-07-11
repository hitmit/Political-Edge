@extends('layouts.master')
@section('title')
    Clever App | Dashboard
@endsection
@section('content')
    <div class="page-content dashboard">
        <div class="row  mb-4">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card add-row">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6>{{ $project->name }}</h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <h6 id="total_amount" style="margin-right:10px;"></h6>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($progress) > 0)
                                                    @foreach ($progress as $key => $progres)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $progres->units }}</td>
                                                            <td>{{ $progres->date }}</td>
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
        </div>
    </div>
@endsection
@push('js')
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
