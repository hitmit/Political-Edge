@extends('layouts.master')
@section('title')
    Clever App | Manage Expenses
@endsection
@section('content')
    <div class="page-content">
        @include('include/error')
         
         @if (auth()->user()->role == 'admin')
        <div class="row mb-4">
            
            <div class="col-md-6">
                <div class="card add-row">
                    <form action="{{ route('expenses.index') }}" method="GET">
                        <div class="card-body">
                            <div class="row">
                            
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control ">
                                    <option value="">--Select category--</option>
                                    @foreach ($categorys as $category)
                                        @if (request()->has('category') && request('category') == $category->id)
                                            <option selected value="{{ $category->id }}">
                                            @else
                                            <option value="{{ $category->id }}">
                                        @endif
                                        {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div></div>
                            
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="start data">Start Date</label>
                                <input type="date" value="{{ request('start_date') ? request('start_date') : '' }}"
                                    name="start_date" class="form-control ">
                            </div></div>
                            
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="start data">End Date</label>
                                <input type="date" value="{{ request('end_date') ? request('end_date') : '' }}"
                                    name="end_date" class="form-control ">
                            </div></div>
                            
                            <div class="col-md-12">
                            <div class="card-footer text-center">
                                <input type="submit" value="Filter" class="btn btn-primary ">
                                <a href="{{ route('expenses.index') }}" class="btn btn-danger">Reset
                                    Filter</a>
                                <input type="submit" name="export" value="Export" class="btn btn-success">
                            </div></div>
                            
                            
                            </div>
                        </div>
                    </form>
                </div>
            </div>
           
            <div class="col-md-6">
                <div class="card add-row">
                    <div class="card-body">
                        <div id="piechart" style="width: 500px; height: 220px;"></div>
                    </div>
                </div>
            </div>
           
        </div>
 @endif
        
         <div class="row mb-4" id="user{{ auth()->user()->id }}">
            <div class="col-md-12">
                <div class="card add-row">
                    <form action="{{ route('expenses.index') }}" method="GET">
                        <div class="card-body">
                            <div class="row">
                            
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control ">
                                    <option value="">--Select category--</option>
                                    @foreach ($categorys as $category)
                                        @if (request()->has('category') && request('category') == $category->id)
                                            <option selected value="{{ $category->id }}">
                                            @else
                                            <option value="{{ $category->id }}">
                                        @endif
                                        {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div></div>
                            
                            <div class="col-md-2">
                            <div class="form-group">
                                <label for="start data">Start Date</label>
                                <input type="date" value="{{ request('start_date') ? request('start_date') : '' }}"
                                    name="start_date" class="form-control ">
                            </div></div>
                            
                            <div class="col-md-2">
                            <div class="form-group">
                                <label for="start data">End Date</label>
                                <input type="date" value="{{ request('end_date') ? request('end_date') : '' }}"
                                    name="end_date" class="form-control ">
                            </div></div>
                            
                            <div class="col-md-4 text-center">
                            <label for="start data" class="mar-15"></label><br/>
                                <input type="submit" value="Filter" class="btn btn-primary ">
                                <a href="{{ route('expenses.index') }}" class="btn btn-danger">Reset
                                    Filter</a>
                                <input type="submit" name="export" value="Export" class="btn btn-success">
                            </div>
                            
                            
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

       
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Manage Expenses <a href="{{ route('expenses.create') }}"
                                class="add-element btn btn-primary">Add Expenses</a> </h6>


                        <div class="table-responsive my-2">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        {{-- <th>Sr.no</th> --}}
                                        <th>Username</th>
                                        <th>Category Name</th>
                                        <th>Expenses</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td>{{ $expense->user()->first()->name }}</td>
                                            <td>{{ $expense->category()->first()->name }}</td>
                                            <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $expense->amount)) }}</td>
                                            <th>{{ $expense->remark }}</th>
                                            <td>{{ $expense->date }}</td>
                                            <td>
                                                <a href="{{ route('expenses.edit', $expense->id) }}"
                                                    class="edit btn btn-primary"><i class="fa fa-pencil"
                                                        aria-hidden="true"></i></a>

                                                <form class="my-2"
                                                    action="{{ route('expenses.destroy', $expense->id) }}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure want to delete')"
                                                        class="delete btn btn-danger"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($expenses->isEmpty())
                                        <tr colspan="6">
                                            <td> No expense founds</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $expenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('chartJs')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Category', 'Amount'],
                <?php echo $chartData;?>
            ]);

            var options = {
                title: 'My Daily Activities'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
@endpush
