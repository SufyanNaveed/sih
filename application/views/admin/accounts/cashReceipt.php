<div class="content-wrapper">
    <section class="content">
    <div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="box-header with-border">
                    <h4> Cash Receipt </h4>
                </div>
            </div>
            <div class="panel-body">
                <form id="add_transaction" class="ptt10" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="vo_no" class="col-sm-2 col-form-label"><?php echo 'Voucher No'; ?></label>
                        <div class="col-sm-4">
                             <input type="text" name="txtVNo" id="txtVNo" value="<?php if(!empty($voucher_no[0]['voucher'])){
                               $vn = substr($voucher_no[0]['voucher'],3)+1;
                              echo $voucher_n = 'CR-'.$vn;
                             }else{
                               echo $voucher_n = 'CR-1';
                             } ?>" class="form-control" readonly>
                        </div>
                    </div> 
                    
                    <div class="form-group row">
                        <label for="date" class="col-sm-2 col-form-label"><?php echo 'Date'?><i class="text-danger">*</i></label>
                        <div class="col-sm-4">
                             <input type="date" name="dtpDate" id="dtpDated" class="form-control datepicker" value="<?php  echo date('Y-m-d');?>" required>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="payment_type" class="col-sm-2 col-form-label"> Payment Type <i class="text-danger">*</i></label>
                        <div class="col-sm-4">
                            <select name="paytype" class="form-control" required="" onchange="bank_paymet(this.value)" tabindex="3">
                                <option value="">Please Select</option>
                                <option value="1" selected>Cash Payment</option>
                                <option value="2" disabled>Bank Payment</option> 
                            </select> 
                        </div> 
                    </div>

                       
                    <div class="form-group row" >
                        <label for="bank" class="col-sm-2 col-form-label"> From Account</label>
                        <div class="col-sm-4">
                            <select name="from_bank_id" class="form-control bankpayment" id="from_bank_id">
                                <option value="">Select Account</option> 
                                <?php if($accounts){ foreach($accounts as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>" data-code="<?php echo $value['account_no']; ?>"><?php echo $value['account_no'].'&nbsp;&nbsp;&nbsp;'.$value['name']; ?></option>
                                <?php } } ?>
                            </select> 
                        </div> 
                    </div>
                    <input type="hidden" name="fromtxtCode" value="" id="txtCode" >

                    
                    <div class="form-group row">
                        <label for="txtRemarks" class="col-sm-2 col-form-label"><?php echo 'Remarks'?></label>
                        <div class="col-sm-4">
                          <textarea  name="txtRemarks" id="txtRemarks" class="form-control"></textarea>
                        </div>
                    </div> 
                   
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="debtAccVoucher"> 
                            <thead>
                                <tr>
                            <th class="text-center">Account Name<i class="text-danger">*</i></th>
                            <th class="text-center">Account No</th>
                            <th class="text-center">Debit<i class="text-danger">*</i></th>
                            <th class="text-center">Credit<i class="text-danger">*</i></th>
                                        
                                </tr>
                            </thead>
                            <tbody id="debitvoucher">
                                
                                <tr>
                                    <td class="" width="300">  
                                        <select name="to_bank_id" id="to_bank_id" class="form-control" required>
                                            <option value="">Select Account</option>
                                            <?php if($accounts){ foreach($accounts as $key => $value) { ?>
                                                <option value="<?php echo $value['id']; ?>" data-code="<?php echo $value['account_no']; ?>"><?php echo $value['name']; ?></option>
                                            <?php } } ?> 
                                        </select>

                                        </td>
                                    <td><input type="text" name="txtCode" value="" class="form-control "  id="txtCode_1" readonly=""></td>
                                    <td><input type="number" name="debitAmount" value="" class="form-control total_price text-right"  id="txtAmount_1" ></td>
                                    <td><input type="number" name="creditAmount" value="" class="form-control total_price text-right"  id="txtAmount_2" ></td>
                                                
                                </tr>                              
                            
                            </tbody>                               
                            <tfoot>
                                <tr>
                                    <td >

                                    </td>
                                    <td colspan="1" class="text-right"><label  for="reason" class="  col-form-label"><?php echo 'total' ?></label>
                                        </td>
                                    <td class="text-right">
                                        <input type="text" id="grandTotal" class="form-control text-right " name="grand_total" value="" readonly="readonly" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-group row">
                        
                        <div class="col-sm-12 text-right">

                            <button type="submit" id="add_transactionbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>
    </section><!-- /.content -->
</div>

<script>
var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';
$('#dtpDate').datepicker({

    format: date_format, 
    autoclose: true
});

$(document).ready(function () {
    $('#to_bank_id').on('change', function () {
        var code = $('option:selected', this).attr('data-code');
        console.log(code);
        $('#txtCode_1').val(code);
    });

    $('#from_bank_id').on('change', function () {
        var code = $('option:selected', this).attr('data-code');
        console.log(code);
        $('#txtCode').val(code);
    });
});

$(document).ready(function (e) {
        $("#add_transaction").on('submit', (function (e) {
            $("#add_transactionbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/accounts/create_bank_recieve',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#add_transactionbtn").button('reset');
                },
                error: function () {
                    alert("Fail")
                }
            });
        }));
    });
</script>