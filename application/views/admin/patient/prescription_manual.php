<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<style type="text/css">
    @media print {
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
            float: left;
        }
        .col-sm-12 {
            width: 100%;
        }
        .col-sm-11 {
            width: 91.66666667%;
        }
        .col-sm-10 {
            width: 83.33333333%;
        }
        .col-sm-9 {
            width: 75%;
        }
        .col-sm-8 {
            width: 66.66666667%;
        }
        .col-sm-7 {
            width: 58.33333333%;
        }
        .col-sm-6 {
            width: 50%;
        }
        .col-sm-5 {
            width: 41.66666667%;
        }
        .col-sm-4 {
            width: 33.33333333%;
        }
        .col-sm-3 {
            width: 25%;
        }
        .col-sm-2 {
            width: 16.66666667%;
        }
        .col-sm-1 {
            width: 8.33333333%;
        }
        .col-sm-pull-12 {
            right: 100%;
        }
        .col-sm-pull-11 {
            right: 91.66666667%;
        }
        .col-sm-pull-10 {
            right: 83.33333333%;
        }
        .col-sm-pull-9 {
            right: 75%;
        }
        .col-sm-pull-8 {
            right: 66.66666667%;
        }
        .col-sm-pull-7 {
            right: 58.33333333%;
        }
        .col-sm-pull-6 {
            right: 50%;
        }
        .col-sm-pull-5 {
            right: 41.66666667%;
        }
        .col-sm-pull-4 {
            right: 33.33333333%;
        }
        .col-sm-pull-3 {
            right: 25%;
        }
        .col-sm-pull-2 {
            right: 16.66666667%;
        }
        .col-sm-pull-1 {
            right: 8.33333333%;
        }
        .col-sm-pull-0 {
            right: auto;
        }
        .col-sm-push-12 {
            left: 100%;
        }
        .col-sm-push-11 {
            left: 91.66666667%;
        }
        .col-sm-push-10 {
            left: 83.33333333%;
        }
        .col-sm-push-9 {
            left: 75%;
        }
        .col-sm-push-8 {
            left: 66.66666667%;
        }
        .col-sm-push-7 {
            left: 58.33333333%;
        }
        .col-sm-push-6 {
            left: 50%;
        }
        .col-sm-push-5 {
            left: 41.66666667%;
        }
        .col-sm-push-4 {
            left: 33.33333333%;
        }
        .col-sm-push-3 {
            left: 25%;
        }
        .col-sm-push-2 {
            left: 16.66666667%;
        }
        .col-sm-push-1 {
            left: 8.33333333%;
        }
        .col-sm-push-0 {
            left: auto;
        }
        .col-sm-offset-12 {
            margin-left: 100%;
        }
        .col-sm-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-sm-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-sm-offset-9 {
            margin-left: 75%;
        }
        .col-sm-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-sm-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-sm-offset-6 {
            margin-left: 50%;
        }
        .col-sm-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-sm-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-sm-offset-3 {
            margin-left: 25%;
        }
        .col-sm-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-sm-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-sm-offset-0 {
            margin-left: 0%;
        }
        .visible-xs {
            display: none !important;
        }
        .hidden-xs {
            display: block !important;
        }
        table.hidden-xs {
            display: table;
        }
        tr.hidden-xs {
            display: table-row !important;
        }
        th.hidden-xs,
        td.hidden-xs {
            display: table-cell !important;
        }
        .hidden-xs.hidden-print {
            display: none !important;
        }
        .hidden-sm {
            display: none !important;
        }
        .visible-sm {
            display: block !important;
        }
        table.visible-sm {
            display: table;
        }
        tr.visible-sm {
            display: table-row !important;
        }
        th.visible-sm,
        td.visible-sm {
            display: table-cell !important;
        }
    }

    .printablea4{width: 100%;}
    .printablea4>tbody>tr>th,
    .printablea4>tbody>tr>td{padding:2px 0; line-height: 1.42857143;vertical-align: top; font-size: 12px;}
