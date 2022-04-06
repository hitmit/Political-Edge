<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">View Project: {{$project->name}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card ">
                        <div class="card-header">
                            <h6 class="card-title">Receivables</h6>
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
                                            <td>{{ str_replace(["INR", ".00"], "", money_format("%i", $income->amount)) }}</td>
                                            <td>{{ date("Y-m-d", strtotime($income->created_at)) }}</td>
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
</div>
