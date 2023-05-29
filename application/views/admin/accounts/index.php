<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat();?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('accounts_list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('accounts', 'can_add')) {?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm addaccount"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('add_account'); ?></a>
                            <?php }?>

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('accounts_list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>
                                        <th><?php echo 'Level'; ?> </th> 
                                        <th><?php echo 'Account No'; ?> </th> 
                                        <th><?php echo 'Account'. $this->lang->line('name'); ?> </th> 
                                        <th><?php echo $this->lang->line('date'); ?> </th>
                                        <th><?php echo 'Balance'; ?> </th> 
                                        <th><?php echo 'Account Type'; ?> </th> 
                                        <th><?php echo $this->lang->line('description'); ?> </th>
                                        <th><?php echo $this->lang->line('action'); ?> </th>
                                        <!-- <th class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?> </th> -->

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($accountslist)) { } else {
                                        foreach ($accountslist as $account) { ?>
                                            <tr>
                                                <td class="mailbox-name"> <?php echo $account["level_name"]; ?> </td>
                                                <td class="mailbox-name"> <?php echo $account["account_no"]; ?> </td>
                                                <td class="mailbox-name"> <?php echo $account["name"]; ?> </td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($account['date'])) ?></td>
                                                <td class="mailbox-name"> <?php echo $account["balance"]; ?>  </td>
                                                <td class="mailbox-name"><?php echo $account['account_type']; ?></td>
                                                <td class="mailbox-name"><?php echo $account['description']; ?></td>
                                                <td class="mailbox-date">
                                                    <?php if ($this->rbac->hasPrivilege('accounts', 'can_edit')) { ?>
                                                        <a  data-target="#myeditModal" onclick="edit(<?php echo $account['id']; ?>)"  class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('accounts', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/accounts/delete/<?php echo $account['id']; ?>', '<?php echo $this->lang->line('delete_message') ?>')" data-original-title="<?php echo $this->lang->line('delete') ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php } ?>


                                                </td>
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
</div><!-- /.content-wrapper -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add_account'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="add_account" class="ptt10" accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="row">
                                <?php if ($this->session->flashdata('msg')) {?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php }?>
                                <?php if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo 'Account No'; ?><small class="req"> *</small></label>
                                        <input id="account_no" name="account_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo 'Name'; ?><small class="req"> *</small></label>
                                        <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo 'Initial Balance'; ?><small class="req"> *</small></label>
                                        <input id="balance" name="balance" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />

                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo 'Account Type'; ?><small class="req"> *</small></label>
                                        <!-- <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" /> -->
                                        <select name="acc_type" id="acc_type" class="form-control" >
                                            <option value="Basic">Default - Basic</option>
                                            <option value="Assets">Assets - Assets</option>
                                            <option value="Expenses">Expenses - Expenses</option>
                                            <option value="Income">Income - Income</option>
                                            <option value="Liabilities">Liabilities - Liabilities</option>
                                            <option value="Equity">Equity - Equity</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo 'Select Level'; ?><small class="req"> *</small></label>
                                        <select name="level_id" id="level_id" class="form-control" >
                                            <option value="">-- Please Select --</option>
                                            <?php if($levelslist) { foreach($levelslist as $level){ ?>
                                                <option value="<?php echo $level['id']; ?>" ><?php echo $level['level_name']; ?> <?php echo $level['parent_name'] ?  '&nsbp;&nsbp;|| Parent: '. $level['parent_name'] : '' ?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                        <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('description'); ?></textarea>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="box-footer clear">
                                    <div class="pull-right">
                                        <button type="submit" id="add_accountbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit_account'); ?></h4>
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" id="edit_data">
                    </div>
                </div>
            </div>

        </div>
    </div>
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
</script>