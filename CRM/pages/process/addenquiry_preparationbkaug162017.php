<?php
if (isset($_REQUEST['enquiryid'])) {
    $thispageeditid = 32;
} else {
    $thispageaddid = 32;
}
$collapse = '1';
$menu = "4,6,,";
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';
include ('../../require/header.php');
include_once "../master/uploadimage.php";
$getmanuf = $db->prepare("SELECT * FROM `purchase_enquiry` ORDER BY `PoID` DESC");
$getmanuf->execute();
$lst = $getmanuf->fetch(PDO::FETCH_ASSOC);



if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    //print_r($_REQUEST);exit;
    $_SESSION['enquiryid'] = $_REQUEST['enquiryid'];
    $id = $_REQUEST['enquiryid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    //   $msg = addpurchaseEnquiry($invno, $billdate, $taxtype, $netpayamt, $subtotal, $subtaxtotal, $Item_name,$suppliergird,  $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $id);
    $msg = addpurchaseEnquiry($invno, $billdate, $taxtype, $netpayamt, $subtotal, $subtaxtotal, $Item_name, $suppliergird, $Qty, $Pack_UOM, $Pack_qty, $Item_UOM, $Total_Qty, $Pack_Rate, $Item_Rate, $tax, $Taxable_Amt, $Net_Amt, $Tax_Amt, $purchase_detailid, $ip, $deliveryterms, $modeofshipment, $enquirycurrency, $modeofpayment, $paymentterms, $enquirytype, $vessel, $salesrep, $CusID, $id);
}
if ($lst['PoID'] == '' || $lst['PoID'] == '0') {
    $val = 1;
    $purid = 'EOI' . str_pad(1, 8, '0', STR_PAD_LEFT);
} else {
    $val = $lst['PoID'] + 1;
    $purid = 'EOI' . str_pad($val, 8, '0', STR_PAD_LEFT);
}
?>
<!-- Content Wrapper. Contains page content -->
<style>

    #normalexamples1 tbody tr td:nth-child(1),tbody tr td:nth-child(6){
        text-align:center;
    }

    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(5){
        text-align:center;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    #customFields td { padding: 0 !important; }

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Enquiry  
            <small><?php
                if ($_REQUEST['enquiryid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Enquiry</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-money"></i> Process</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Master(s)</a></li>
            <li><a href="<?php echo $sitename; ?>items/enquiry_preparation.htm"><i class="fa fa-circle-o"></i>Enquiry</a></li>
            <li class="active"><?php
                if ($_REQUEST['enquiryid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Enquiry</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        if ($_REQUEST['enquiryid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Enquiry</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Order Information
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <label>Enquiry No<span style="color:#FF0000;">*</span>
                                    </label>
                                    <input type="text" readonly class="form-control" placeholder="Enter the P.O No" name="invno" id="invno" required="required" value="<?php
                                    if ($_REQUEST['enquiryid'] != '') {
                                        echo getpurchaseEnquiry('PONumber', $_REQUEST['enquiryid']);
                                    } else {
                                        echo $purid;
                                    }
                                    ?>" />
                                </div>
                                <div class="col-md-3">
                                    <label>Enquiry Date<span style="color:#FF0000;"> *</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right usedatepicker" name="billdate" required="required"  value="<?php
                                        if (isset($_REQUEST['enquiryid']) && ( date('d-m-Y', strtotime(getpurchaseEnquiry('PODate', $_REQUEST['enquiryid']))) != '01-01-1970')) {
                                            echo date('d-m-Y', strtotime(getpurchaseEnquiry('PODate', $_REQUEST['enquiryid'])));
                                        }
                                        ?>" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Tax Type <span style="color:#FF0000;"> *</span>
                                    </label>
                                    <select name="taxtype" id="taxtype" class="form-control" onchange="univaerselcha()">
                                        <option value="0" <?php
                                        if (getpurchaseEnquiry('TaxType', $_REQUEST['enquiryid']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>No Tax</option>
                                        <option value="1" <?php
                                        if (getpurchaseEnquiry('TaxType', $_REQUEST['enquiryid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Inclusive Tax</option>
                                        <option value="2" <?php
                                        if (getpurchaseEnquiry('TaxType', $_REQUEST['enquiryid']) == '2') {
                                            echo 'selected';
                                        }
                                        ?>>Excluded Tax</option>
                                    </select>
                                </div>
                                <div class="col-md-3" id="suppliermode" >
                                    <label>Customer Name<span style="color:#FF0000;">*</span></label>
                                    <div class="input-group date">
                                        <input type="text" readonly class="form-control"  name="customer" required="required" value="<?php echo getcustomer('Person', getpurchaseEnquiry('CusID', $_REQUEST['enquiryid'])); ?>"/>
                                        <div class="input-group-addon">
                                            <i class="fa fa-search" onclick="loadgrid('ALL')" aria-hidden="true" data-toggle="modal" data-target="#myModal"></i>
                                        </div>
                                    </div>
                                </div>
                                <div  style="display:none" id="supplierpanel">
                                    <input type="hidden" class="form-control"  name="CusID" id="CusID" required="required"value="<?php echo getpurchaseEnquiry('CusID', $_REQUEST['enquiryid']); ?>"  />                   <div class="col-md-3" >
                                        <label>Customer Name</label>

                                        <div class="input-group date">
                                            <input type="text" readonly class="form-control"  name="customer" id="customer" required="required" value="" />

                                            <input type="hidden" class="form-control"  name="supplierprimary" id="supplierprimary" required="required"value=""  />
                                            <div class="input-group-addon">
                                                <i class="fa fa-search" onclick="loadgrid()" aria-hidden="true" data-toggle="modal" data-target="#myModal"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" >
                                        <div class="col-md-3">
                                            <img style="padding-bottom:10px;" height="100" id="supp_logeo" />
                                        </div>
                                        <div class="col-md-9" >
                                            <label style="display: block !important ; font-size:20px;" id="compa_name"><?php echo getcustomer('Company', getpurchaseEnquiry('CusID', $_REQUEST['enquiryid'])); ?></label>
                                            <label style="display: block !important ;" id="supp_code">Supplier_code</label>
                                            <label style="display: block !important ;  font-weight:400  !important ;" id="supp_address"><?php echo getcustomer('Address_1', getpurchaseEnquiry('CusID', $_REQUEST['enquiryid'])); ?></label>
                                            <label style="display: block !important ; font-weight:400  !important ;" id="supp_state"><?php echo getcustomer('State', getpurchaseEnquiry('CusID', $_REQUEST['enquiryid'])); ?></label>
                                            <label style="display: block !important ; font-weight:400  !important ;" id="supp_city"><?php echo getcustomer('City', getpurchaseEnquiry('CusID', $_REQUEST['enquiryid'])); ?></label>
                                            <label style="display: block !important ; font-weight:400  !important ;" id="supp_county"><?php echo getcustomer('Country', getpurchaseEnquiry('CusID', $_REQUEST['enquiryid'])); ?></label>
                                            <label style="display: block !important ; font-weight:400  !important ;" id="supp_postcode"><?php echo getcustomer('Postcode   ', getpurchaseEnquiry('CusID', $_REQUEST['enquiryid'])); ?></label>
                                        </div>
                                    </div>
                                </div><br/>
                            </div>
                        </div><br/>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Item Details
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="customFieldss">
                                    <thead>
                                        <tr valign="top">
                                            <th style="width:20%">Items</th>
                                            <th style="width:17%">Supplier Name</th> 
                                            <th style="width:7% ">Qty</th>
                                            <th style="width:5% ">P.UOM</th>
                                            <th style="width:5% ">per</th>
                                            <th style="width:5% ">I.UOM</th>
                                            <th style="width:5% ">Tot&nbsp;Qty</th> 
                                            <th style="width:7% ">P.Rate(<i class="fa fa-inr"></i>)</th>
                                            <th style="width:7% ">I.Rate(<i class="fa fa-inr"></i>)</th>
                                            <th style="width:10%">Tax</th>
                                            <th style="width:1%">Taxable&nbsp;Amt</th>
                                            <th style="width:5%">Tax&nbsp;Amt</th>
                                            <th style="width:6%">Nett..(<i class="fa fa-inr"></i>)</th> 
                                            <th style="width:2%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="customFields">
                                        <?php
                                        if ($_REQUEST['enquiryid'] != '') {

                                            $getponumber = getpurchaseEnquiry('PONumber', $_REQUEST['enquiryid']);
                                            $getitemvalue = $db->prepare("SELECT * FROM `purchase_enquiry_details` WHERE `PoNum` = ? AND `PoID` =?");
                                            $getitemvalue->execute(array($getponumber, $_REQUEST['enquiryid']));
                                            $i = '1';
                                            while ($fdepart = $getitemvalue->fetch()) {
                                                $key = 'up' . $i;
                                                ?>
                                                <tr valign = "top" id="datarow<?php echo $key; ?>">
                                                    <td>
                                                        <input type="hidden" name="purchase_detailid[]" id="purchase_detailid<?php echo $key; ?>"  value="<?php echo $fdepart['PdID']; ?>"/>
                                                        <input type="text" class="form-control" style="border: 1px solid #f9f9f9;"  name="Item_name1[]" id="Item_name<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" data-id="<?php echo $key; ?>" value="<?php echo getitem('Item_Name', $fdepart['Item']); ?>" readonly="readonly" />
                                                        <input type="hidden" class="form-control" style="border: 1px solid #f9f9f9;"  name="Item_name[]" id="Item_name<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" data-id="<?php echo $key; ?>" value="<?php echo $fdepart['Item']; ?>" readonly="readonly" />
                                                    </td>
                                                    <td> 
                                                        <select style="border: 1px solid #f9f9f9;" name = "suppliergird[]" required id = "supplierlast<?php echo $key; ?>" class = "form-control">
                                                            <?php
                                                            $getitemvalue1 = $db->prepare("SELECT * FROM `suppliers` WHERE `status`='1' AND `SupID` IN (" . getitem('supplier_id', $fdepart['Item']) . ")");
                                                            $getitemvalue1->execute();
                                                            while ($getval145 = $getitemvalue1->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?php echo $getval145['SupID']; ?>"
                                                                <?php
                                                                if ($getval145['SupID'] == $fdepart['supplier_id']) {
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?>
                                                                        ><?php echo $getval145['Supplier_name']; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                        <input type="hidden" class="form-control"  name="suppliergird[]" id="supplierprimary2" required="required" value="<?php echo $fdepart['supplier_id']; ?>"  />

                                                    </td>  

                                                    <td><input type="number" style="border: 1px solid #f9f9f9;" class="form-control"  onkeyup="caltolqty(this.value, '<?php echo $key; ?>')"  placeholder="Qty" name="Qty[]" id="Qty<?php echo $key; ?>"  pattern="[0-9  .,:'()]{1,60}" data-id="<?php echo $key; ?>"  title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $fdepart['Qty']; ?>" /></td>

                                                    <td><input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Pack_UOM1[]" id="Pack_UOM<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo getuom('Name', $fdepart['PackUoM']); ?>" readonly="readonly" />
                                                        <input type="hidden" class="form-control"  name="Pack_UOM[]" id="Pack_UOM1" required="required" value="<?php echo $fdepart['PackUoM']; ?>"  />

                                                    </td>
                                                    <td>
                                                        <input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Pack_qty[]" id="Pack_qty<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $fdepart['QtyPerPack']; ?>" readonly="readonly" />
                                                    <td>
                                                        <input type="text" style="border: 1px solid #f9f9f9;" class="form-control"  name="Item_UOM1[]" id="Item_UOM<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo getuom('Name', $fdepart['ItemUoM']); ?>" readonly="readonly" />
                                                        <input type="hidden" class="form-control"  name="Item_UOM[]" id="Item_UOM" required="required" value="<?php echo $fdepart['ItemUoM']; ?>"  />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control"  step="0.0001" onkeyup="calpackqty(this.value, '<?php echo $key; ?>')" placeholder="Total Qty" name="Total_Qty[]" id="Total_Qty<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $fdepart['TotalQty']; ?>" />   
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control"  step="0.0001"  placeholder="Pack Rate" name="Pack_Rate[]" onkeyup="calitemrate(this.value, '<?php echo $key; ?>')" id="Pack_Rate<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo number_format((float) $fdepart['PackRate'], 2, '.', ''); ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="number" style="border: 1px solid #f9f9f9; text-align: right;" class="form-control" step="0.0001" placeholder="Pack Rate" name="Item_Rate[]" onkeyup="calpackrate(this.value, '<?php echo $key; ?>')" id="Item_Rate<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo number_format((float) $fdepart['ItemRate'], 2, '.', ''); ?>" />
                                                    </td>
                                                    <td>
                                                        <select style="border: 1px solid #f9f9f9;" name = "tax[]" required id = "tax<?php echo $key; ?>"  onchange="taxpertage('<?php echo $key; ?>')" class = "form-control">
                                                            <option value = "">
                                                                Select Item
                                                            </option>
                                                            <?php
                                                            $getitemvalue121 = $db->prepare("SELECT * FROM `tax` WHERE `status`='1' ");
                                                            $getitemvalue121->execute();
                                                            while ($getval45 = $getitemvalue121->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?php echo $getval45['tid']; ?>#@#<?php echo $getval45['taxpercentage']; ?>"  <?php
                                                                if ($getval45['tid'] == $fdepart['TaxName']) {
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?> >  <?php echo $getval45['taxname']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>

                                                    </td>
                                                    <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"  class="form-control"  name="Taxable_Amt[]" id="Taxable_Amt<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{1,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{1,60})" value="<?php echo $fdepart['TaxableAmt']; ?>" readonly="readonly" /></td>
                                                    <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"   class="form-control"  name="Tax_Amt[]" id="Tax_Amt<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?php echo $fdepart['TaxAmt']; ?>" readonly="readonly" /></td>
                                                    <td><input type="text" style="border: 1px solid #f9f9f9; text-align: right;"   class="form-control"  name="Net_Amt[]" id="Net_Amt<?php echo $key; ?>"  pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})"  data-id="<?php echo $key; ?>" value="<?php echo number_format((float) $fdepart['Amount'], 2, '.', ''); ?>" readonly="readonly" /></td>    
                                                    <td valign="middle"><i class="btn btn-danger fa fa-trash"  style="width: 20px;padding: 6px 4px;" name="remove[]" id="remove<?php echo $key; ?>" onclick="remove('<?php echo $key; ?>')"></i></td>
                                                </tr> 
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>


                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <a id="addbutton" onclick="loaditemgrid()" class="btn btn-sm btn-info"  aria-hidden="true" data-toggle="modal" data-target="#ItemModal" >Add Item</a>
                                </div>
                            </div>

                            <!--     <div class="row">
                                  <div class="col-md-6">
                                  </div>
                                  <div class="col-md-6">
    
                                      <div class="row" style="font-size: 20px; float:right">
                                          <div class="col-md-12">
                                              <span >
                                                  <b>Sub  Total(<i class="fa fa-inr"></i>)</b>:
                                                  <span id='subtotaldisplay'><?php
                            if ($_REQUEST['enquiryid'] != '') {
                                echo number_format((float) getpurchaseEnquiry('SubTotal', $_REQUEST['enquiryid']), 2, '.', '');
                            }
                            ?></span>
    
                                              </span>
                                              <input type="hidden" name="subtotal" id="subtotal" value="<?php
                            if ($_REQUEST['enquiryid'] != '') {
                                echo number_format((float) getpurchaseEnquiry('SubTotal', $_REQUEST['enquiryid']), 2, '.', '');
                            }
                            ?>"/>
                                          </div></div>
                                      <div class="clearfix"></div>
    
                                   <div class="row" style="font-size: 20px; float:right">
                                          <div class="col-md-12">
                                              <span>
                                                  <b>Tax(<i class="fa fa-inr"></i>)</b>:
                                                  <span id='taxdisplay'><?php
                            if ($_REQUEST['enquiryid'] != '') {
                                echo number_format((float) getpurchaseEnquiry('SubTaxTotal', $_REQUEST['enquiryid']), 2, '.', '');
                            }
                            ?></span>
                                                  <input type="hidden" name="subtaxtotal" id="taxtotal" value="<?php
                            if ($_REQUEST['enquiryid'] != '') {
                                echo number_format((float) getpurchaseEnquiry('SubTaxTotal', $_REQUEST['enquiryid']), 2, '.', '');
                            }
                            ?>"/>
    
                                              </span>
                                          </div></div>
                                      <div class="clearfix"></div>
    
                                      <div class="row" style="font-size: 20px; float:right">
                                          <div class="col-md-12">
                                              <span >
                                                  <b>Total Amount(<i class="fa fa-inr"></i>)</b>:
                                                  <span id='NetAmtdisplay'><?php
                            if ($_REQUEST['enquiryid'] != '') {
                                echo number_format((float) getpurchaseEnquiry('Total', $_REQUEST['enquiryid']), 2, '.', '');
                            }
                            ?></span>
                                                  <input type="hidden" name="netpayamt" id="netpayamt" value="<?php
                            if ($_REQUEST['enquiryid'] != '') {
                                echo number_format((float) getpurchaseEnquiry('Total', $_REQUEST['enquiryid']), 2, '.', '');
                            }
                            ?>"/>
                                              </span>
                                          </div></div>
                                      <div class="clearfix"></div>
                                  </div>
                              </div>
    
                          </div>-->
                      </div>
                      <div class="clearfix"><br /></div>
                  </div> 
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="<?php echo $sitename; ?>items/enquiry_preparation.htm">Back to Listings page</a>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                            if ($_REQUEST['enquiryid'] != '') {
                                                echo 'UPDATE';
                                            } else {
                                                echo 'SUBMIT';
                                            }
                                            ?></button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box -->
                    </div>
                </div>
            
        </form>
    </section><!-- /.content -->

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose from register</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:15%">Customer</th>
                                    <th style="width:25%">Customer Code</th>
                                    <th style="width:15%">Company Name</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 20%;"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>                            
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="ItemModal" class="modal fade" role="itemmodal">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose from Item register</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">

                        <table id="normalexamples1" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:15%">Item Name</th>
                                    <th style="width:25%">Item Code</th>
                                    <th style="width:10%">Order</th>
                                    <th style="width:10%">Status</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1"  type="checkbox" /></th>

                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">&nbsp;</th>
                                    <th style="margin:0px auto;"><button type="submit" class="btn btn-success" name="delete" data-dismiss="modal" onclick="return checkselect('chk[]');"> Select </button></th>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="EmailBox" class="modal fade" role="model">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Sent</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" style="overflow-x:hidden;">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Description <span style="color:#FF0000;"></span></label>
                                <textarea id="editor1" name="description" class="form-control" rows="5" cols="80"><?php echo trim(stripslashes(getsupplier('Description', $_REQUEST['supid']))); ?></textarea>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="TransactionModal" class="modal fade" role="model">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Supplier Transactions</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" style="overflow-x:hidden;">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Field</th>
                                    <th>Field</th>
                                    <th>Field</th>
                                    <th>Field</th>
                                    <th>Field</th>
                                </tr>
                            </thead>
                            <tbody id="st">
                                <tr>
                                    <td>1</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                    <td>Value</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>

<script>

    //decluration  here
    var supplaerprid = 0;
    var findid = 0;

    //supplier details Start here
<?php if (($_REQUEST['enquiryid'] == '') && (!isset($_REQUEST['enquiryid']))) { ?>

        //   $("#addbutton").attr("disabled", "disabled");

<?php } ?>

    var gridvalue = Array();

    function loaditemgrid() {

        $('#check_all').prop('checked', false);
        var supplierid = 0;
        if ($('#purmode').val() == '1') {
            supplierid = $('#supplierprimary').val()
        } else {
            supplierid = 'ALL';
        }
        $('#normalexamples1').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            //"scrollX": true,
            "searching": true,
            "destroy": true,
            "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/purchase_table.htm?types=itemtable&supplierid=" + supplierid
        });

    }

    function loadgrid(str) {


        // if (str === 'ALL') {
        var setfinalarray = 'ALL';

        // } else {
        //    var setfinalarray = str.split("#@#");
        //}


        var supplierid = 0;
        $('#normalexamples').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            //"scrollX": true,
            "searching": true,
            "destroy": true,
            "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/purchase_table.htm?types=customertable&sqlitemid=" + setfinalarray,
        });
    }

    function checkselect(a)
    {
        var param_count = document.getElementsByName(a);
        var values = [];
        for (var i = 0; i < param_count.length; i++) {
            if (param_count[i].checked) {
                values.push(param_count[i].value);
            }
        }
        addrow(values);

    }


    function addgriddata(a) {
        $('#supplierprimary').val(a);
        $('#CusID').val(a);
        $("#submit").attr("disabled", "disabled");
        if (a != '') {
            $.post('<?php echo $sitename; ?>pages/master/userajax.php', {getCustomerDetails: a}, function (data) {
                if (data['image'] === '') {
                    $('#supp_logeo').css('visibility', 'hidden');
                }
                $('#supp_logeo').attr('src', '<?php echo $sitename; ?>images/customer/' + data['image']);

                $('#customer').val(data['name']);
                $('#compa_name').html(data['companyname']);
                $('#supp_code').html(data['name']);
                $('#supp_address').html(data['address']);
                $('#supp_state').html(data['state']);
                $('#supp_city').html(data['city']);
                $('#supp_county').html(data['country']);
                $('#supp_postcode').html(data['postcode']);
                $('#supplierpanel').css('display', 'block');
                $('#suppliermode').css('display', 'none');

                $('#supplierlast').val(data['name']);
                //   $('#supplierpanel').css('display', 'none');

            }, 'json');
        } else {
            $('#itemgrid').html('Customer Name Not found..!');
            $('#itemgrid').css();
            return true;
        }
        $("#addbutton").removeAttr("disabled", "disabled");
        $("#submit").removeAttr("disabled", "disabled");
    }
    //supplier details end here
    //
    // Item table select here

    $('#check_all').change(function () {
        $('#normalexamples1 input[name="chk[]"]').prop('checked', $(this).prop('checked'));
    });

    //Add Row Table  End here



    function addrow(itemid) {


        findid = findid + 1;

        $('#typeerr').html('');
        var c = parseInt($('#remm').val()) + parseInt(1);
        $('#remm').val(c);

        $("#addbutton").attr("disabled", "disabled");
        $("#submit").attr("disabled", "disabled");
        $("#customFields").append('<tr><td colspan="13"><i class="fa fa-spinner"></i></td></tr>');
        $.post("<?php echo $sitename; ?>pages/master/userajax.php", {findkeyid: findid, selectitem: itemid},
                function (data)
                {
                    $("#customFields tr:last").remove();
                    $("#customFields").append(data);
                    var param_count = document.getElementsByName('Qty[]');
                    for (var i = 0; i < param_count.length; i++) {
                        caltolqty(param_count[i].value, param_count[i].getAttribute('data-id'))
                    }
                    $("#addbutton").removeAttr("disabled", "disabled");
                    $("#submit").removeAttr("disabled", "disabled");
                });

    }

    function removegriddata(a) { //remove row
        var indexvalue = gridvalue.indexOf(a);
        gridvalue.splice(indexvalue, 1);
        var str = '#removeitems' + a;
        var str1 = '#additems' + a;
        $(str).css('display', "none");
        $(str1).css('display', "inline-block");
        //$('#displayred').html(gridvalue.length);
        $('#displayred').html(gridvalue.toString());
    }
    //Add Row Table  Start here


    var findid = 0;
    function selectitem(value, id) {
        setTimeout(function () {
            if (value !== '') {
                $.post('<?php echo $sitename; ?>pages/master/userajax.php', {itemkeyid: value}, function (data) {
                    if (parseInt() === parseInt(0)) {
                        return false;
                    } else {
                        $('#Pack_UOM' + id).val(data['pack_uom']);
                        $('#Pack_qty' + id).val(data['pack_qty']);
                        $('#Item_UOM' + id).val(data['item_uom']);
                        var justd = parseFloat(data['pack_rate']);
                        var justd1 = parseFloat(data['item_rate']);

                        $('#Pack_Rate' + id).val(justd.toFixed(2));
                        $('#Item_Rate' + id).val(justd1.toFixed(2));
                        var sentval = parseInt($('#Qty' + id).val());

                        if ($('#Qty' + id).val() != '') {
                            caltolqty(sentval, id);
                        }

                        return true;
                    }

                }, 'json');
            }
        }, 100);
    }
    function caltolqty(a, b) {
        var getqty = parseFloat($('#Qty' + b).val());
        //var getqty = parseFloat(a);
        var getqty45 = parseFloat($('#Pack_qty' + b).val());
        if (a === '') {
            $('#Total_Qty' + b).val('');
        } else {
            $('#Total_Qty' + b).val(getqty45 * getqty);
        }
        netamt(b);
        //   taxpertage(b);
    }

    function calpackqty(a, b) {
        var getqty = parseFloat(a);
        var getqty45 = parseFloat($('#Pack_qty' + b).val());
        if (a === '') {
            $('#Qty' + b).val('');
        } else {
            $('#Qty' + b).val(getqty / getqty45);
        }
        netamt(b);
    }

    function calitemrate(a, b) {

        var getpackrate = parseFloat($('#Pack_Rate' + b).val());
        var getpackqty = parseFloat($('#Pack_qty' + b).val());
        var itemrateresult = getpackrate / getpackqty;

        if ($('#Qty' + b).val() == '') {
            $('#Item_Rate' + b).val('');
        } else {
            $('#Item_Rate' + b).val(itemrateresult.toFixed(2));
        }
        netamt(b);
        taxpertage(b);
        displaynettotal();
    }
    function calpackrate(a, b) {

        var getpackrate = parseFloat($('#Item_Rate' + b).val());
        var getpackqty = parseFloat($('#Pack_qty' + b).val());
        var itemrateresult = getpackrate * getpackqty;

        if ($('#Qty' + b).val() == '') {
            $('#Pack_Rate' + b).val('');
        } else {
            $('#Pack_Rate' + b).val(itemrateresult.toFixed(2));
        }
        netamt(b);
        taxpertage(b);
        displaynettotal();
    }


    function netamt(b) {

        var getqty = parseFloat($('#Qty' + b).val());
        var getrate = parseFloat($('#Pack_Rate' + b).val());
        var netresult = getqty * getrate;

        if ($('#Qty' + b).val() == '') {
            $('#Net_Amt' + b).val('');
        } else {
            $('#Net_Amt' + b).val(netresult.toFixed(2));
        }
        displaynettotal();
    }

    function displaynettotal()
    {
        var total = 0;
        var taable = 0;
        var ttax = 0;
        var Net_Amt = document.getElementsByName('Net_Amt[]');
        var Taxable_Amt = document.getElementsByName('Taxable_Amt[]');
        var Tax_Amt = document.getElementsByName('Tax_Amt[]');

        for (var i = 0; i < Net_Amt.length; i++) {
            total += parseFloat(Net_Amt[i].value) || parseFloat(0);
            taable += parseFloat(Taxable_Amt[i].value) || parseFloat(0);
            ttax += parseFloat(Tax_Amt[i].value) || parseFloat(0);
        }

        $('#NetAmtdisplay').html(total.toFixed(2));
        $('#subtotaldisplay').html(taable.toFixed(2));
        $('#taxdisplay').html(ttax.toFixed(2));

        $('#subtotal').val(taable.toFixed(2));
        $('#taxtotal').val(ttax.toFixed(2));
        $('#netpayamt').val(total.toFixed(2));
    }


    function taxpertage(id)
    {
        var ttax = 0;
        if ($('#tax' + id).val() != '')
        {
            var itemrate = $('#tax' + id).val();
            var res = itemrate.split("#@#");
            var taxpercentage = parseFloat(res[1]);

            var gettotal = parseFloat($('#Net_Amt' + id).val());
            if ($('#Net_Amt' + id).val() == '') {
                $('#Taxable_Amt' + id).val('');
                $('#Tax_Amt' + id).val('');
            } else {
                if ($('#taxtype').val() == '1') {
                    var taxbamt = (gettotal / (100 + parseFloat(taxpercentage))) * 100;
                    var taxamt = gettotal - taxbamt;
                    $('#Taxable_Amt' + id).val(taxbamt);
                    $('#Tax_Amt' + id).val(taxamt);
                } else {
                    var taxbamt = gettotal;
                    var taxamt = (gettotal * parseFloat(taxpercentage)) / 100;
                    $('#Taxable_Amt' + id).val(taxbamt);
                    $('#Tax_Amt' + id).val(taxamt);
                    $('#Net_Amt' + id).val(taxamt + taxbamt);
                }
            }
        }
        displaynettotal();
    }


    function remove(b) {
        var getv1 = $('#purchase_detailid' + b).val();
        var senttablename = 'purchase_order_details';
        var sentfield = 'PdID';

        if (confirm("Please confirm you want to Delete this Item(s)"))
        {
            if (getv1 != 'NEW') {
                var sentdeldata = $('#purchase_detailid' + b).val();
                $("#addbutton").attr("disabled", "disabled");
                $("#submit").attr("disabled", "disabled");
                $.post("<?php echo $sitename; ?>pages/master/userajax.php", {deledtered: sentdeldata, tablename: senttablename, primarykey: sentfield},
                        function (data)
                        {
                            $("#addbutton").removeAttr("disabled", "disabled");
                            $("#submit").removeAttr("disabled", "disabled");
                        });
            }
            $('#datarow' + b).remove();

            displaynettotal();
            return true;
        } else
        {
            return false;
        }

    }

    function gridmode() {
        if ($('#purmode').val() == '2') {
            $('#suppliermode').css('visibility', 'hidden');
            $('#suppliermode121').css('visibility', 'hidden');
            $("#addbutton").removeAttr("disabled", "disabled");

        } else {
            $('#suppliermode').css('visibility', 'visible');
            $('#suppliermode121').css('visibility', 'visible');
            $("#addbutton").attr("disabled", "disabled");
        }
    }

    //tax cal
    function univaerselcha() {

        var lenth = document.getElementsByName('Net_Amt[]');
        var justtemp = '';
        for (var i = 0; i < lenth.length; i++) {
            justtemp = lenth[i].getAttribute('data-id')
            netamt(justtemp);
            taxpertage(justtemp);
            displaynettotal();
        }
    }

    function showtrans(a) {

        $('#st').html('<tr><td colspan="6"><i class="fa fa-spinner fa-spin"></i></td></tr>');
        $.post('<?php echo $sitename; ?>pages/master/userajax.php', {seetrans: '1', supp_id: a}, function (data) {
            $('#st').html(data);
        });
    }

</script>