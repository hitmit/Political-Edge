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
                                                <td>{{ $project->employee_transactions()->sum('units') }}</td>
                                                <td>{{ $project->units == 0 ? 0 : ($project->employee_transactions()->sum('units') / $project->units) * 100 }}
                                                    {{-- <td>{{ ($project->employee_transactions()->sum('units') / $project->units) * 100 }} --}}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('project.details', $project->id) }}" class="btn btn-primary">
                                                            Add Progress
                                                        </a>
                                                        <a href="#" class="btn btn-primary">
                                                            Add Expense
                                                        </a>
                                                        <a href="#" class="btn btn-primary">
                                                            Add Income
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
@endsection
