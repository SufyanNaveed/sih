
<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat();?>
<form   id="edit_accountdata" class="ptt10"   accept-charset="utf-8" enctype="multipart/form-data">
    <div class="row">
        <?php if ($this->session->flashdata('msg')) {?>
            <?php echo $this->session->flashdata('msg') ?>
        <?php }?>
        <?php if (isset($error_message)) {
            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
        }?>
        <?php echo $this->customlib->getCSRF(); ?>
        
        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo 'Account No'; ?><small class="req"> *</small></label>
                <input id="account_no" name="account_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name', $account['account_no']); ?>" />
                <span class="text-danger"><?php echo form_error('name'); ?></span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?><small class="req"> *</small></label>
                <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name', $account['name']); ?>" />
                <input id="account_id" type="hidden" class="form-control"  value="<?php echo $account['id']; ?>" />
                <span class="text-danger"><?php echo form_error('name'); ?></span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo 'Select Level'; ?><small class="req"> *</small></label>
                <select name="level_id" id="level_id" class="form-control" >
                    <option value="">-- Please Select --</option>
                    <?php if($levelslist) { foreach($levelslist as $row){ ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $account['level_id'] == $row['id'] ? 'selected': ''; ?>><?php echo $row['level_name']; ?> <?php echo $row['parent_name'] ? '        || Parent: '. $row['parent_name'] : '' ?></option>
                    <?php } } ?>
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('description'); ?><?php echo set_value('description', $account['description']) ?></textarea>
                <span class="text-danger"><?php echo form_error('description'); ?></span>
            </div>
        </div><!-- /.box-body -->
    </div>
    <div class="row">
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="edit_accountdatabtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $('.filestyle').dropify();
    });
</script>
<script type="text/javascript"> $(document).ready(function (e) {
        $("#edit_accountdata").on('submit', (function (e) {
            $("#edit_accountdatabtn").button('loading');
            var id = $("#account_id").val();
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/accounts/edit/' + id,
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
                    $("#edit_accountdatabtn").button('reset');
                },
                error: function () {
                    alert("Fail")
                }
            });
        }));
    });
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';
        $('#editdate').datepicker({

            format: date_format,
            endDate: '+0d',
            autoclose: true
        });
    });
</script>
