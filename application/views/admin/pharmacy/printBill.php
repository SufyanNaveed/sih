<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $this->lang->line('bill'); ?></title>
        <style type="text/css">
            .printablea4{width: 100%;}
            /*.printablea4 p{margin-bottom: 0;}*/
            .printablea4>tbody>tr>th,
            .printablea4>tbody>tr>td{padding:2px 0; line-height: 1.42857143;vertical-align: top; font-size: 12px;}
        </style>
    </head>
    <div id="html-2-pdfwrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="">
                    <?php if (!empty($print_details[0]['print_header'])) {
    ?>
                        <div class="pprinta4">
                            <img src="<?php
if (!empty($print_details[0]['print_header'])) {
        echo base_url() . $print_details[0]['print_header'];
    }
    ?>" class="img-responsive" style="height:100px; width: 100%;">
                        </div>
                    <?php }?>
                    <table width="100%" class="printablea4">
                        <tr>
                            <td align="text-left"><h5><?php echo $this->lang->line('bill') . " #"; ?><?php echo $result["bill_no"] ?></h5>
                            </td>
                            <td align="right"><h5><?php echo $this->lang->line('date') . " : "; ?><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['date'])) ?></h5>
                            </td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" cellspacing="0" cellpadding="0" width="100%" border="0">
                        <tbr>
                            <th width="20%"><?php echo $this->lang->line('name'); ?></th>
                            <td width="25%"><?php echo $result["patient_name"]; ?></td>
                            <th width="25%"><?php echo $this->lang->line('doctor'); ?></th>
                            <td width="30%" align="left"><?php echo $result["doctor_name"]; ?></td>
                        </tr>

                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" id="testreport" width="100%" border="0">
                        <tr>
                            <th width="80%"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('name'); ?></th>

                           <!-- <th><?php echo $this->lang->line('batch') . " " . $this->lang->line('no'); ?>-->
                            <!-- <th><?php echo $this->lang->line('unit'); ?></th></th> -->
                            <!-- <th><?php echo $this->lang->line('expire') . " " . $this->lang->line('date'); ?></th> -->
                            <th style="text-align: left;"><?php echo $this->lang->line('qty'); ?></th>
                            
                            <!--<th style="text-align: left;"><?php echo $this->lang->line('sale') . " " . $this->lang->line('price') . ' (' . $currency_symbol . ')'; ?></th> -->

                            <th style="text-align: center;"><?php echo $this->lang->line('sale') . " " . $this->lang->line('price'); ?></th>
                            <th style="text-align: right;"><?php echo $this->lang->line('amt'); ?></th>
                        </tr>
                        <?php
$j = 0;
foreach ($detail as $bill) {
    ?>
                            <tr>
                                <td width="20%"><?php echo $bill["medicine_name"]; ?></td>
                               <!-- <td><?php echo $bill["batch_no"]; ?></td> -->
                                <!-- <td><td><?php echo $bill["unit"]; ?></td> -->
                               <!-- <td><?php echo $bill['expire_date']; ?></td> -->
                                <td align="left"><?php echo $bill["quantity"]; ?></td>
                                <td align="center"><?php echo $bill["sale_price"]; ?></td>
                                <td align="right"><?php echo $bill["amount"]; ?></td>
                            </tr>
                            <?php
$j++;
}
?>
<!--                         <tr>
            <td></td><td></td><td></td>
            <th><?php echo $this->lang->line('total'); ?></th>

            <td><?php echo $currency_symbol . "" . $result["total"]; ?></td>
        </tr> -->
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">

                    <table align="" class="printablea4" style="width: 40%; float: right;">
                        <?php if (!empty($result["total"])) {?>
                            <tr>

                                <!--<th style="width: 80%;"><?php echo $this->lang->line('total') . " (" . $currency_symbol . ")"; ?></th> -->
                                <th style="width: 80%;"><h4><b><?php echo $this->lang->line('total')?></b></h4></b>
                                <td align="right" ><h4><b><?php echo $result["total"]; ?></b></h4></td>
                            </tr>
                        <?php }?>
                        <!--
                        <?php if (!empty($result["discount"])) {
    ?>
                            <tr>
                                <th><?php
echo $this->lang->line('discount') . " (" . $currency_symbol . ")";

    ?></th>

                                <td align="right"><?php echo $result["discount"]; ?></td>

                            </tr>
                        <?php }?>
                        <?php if (!empty($result["tax"])) {
    ?>
                            <tr>
                                <th><?php
echo $this->lang->line('tax') . " (" . $currency_symbol . ")";

    ?></th>

                                <td align="right"><?php echo $result["tax"]; ?></td>

                            </tr>
                        <?php }?>
                        <?php
if ((!empty($result["discount"])) && (!empty($result["tax"]))) {
    if (!empty($result["net_amount"])) {
        ?>
                                <tr>
                                    <th><?php
echo $this->lang->line('net_amount') . " (" . $currency_symbol . ")";

        ?></th>

                                    <td align="right"><?php echo $result["net_amount"]; ?></td>

                                </tr>
                                <?php
}
}
?> -->
                        <?php if (!empty($result["note"])) {?>
                            <tr>

                                <th><?php echo $this->lang->line('note'); ?></th>

                                <td align="right"><?php echo $result["note"]; ?></td>
                            </tr>
                        <?php }?>
                        <?php if (($print) != 'yes') {?>
                            <tr id="generated_by">

                                <th><?php echo $this->lang->line('collected_by'); ?></th>

                                <td align="right"><?php echo $result["name"] . " " . $result["surname"]; ?></td>
                            </tr>
                        <?php }?>
                    </table>

                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <p><?php
if (!empty($print_details[0]['print_footer'])) {
    echo $print_details[0]['print_footer'];
}
?></p>
                </div>
            </div>
            <!--/.col (left) -->
        </div>
    </div>
</html>
<script type="text/javascript">
    function delete_bill(id) {
        if (confirm('<?php echo $this->lang->line('delete_conform') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/pharmacy/deletePharmacyBill/' + id,
                success: function (res) {
                    successMsg('<?php echo $this->lang->line('delete_message'); ?>');
                    window.location.reload(true);
                },
                error: function () {
                    alert("Fail")
                }
            });
        }
    }
    function printData(id) {

        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/pharmacy/getBillDetails/' + id,
            type: 'POST',
            data: {id: id, print: 'yes'},
            success: function (result) {
                // $("#testdata").html(result);
                popup(result);
            }
        });
    }

    function popup(data)
    {
        var base_url = '<?php echo base_url() ?>';
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }
</script>