</style>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Prescription</title>
    </head>

    <div id="html-2-pdfwrapper">

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <?php if (!empty($print_details[0]['print_header'])) { ?>
                    <div class="pprinta4">
                        <img src="<?php
                            if (!empty($print_details[0]['print_header'])) {
                                echo base_url() . $print_details[0]['print_header'];
                            }
                            ?>" style="height:100px; width:100%;" class="img-responsive">
                        <div style="height: 10px; clear: both;"></div>
                    </div>
                <?php } else{ ?>
                    <br> <br> <br> <br> <br> <br>             <?php } ?>
                <div class="">
                    <?php $date = $result["appointment_date"];
                        $appointment_date = date("Y-m-d", strtotime($date));
                        ?>
                    <table width="100%" class="printablea4">
                        <tr>
                            <th><?php echo $this->lang->line(''); ?> <?php echo $result["presid"] ?></th> <td></td>
                            <th class="text-right"></th> 
                            <th class="text-right"><?php echo $this->lang->line('date'); ?> : <?php
                                if (!empty($result['appointment_date'])) {
                                    echo date($this->customlib->getSchoolDateFormat(true, false), strtotime($appointment_date));
                                }
                                ?>
                            </th>
                        </tr>
                    </table>
                    <hr style="height: 1px; border-top: 1px solid black; margin-bottom: 10px; margin-top: 10px" />
                    <table border = 0 width="100%" class="printablea4">
                        <tr>
                            <th><?php echo $this->lang->line("patient") . " " . $this->lang->line("id"); ?></th>
                            <td><?php echo $result["patient_unique_id"] ?></td>
                            <th><?php echo $this->lang->line("name"); ?></th>
                            <td><?php echo $result["patient_name"] ?></td>
                            <th><?php echo $this->lang->line("age"); ?></th>
                            <td style="display:flex"><?php
                                if (!empty($result["age"])) {
                                    echo $result["age"] . " " . $this->lang->line("year") . " ";
                                }if (!empty($result["month"])) {
                                    echo $result["month"] . " " . $this->lang->line("month");
                                }
                                ?>     
                                    <p style="margin: 0px 5px 0px 20px;"><b><?php echo $this->lang->line("email"); ?></b></p>
                                    <p><?php echo $result["email"] ?></p>               
                            </td>                  
                        </tr> 
                        <tr>                              
                            <th><br><?php echo $this->lang->line("gender"); ?></th>
                            <td><br><?php echo $result["gender"] ?></td> 
                            <th><br><?php echo 'Mobile No'; ?> </th>
                            <td><br><?php echo $result["mobileno"] ?></td>
                            <th><br><?php echo $this->lang->line("address"); ?></th>
                            <td><br><?php echo $result["address"] ?></td>
                        </tr>
                        <tr>
                            <th colspan="2"><br><?php echo $this->lang->line('consultant'); ?> <?php echo $this->lang->line(''); ?></th>
                            <th colspan="2"><br>Qualification</th>
                            <th colspan="2"><br>Specialization</th>
                        </tr>
                        <tr>
                            <td colspan="2"><?php echo $result["name"] . " " . $result["surname"] ?></td>  
                            <td colspan="2"><?php echo $result["qualification"] ?></td>
                            <td colspan="2" style="white-space: pre-wrap;word-break: break-word;"><?php echo $result["specialization"] ?></td>
                        </tr>
                    </table>
                    <hr style="height: 1px; border-top: 1px solid black; clear: both;margin-bottom: 10px; margin-top: 10px" />
                    <b>℞:-</b>
                    <!--<style>
.vl {
  border-left: 6px solid green;
  height: 500px;
}
</style>
</head>
<body>

<h2>Vertical Line</h2>

<div class="vl"></div> -->
 
                    <table align="right" border = 0 class="printablea4" >
                        <tr> <th padding:15px; style="text-align:right;">Temperature <?php echo isset($result['temperature']) && !empty($result['temperature']) ? '____________'.$result['temperature'].' F'.'______________' : '_____________________F'?> <br><br></th></tr>
                        <tr> <th style="text-align:right;">BP : <?php echo isset($result['bp']) && !empty($result['bp']) ? '____________'.$result['bp'].' mmHg'.'______________ ' : '__________________________mmHg'?><br><br> </th></tr>
                        <tr> <th style="text-align:right;">Pulse : <?php echo isset($result['pulse']) && !empty($result['pulse']) ? '____________'.$result['pulse'].' /min'.'______________' : '__________________________/min'?> <br><br></th></tr>
                        <tr> <th style="text-align:right;">SPO2 : <?php echo isset($result['spo2']) && !empty($result['spo2']) ? '____________'.$result['spo2'].' %'.'______________' : '__________________________%'?> <br><br> </th></tr>
                        <tr> <th style="text-align:right;">Weight : <?php echo isset($result['weight']) && !empty($result['weight']) ? '____________'.$result['weight'].' kg'.'______________': '__________________________kg'?><br><br></th></tr>
                        <tr> <th style="text-align:right;">Respiration : <?php echo isset($result['respiration']) && !empty($result['respiration']) ? '____________'.$result['respiration'].'______________' : '__________________________'?><br><br></th></tr>
                        <tr> <th style="text-align:right;">Investigations : _________________________ <br><br></th></tr>
                        <tr> <th style="text-align:right;">_________________________ <br><br></th></tr>
                    </table>
                    
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px" />

                    <!-- <table width="100%" class="printablea4"> 
                        <br><br><br><br><br><br><br><br><br><br><br>
                        <tr>
                            <th style="text-align:center;">براہ کرم دوبارہ چیک اپ کے لیے یہ پرچی اپنے ساتھ لائیں - شکریہ
</th>
                            <td style="margin-bottom: 0;"><?php echo $result["header_note"] ?></td>
                        </tr>
                    </table> -->
                </div>
            </div>
            <!--/.col (left) -->

        </div>
    </div>
    <p style=" position: absolute; bottom: 15px; left: 0; width: 100%; text-align: center;">براہ کرم دوبارہ چیک اپ کے لیے یہ پرچی اپنے ساتھ لائیں - شکریہ</p>	
    <br>
    <p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;"><?php echo $result["header_note"] ?></p>	

</html>
<div id="payslipview"  class="modal fade" role="dialog">

    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('details'); ?>   <span id="print"></span></h4>
            </div>
            <div class="modal-body" id="testdata">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">



    function delete_prescription(id, opdid,visitid='') {
        console.log(id);
        if (confirm('Are you sure')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/prescription/deletePrescription/' + id + '/' + opdid+'/'+visitid,
                success: function (res) {
                    window.location.reload(true);
                },
                error: function () {
                    alert("Fail")
                }
            });

        }
    }
</script>

