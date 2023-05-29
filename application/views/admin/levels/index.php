<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat();?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('levels_list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('levels', 'can_add')) {?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm addlevel"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('add_level'); ?></a>
                            <?php }?>

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('levels_list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>
                                        <th><?php echo 'Level '. $this->lang->line('name'); ?> </th> 
                                        <th><?php echo 'Parent Level'; ?> </th> 
                                        <th><?php echo 'Status'; ?> </th> 
                                        <th><?php echo $this->lang->line('action'); ?> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($levelslist)) { } else {
                                        foreach ($levelslist as $level) { ?>
                                            <tr>
                                                <td class="mailbox-name"> <?php echo $level["level_name"]; ?> </td>
                                                <td class="text-left"> <?php echo $level["parent_name"] ? $level["parent_name"] : '- - -'; ?> </td>
                                                <td class="mailbox-name"> <?php echo $level["status"]== 1 ? 'Active' : 'Inactive'; ?>  </td>
                                                <td class="mailbox-date">
                                                    <?php if ($this->rbac->hasPrivilege('levels', 'can_edit')) { ?>
                                                        <a  data-target="#myeditModal" onclick="edit(<?php echo $level['id']; ?>)"  class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('levels', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/levels/delete/<?php echo $level['id']; ?>', '<?php echo $this->lang->line('delete_message') ?>')" data-original-title="<?php echo $this->lang->line('delete') ?>">
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
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add_level'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="add_level" class="ptt10" accept-charset="utf-8" enctype="multipart/form-data">
                                <?php if ($this->session->flashdata('msg')) {?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php }?>
                                <?php if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="row"> 
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo 'Parent Level'; ?></label>
                                            <!-- <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" /> -->
                                            <select name="parent_id" id="parent_id" class="form-control" >
                                                <option value="">Select Parent Level</option>
                                                <?php if($levelslist) { foreach($levelslist as $level){ ?>
                                                    <option value="<?php echo $level['id']; ?>"><?php echo $level['level_name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo 'Level Name'; ?><small class="req"> *</small></label>
                                            <input id="name" name="level_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />

                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer clear">
                                    <div class="pull-right">
                                        <button type="submit" id="add_levelbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
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
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit_level'); ?></h4>
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
        $("#add_level").on('submit', (function (e) {
            $("#add_levelbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/levels/add',
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
                    $("#add_levelbtn").button('reset');
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
            url: '<?php echo base_url(); ?>admin/levels/getDataByid/' + id,
            success: function (data) {
                $('#edit_data').html(data);
            },
            error: function () {
                alert("Fail")
            }
        });
    }


$(".addlevel").click(function(){
    $('#add_level').trigger("reset");
});
</script>