@extends('layouts.master')
@section('title')
    Political edge | Add Income
@endsection
@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Welcome to Polytical Edge Dashboard</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex"
                    id="dashboardDate">
                    <span class="input-group-addon bg-transparent"><i data-feather="calendar"
                            class=" text-primary"></i></span>
                    <input type="text" class="form-control">
                </div>

                <button type="button" class="btn btn-outline-primary btn-icon-text mr-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="printer"></i>
                    Print
                </button>

            </div>
        </div>


        <div class="row">
            <div class="col-12 col-xl-12 grid-margin stretch-card">
                <div class="card overflow-hidden add-row">
                    <div class="card-body">

                        <div class="row align-items-start mb-2">
                            <div class="col-md-7">
                                <h6 class="card-title mb-0">INCOME & EXPENSES CHART</h6>
                            </div>
                            <div class="col-md-5 d-flex justify-content-md-end">
                                <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-primary">Today</button>
                                    <button type="button" class="btn btn-outline-primary d-none d-md-block">Week</button>
                                    <button type="button" class="btn btn-primary">Month</button>
                                    <button type="button" class="btn btn-outline-primary">Year</button>
                                </div>
                            </div>
                        </div>
                        <div class="flot-wrapper">
                            <div id="flotChart1" class="flot-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->

        <div class="row">
            <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Monthly Expenses</h6>

                        </div>
                        <p class="text-muted mb-4">Expenses are activities related to selling or the number of goods
                            or services sold in a given time period.</p>
                        <div class="monthly-sales-chart-wrapper">
                            <canvas id="monthly-sales-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body add-row">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Profit & Loss</h6>

                        </div>
                        <div id="progressbar1" class="mx-auto"></div>
                        <div class="row mt-4 mb-3">
                            <div class="col-6 d-flex justify-content-end">
                                <div>
                                    <label
                                        class="d-flex align-items-center justify-content-end tx-10 text-uppercase font-weight-medium">Loss
                                        <span class="p-1 ml-1 rounded-circle bg-primary-muted"></span></label>
                                    <h5 class="font-weight-bold mb-0 text-right">15000</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="d-flex align-items-center tx-10 text-uppercase font-weight-medium"><span
                                            class="p-1 mr-1 rounded-circle bg-primary"></span> Profit</label>
                                    <h5 class="font-weight-bold mb-0">30000</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> <!-- row -->

        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-4">Profit & Loss Table</h6>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="pt-0">#</th>
                                        <th class="pt-0">Project Name</th>
                                        <th class="pt-0">Expenses</th>
                                        <th class="pt-0">Income</th>
                                        <th class="pt-0">Date & Time</th>
                                        <th class="pt-0">Profit & Loss</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>4Dhaam4Kaaam</td>
                                        <td>5000</td>
                                        <td>2000</td>
                                        <td>02/22/2022::5:04 PM</td>
                                        <td>+3000</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>4Dhaam4Kaaam</td>
                                        <td>5000</td>
                                        <td>2000</td>
                                        <td>02/22/2022::5:04 PM</td>
                                        <td>+3000</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>4Dhaam4Kaaam</td>
                                        <td>5000</td>
                                        <td>2000</td>
                                        <td>02/22/2022::5:04 PM</td>
                                        <td>+3000</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Total Profit & Loss</td>
                                        <td colspan="1" class="text-left font-weight-bold">₹9000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 



    </div>
@endsection
