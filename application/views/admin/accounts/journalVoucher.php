<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat();?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"> <?php echo 'Journal Voucher List'; ?></h3>
                        
                    </div>
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('accounts_list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>
                                        <th><?php echo 'Voucher No'; ?> </th> 
                                        <th><?php echo 'Account No'; ?> </th> 
                                        <th><?php echo 'Account Name'; ?> </th> 
                                        <th><?php echo 'Date'; ?> </th> 
                                        <th><?php echo 'Payment Type'; ?> </th> 
                                        <th><?php echo 'Debit'; ?> </th> 
                                        <th><?php echo 'Credit'; ?> </th>
                                        <th><?php echo 'Narration'; ?> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($transactionslist)) { } else {
                                        foreach ($transactionslist as $transaction) { ?>
                                            <tr>
                                                <td class="mailbox-name"> <?php echo $transaction["VNo"]; ?> </td>
                                                <td class="mailbox-name"> <?php echo $transaction["account_no"]; ?> </td>
                                                <td class="mailbox-name"> <?php echo $transaction["name"]; ?> </td>
                                                <td class="mailbox-name"> <?php echo $transaction["VDate"]; ?> </td>
                                                <td class="mailbox-name"><?php echo $transaction['paytype'] == 1 ? 'Cash' : 'Bank'; ?></td>
                                                <td class="mailbox-name"> <?php echo $transaction["Debit"]; ?>  </td>
                                                <td class="mailbox-name"> <?php echo $transaction["Credit"]; ?>  </td>
                                                <td class="mailbox-name"><?php echo $transaction['Narration']; ?></td>
                                                
                                            </tr>
                                        <?php }
                                    } ?> 
                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>

    </section><!-- /.content -->
</div> 



<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';

        // var capital_date_format=date_format.toUpperCase();
        //         $.fn.dataTable.moment(capital_date_format);

        $('#date').datepicker({

            format: date_format,
            endDate: '+0d',
            autoclose: true
        });

        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });

    });

    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });

    $(document).ready(function (e) {
        $("#add_account").on('submit', (function (e) {
            $("#add_accountbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/accounts/add',
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
                    $("#add_accountbtn").button('reset');
                },
                error: function () {
                    alert("Fail")
                }
            });
        }));
    });

    function edit(id) {
        $('#myModaledit').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/accounts/getDataByid/' + id,
            success: function (data) {
                $('#edit_data').html(data);
            },
            error: function () {
                alert("Fail")
            }
        });
    }


$(".addaccount").click(function(){
    $('#add_account').trigger("reset");
});


$('#level_id').change(function(){
    var level_no = $('option:selected', this).attr('data-level-no');
    console.log(level_no);
    $('#level_no').val(level_no);
});
</script>