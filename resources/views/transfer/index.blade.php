@extends('layouts.master')
@section('title')
    Clever App | Transfer amount
@endsection
@section('content')
    <div class="page-content">
        @include('include/error')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card add-row">
                    <div class="card-body">
                        <h6 class="card-title">Transfer amount</h6>
                        <div class="table-responsive my-2">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Receiver</th>
                                        <th>Amount Sent</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transfers as $transfer)
                                        <tr>
                                            <td>{{ $transfer->receiver()->first()->name }}</td>
                                            <td>&#8377; {{ $transfer->amount_send }}</td>
                                            <td>{{ $transfer->created_at->format('m/d/Y') }}</td>
                                        </tr>
                                    @endforeach
                                    @if ($transfers->isEmpty())
                                        <tr colspan="3">
                                            <td>No record round</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $transfers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
