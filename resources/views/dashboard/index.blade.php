@extends('layouts.master')
@section('title')
    Clever App | Dashboard
@endsection
@section('content')
@php
setlocale(LC_MONETARY,"en_IN");

@endphp
<div class="page-content dashboard">
    <div class="row  mb-4">
        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card add-row">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2 col-12">
                            <h6 class="card-title">Users</h6>
                        </div>
                        @if (auth()->getUser()->is_admin)
                            <div class="col-lg-10 col-12">
                                <div class="row txt-r">
                                    <div class="col">
                                        <h6 class="">A (2/3)</h6>
                                        <p class="num-pt">{{ str_replace(["INR", ".00"], "", money_format("%i", (($total_income-$total_expense)*2)/3)) }}</p>
                                    </div>
                                    <div class="col">
                                        <h6 class="">B (1/3)</h6>
                                        <p class="num-pt">{{ str_replace(["INR", ".00"], "", money_format("%i", (($total_income-$total_expense)*1)/3)) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Total Receivables</th>
                                    <th>Total Expenses</th>
                                    <th>Total Balance</th>
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
                                        <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $incomes)) }}</td>
                                        <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $expenses)) }}</td>
                                        <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $incomes-$expenses)) }}</td>
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
                                @if(auth()->getUser()->is_admin)
                                    <div class="col">
                                        <h6 class="">Expected Revenue</h6>
                                        <p class="num-pt">{{ str_replace(["INR", ".00"], "", money_format("%i", $total_expected_revenue)) }}</p>
                                    </div>
                                    <div class="col">
                                        <h6 class="">Total Receivables</h6>
                                        <p class="num-pt">{{ str_replace(["INR", ".00"], "", money_format("%i", $total_income)) }}</p>
                                    </div>
                                
                                    <div class="col">
                                        <h6 class="">Total Balance</h6>
                                        <p class="num-pt">{{ str_replace(["INR", ".00"], "", money_format("%i", $total_expected_revenue - $total_income)) }}</p>
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
                                    <th>Project Name</th>
                                    @if(auth()->getUser()->is_admin)
                                        <th>Total Expected Revenue</th>
                                    @endif
                                    <th>Total Receivables</th>
                                    <th>Total Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $project)
                                    @php
                                        $exrev = $project->expected_revenue;
                                        $balance = $exrev - $project->transections()->where('type', 'income')->sum('amount');
                                        if (auth()->getUser()->is_admin) {
                                            $incomes = $project->transections()->where('type', 'income')->sum('amount');
                                        } else {
                                            $incomes = $project->transections()->where('type', 'income')->where('user_id', auth()->getUser()->id)->sum('amount');
                                        }
                                        
                                    @endphp
                                    @if(auth()->getUser()->is_admin)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td><span  class="cursor-pointer btn-modal" data-container=".transection_modal" data-href="{{ route('project.show', $project->id) }}">{{ $project->name}}</span></td>
                                        @if(auth()->getUser()->is_admin)
                                            <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $exrev)) }}</td>
                                        @endif
                                        <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $incomes)) }}</td>
                                        <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $balance)) }}</td>   
                                    </tr>
                                    @else
                                        @if($incomes) 
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td><span class="cursor-pointer btn-modal" data-container=".transection_modal" data-href="{{ route('project.show', $project->id) }}">{{ $project->name}}</span></td>
                                            @if(auth()->getUser()->is_admin)
                                                <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $exrev)) }}</td>
                                            @endif
                                            <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $incomes)) }} </td>
                                            <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $balance)) }}</td>   
                                        </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade transection_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>
</div>
@endsection