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
                                                @money(($a3 * 2) / 3 + $total_internal, 'INR')
                                            </td>
                                            <td>
                                                @money(($b3 * 2) / 3, 'INR')
                                            </td>
                                            <td>
                                                @money(($c3 * 2) / 3, 'INR')
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>B</th>
                                            <td>
                                                @money(($a3 * 1) / 3 + $total_internal, 'INR')
                                            </td>
                                            <td>
                                                @money(($b3 * 1) / 3, 'INR')
                                            </td>
                                            <td>
                                                @money(($c3 * 1) / 3, 'INR')
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
                                                <td>@money($incomes, 'INR')
                                                </td>
                                                <td>@money($transfer, 'INR')
                                                </td>
                                                <td>@money($expenses, 'INR')
                                                </td>
                                                <td>@money($incomes + $transfer - $expenses, 'INR')
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
                                                    @money($total_expected_revenue, 'INR')
                                                </p>
                                            </div>
                                            <div class="col">
                                                <h6 class="">Receivables</h6>
                                                <p class="num-pt">
                                                    @money($total_income, 'INR')
                                                </p>
                                            </div>

                                            <div class="col">
                                                <h6 class="">Balance</h6>
                                                <p class="num-pt">
                                                    @money($total_expected_revenue - $total_income, 'INR')
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
                                                        <td>@money($exrev, 'INR')
                                                        </td>
                                                    @endif
                                                    <td>@money($incomes, 'INR')
                                                    </td>
                                                    <td>@money($balance, 'INR')
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
                                                        <td>@money($exrev, 'INR')
                                                        </td>
                                                    @endif
                                                    <td>@money($incomes, 'INR')
                                                    </td>
                                                    <td>@money($balance, 'INR')
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
                                            <th>Unit Completed</th>
                                            <th>Projects</th>
                                            <th>Advance</th>
                                            <th>Expenses</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $key => $project)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $project->employee_transactions(Auth()->user()->id) }} /
                                                    {{ $project->units }}
                                                </td>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->advance_total(Auth()->user()->id) }}</td>
                                                <td>{{ $project->expense_total(Auth()->user()->id) }}</td>
                                                <td>{{ $project->expense_total(Auth()->user()->id) - $project->advance_total(Auth()->user()->id) }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('project.details', $project->id) }}"
                                                            class="btn btn-primary">
                                                            Add Data
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
        @if (auth()->getUser()->role == 'is_manager')
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
                                <table id="dataTableExample" class="table">
                                    <thead>
                                        <tr>
                                            <th>Sr.no</th>
                                            <th>Name</th>
                                            <th>Unit Completed</th>
                                            <th>Projects</th>
                                            <th>Advance</th>
                                            <th>Expenses</th>
                                            <th>Balance</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($projects as $user_id => $user_projects)
                                            @foreach ($user_projects as $project)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $project->getUser($user_id) }}</td>
                                                    <td>{{ $project->employee_transactions($user_id) }} /
                                                        {{ $project->units }}</td>
                                                    <td>{{ $project->name }}</td>
                                                    <td>{{ $project->advance_total($user_id) }}</td>
                                                    <td>{{ $project->expense_total($user_id) }}</td>
                                                    <td>{{ $project->expense_total($user_id) - $project->advance_total($user_id) }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('employee.report.show', [$user_id, $project->id]) }}"
                                                                class="delete m-2 btn btn-primary"><i
                                                                    class="fa fa-eye"></i></a>
                                                            <form class="my-2"
                                                                action="{{ route('employee-report.destroy', $project->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    onclick="return confirm('Are you sure want to delete')"
                                                                    class="delete btn btn-danger"><i class="fa fa-trash"
                                                                        aria-hidden="true"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
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
