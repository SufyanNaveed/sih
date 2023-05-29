
<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat();?>
<form   id="edit_leveldata" class="ptt10"   accept-charset="utf-8" enctype="multipart/form-data">
    <div class="row">
        <?php if ($this->session->flashdata('msg')) {?>
            <?php echo $this->session->flashdata('msg') ?>
        <?php }?>
        <?php if (isset($error_message)) {
            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
        }?>
        <?php echo $this->customlib->getCSRF(); ?> 

        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo 'Parent Level'; ?></label>
                <!-- <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" /> -->
                <select name="parent_id" id="parent_id" class="form-control" >
                    <option value="">Select Parent Level</option>
                    <?php if($levelslist) { foreach($levelslist as $row){ ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $level['parent_id'] == $row['id'] ? 'selected': ''; ?>><?php echo $row['level_name']; ?></option>
                    <?php } } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo 'Level Name'; ?><small class="req"> *</small></label>
                <input id="level_name" name="level_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name', $level['level_name']); ?>" />

            </div>
        </div> 
    </div>
    <input id="level_id" type="hidden"  name="level_id" value="<?php echo $level['id']; ?>" />
    <div class="row">
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="edit_leveldatabtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
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
        $("#edit_leveldata").on('submit', (function (e) {
            $("#edit_leveldatabtn").button('loading');
            var id = $("#level_id").val();
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/levels/edit/' + id,
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
                    $("#edit_leveldatabtn").button('reset');
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
