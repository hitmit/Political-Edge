   <!-- add progress modal -->
   <div class="modal fade" id="addprogress" tabindex="-1" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-lg">
       <div class="modal-content">
           <form class="forms-sample" action="{{ route('employee-transaction.store') }}" method="POST">
               <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Add Progress</h5>
               </div>
               <div class="modal-body">

                   @csrf
                   <div class="form-group">
                       <label for="exampleInputDate">Date</label>
                       <input type="hidden" name="project_id" id="project_id" >
                       <input type="date" id="date"
                           class="form-control @error('date') is-invalid @enderror" name="date"
                           value="{{ date('Y-m-d') }}">
                       <span class="text-danger date_err">
                       </span>
                   </div>

                   <div class="form-group">
                       <label for="progress_data">Booths Completed</label>
                       <input type="number" id="progress_data"
                           class="form-control @error('progress_data') is-invalid @enderror"
                           name="progress_data" value="{{ old('progress_data') }}">
                       <span class="text-danger error-text progress_err"></span>
                   </div>

                   <h5 style="text-align: center" class="modal-title">Expense</h5>
                   <div class="form-group">
                       <label for="category">Category</label>
                       <table class="table">
                           @foreach ($categories as $key => $category)
                               <tr>
                                   <td>
                                        <input type="hidden" name="expense_category[]" id="expense_category"
                                           style="border: none" readonly
                                           value="{{ $category->id }}">{{ $category->category }}
                                    </td>

                                   <td style="width: 50%;  padding-bottom: 5px;">
                                        <input type="number" name="expense_amount[{{ $category->id }}]" 
                                              id={{strtolower($category->category)}}
                                           placeholder="Enter amount." title="Amount" class="form-control">
                                   </td>
                               </tr>
                           @endforeach
                           
                       </table>
                       <div id="remark_div" style="display:none;">
                            <label for="remark">Add Remark</label>
                            <textarea name="remark" placeholder="Write about misc remark" class="form-control" id="remark" cols="30" rows="5"></textarea>
                       </div>
                   </div>

                   <h5 style="text-align: center" class="modal-title">Advance</h5>
                   <div class="form-group">
                       <label for="category">By Whom</label>
                       <select name="user_id" id="user_id" class="form-control">
                           @foreach ($users as $user)
                               <option value="{{ $user->id }}">{{ $user->name }}</option>
                           @endforeach
                       </select>
                       <span class="text-danger  user_id_err"></span>
                   </div>

                   <div class="form-group">
                       <label for="amount_income">Amount</label>
                       <input type="number" id="amount_income" class="form-control" name="amount"
                           placeholder="Amount.">
                       <span class="text-danger amount_income_err"></span>
                   </div>
               </div>
               <div class="modal-footer">
                   <button type="submit" id="submitProgress" class="btn btn-primary mr-2">Submit</button>
                   <button type="button" onclick="$('#addprogress').modal('hide');" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               </div>
           </form>
       </div>
   </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            $("#misc").on('keyup', function () {
                $("#remark_div").show();
            });  
            $(document).on('click',"#add_details",function () { 
                var project_id = $(this).data('id');
                $("#project_id").val(project_id);
            })
        });
    </script>
@endpush