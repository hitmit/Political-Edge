@extends('layouts.master')
@section('title')
    Political edge | Add Income
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-header">
                        <h6 class="card-title">View Project: {{$project->name}}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card ">
                    <div class="card-header">
                        <h6 class="card-title">Income</h6>
                    </div>    
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>User name</th>
                                    <th>Amount</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->transections()->where('type', 'income')->get() as $key => $income)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $income->user()->first()->name }}</td>
                                        <td>{{ $income->amount }}</td>
                                        <td>{{ $income->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card ">
                    <div class="card-header">
                        <h6 class="card-title">Expense</h6>
                    </div>    
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>User name</th>
                                    <th>Amount</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->transections()->where('type', 'expense')->get() as $key => $expense)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $expense->user()->first()->name }}</td>
                                        <td>{{ $expense->amount }}</td>
                                        <td>{{ $expense->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
