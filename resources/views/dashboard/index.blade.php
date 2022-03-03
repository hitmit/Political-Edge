@extends('layouts.master')
@section('title')
    Political edge | Dashboard
@endsection
@section('content')
    <div class="page-content dashboard">

        <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="row  dash-cards">
           
		   <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="card-boxx">
                            <div class="tt-box">
                                <h6 class="">Total Projects</h6>
                                <h2 class="mb-0 number-font">{{ $projects->count() }}</h2>
                            </div>
                            <div class="ico-box">
                                <span class="icon-card"><i class="link-icon" data-feather="box"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="card-boxx">
                            <div class="tt-box">
                                 <h6 class="">Total Receivables</h6>
                                <h2 class="mb-0 number-font">{{$total_income}}</h2>
                            </div>
                            <div class="ico-box">
                                <span class="icon-card"><i class="link-icon" data-feather="plus"></i></span>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
			
			
			<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="card-boxx">
                            <div class="tt-box">
                                  <h6 class="">Total Expenses</h6>
                                <h2 class="mb-0 number-font">{{$total_expense}}</h2>
                            </div>
                            <div class="ico-box">
                                <span class="icon-card"><i class="link-icon" data-feather="minus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="card-boxx">
                            <div class="tt-box">
                                <h6 class="">Total Balance</h6>
                                <h2 class="mb-0 number-font">{{$total_income - $total_expense}}</h2>
                            </div>
                            <div class="ico-box">
                                <span class="icon-card"><i class="link-icon" data-feather="briefcase"></i></span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
		</div>
    </div>
</div>

        
        <div class="row mb-4">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card add-row">
                    <div class="card-header">
                        <h6 class="card-title">Projects</h6>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>Income</th>
                                    <th>Expenses</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $project)
                                    @php
                                        $incomes = $project->transections()->where('type', 'income')->sum('amount');
                                        $expenses = $project->transections()->where('type', 'expense')->sum('amount');
                                    @endphp
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td><a href="{{ route('project.show', $project->id) }}">{{ $project->name}}</a></td>
                                        <td>{{ $incomes }}</td>
                                        <td>{{ $expenses; }}</td>
                                        <td>{{ $incomes-$expenses }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                   
            </div>
        </div>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card add-row">
                    <div class="card-header">
                        <h6 class="card-title">Users</h6>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Income</th>
                                    <th>Expenses</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    @php
                                        $incomes = $user->transections()->where('type', 'income')->sum('amount');
                                        $expenses = $user->transections()->where('type', 'expense')->sum('amount');
                                    @endphp
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $incomes }}</td>
                                        <td>{{ $expenses; }}</td>
                                        <td>{{ $incomes-$expenses }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
@endsection
