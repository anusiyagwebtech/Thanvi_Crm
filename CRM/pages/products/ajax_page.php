<?php
include ('../../config/config.inc.php');

if ($_REQUEST['pid']) {
    ?>
    <div class="col-md-6">
        <label>SubCategory Name <span style="color:#FF0000;"></span></label>    
        <select name="sid[]" class="form-control" multiple="multiple" >
            <option value="<?php ?>">Select Subcategory</option>
            <?php
            $cata = $_REQUEST['pid'];
            foreach ($cata as $c) {
                $s = $db->prepare("SELECT * FROM `subcategory` WHERE `status`= ? AND FIND_IN_SET(?,`cid`)");
                $s->execute(array('1', $c));

                while ($cate = $s->fetch()) {
                    ?>
                    <option value="<?php echo $cate['sid']; ?>"><?php echo $cate['subcategory']; ?></option>
                <?php }
            }
            ?>
        </select>
    </div>
<?php
}

//attribute

if ($_REQUEST['attribute'] != '') {
    $ids = rand(3, 6) . time();
    ?>
    <div class="row" id="<?php echo $ids ?>" style="margin-bottom: 10px">
        <div class="col-md-4">
            <label>Value <span style="color:#FF0000;">*</span></label>                                  
            <input type="text" class="form-control" required="required" name="cid[]" id="product" value="<?php
            if ($_REQUEST['id'] != '') {
                echo getproduct('productname', $_REQUEST['id']);
            } else {
                echo $_REQUEST['product'];
            }
            ?>"/>  
        </div>

        <div class="col-md-1">
            <br />
            <span> <i class="fa fa-trash fa-2x" style="margin-top: 6px;color:#ff0000" onclick="removethis(<?php echo $ids ?>, $(this))" ></i></span>
        </div>
    </div>
    <?php
}

//products pages start here


if ($_REQUEST['add'] != '') {
    $ids = rand(3, 6) . time();
    ?>
    <div class="row" id="<?php echo $ids ?>" style="margin-bottom: 10px">
        <div class="col-md-4">
            <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
            <select name="cid[]" class="form-control"  onchange="getsubcategoryp(this.value,<?php echo $ids ?>)"  required>
                <option value="">Select Category</option>
                <?php
                $s = $db->prepare("SELECT * FROM `category` WHERE `status`= ? ");
                $s->execute(array('1'));
                while ($cate = $s->fetch()) {
                    ?>
                    <option value="<?php echo $cate['cid']; ?>" <?php
                    if ($cate['cid'] == $catedid) {
                        echo 'selected';
                    }
                    ?>
                            ><?php echo $cate['category']; ?></option>
    <?php } ?>
            </select>
        </div>
        <div id="getsub">
            <div class="col-md-4" id='sid<?php echo $ids ?>'>
                <label>SubCategory Name <span style="color:#FF0000;"></span></label>                                  
                <select name="sid[]"  class="form-control" onchange="getinnercategoryp(this.value, '<?php echo $ids ?>')" >
                    <option value="">Select Subcategory</option>
                    <?php
                    $s = $db->prepare("SELECT * FROM `subcategory` WHERE `status`= ? ");
                    $s->execute(array('1'));
                    while ($cate = $s->fetch()) {
                        ?>
                        <option value="<?php echo $cate['sid']; ?>" <?php
                        if ($cate['sid'] == $subcaeteded[$nn]) {
                            echo 'selected';
                        }
                        ?>><?php echo $cate['subcategory']; ?></option>
    <?php } ?>
                </select>
            </div> 
        </div>
        <div id="getsub1">
            <div class="col-md-3" id="nid<?php echo $ids ?>">
                <label>Inner Category Name <span style="color:#FF0000;"></span></label>                                  
                <select name="nid[]"  class="form-control">
                    <option value="">Select Category</option>
                    <?php
                    $s = $db->prepare("SELECT * FROM `innercategory` WHERE `subcategory`= ?  AND `status`= ? ");
                    $s->execute(array($subcaeteded[$nn], '1'));

                    while ($cate = $s->fetch()) {
                        ?>
                        <option value="<?php echo $cate['innerid']; ?>" <?php
                        if ($cate['innerid'] == $innercaeteded[$nn]) {
                            echo 'selected';
                        }
                        ?>
                                ><?php echo $cate['innername']; ?></option>
    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-1">
            <br />
            <span> <i class="fa fa-trash fa-2x" style="margin-top: 6px;color:#ff0000" onclick="removethis(<?php echo $ids ?>, $(this))" ></i></span>
        </div>
    </div>
    <?php
}

if ($_REQUEST['subs'] != '') {
    ?>
    <label>SubCategory Name <span style="color:#FF0000;"></span></label>                                  
    <select name="sid[]"  class="form-control" onchange="getinnercategoryp(this.value, '<?php echo $_REQUEST['idss'] ?>')"  >
        <option value="">Select </option>
        <?php
        $s = $db->prepare("SELECT * FROM `subcategory` WHERE `status`= ? AND FIND_IN_SET(?,`cid`)");
        $s->execute(array('1', $_REQUEST['subs']));
        while ($cate = $s->fetch()) {
            ?>
            <option value="<?php echo $cate['sid']; ?>" <?php
            if ($cate['sid'] == $subcaeteded[$nn]) {
                echo 'selected';
            }
            ?>><?php echo $cate['subcategory']; ?></option>
    <?php } ?>

    </select>
    <?php
}

if ($_REQUEST['inns'] != '') {
    ?>
    <label>Inner Category Name  <span style="color:#FF0000;"></span> </label>                                  
    <select name="nid[]"  class="form-control">
        <option value="">Select </option>
        <?php
        $s = $db->prepare("SELECT * FROM `innercategory` WHERE `subcategory`= ? AND `status`= ? ");
        $s->execute(array($_REQUEST['inns'], '1'));
        while ($cate = $s->fetch()) {
            ?>
            <option value="<?php echo $cate['innerid']; ?>" <?php
            if ($cate['innerid'] == $innercaeteded[$nn]) {
                echo 'selected';
            }
            ?>><?php echo $cate['innername']; ?></option>
    <?php } ?>
    </select>
    <?php
}

if ($_REQUEST['addattribute']) {

    $inc = $_REQUEST['inc'];
    $groups = $db->prepare("SELECT * FROM `attribute_group` WHERE `id`= ? ");
    $groups->execute(array($_REQUEST['addattribute']));
    $groups1 = $groups->fetch();
    ?>

    <div class="row new_m"   id="remove_<?php echo $inc ?>">

        <div class="col-md-1">
            <br />
            <input type="radio" name="default_attri" value="<?php echo $inc ?>" />

        </div>

        <?php
        foreach (explode(',', $groups1['attribute']) as $gid) {

            $single_att1 = $db->prepare("SELECT * FROM `attribute` WHERE `id`= ? ");
            $single_att1->execute(array($gid));
            $single_att = $single_att1->fetch();
            ?>
            <div class="col-md-3">
                <label><?php echo $single_att['name']; ?></label>
                <select name="attr_values_<?php echo $inc ?>[]"  class="form-control" required="required" >
                    <option value="">Select</option>
                    <?php
                    $single_att_others = $db->prepare("SELECT * FROM `attribute_value` WHERE `valid`= ? ");
                    $single_att_others->execute(array($single_att['id']));

                    while ($single_att_othersf = $single_att_others->fetch()) {
                        ?>

                        <option value="<?php echo $single_att_othersf['vid'] ?>" <?php
                        if ($single_att_othersf['vid'] == $valuesid) {
                            echo 'selected';
                        }
                        ?>><?php echo $single_att_othersf['value'] ?></option>
                                <?php
                            }
                            ?>

                </select>

            </div>
            <?php
        }
        ?>

        <div class="col-md-2">
            <label>Price</label>
            <input type="text" class="form-control"  required="required"  name="price_attr_<?php echo $inc ?>"  value="<?php echo $sattrf['price']; ?>"/>

        </div>
        <div class="col-md-2">
            <label>Special Price</label>

            <input type="text" class="form-control"  required="required"  name="sprice_attr_<?php echo $inc ?>"  value="<?php echo $sattrf['sprice']; ?>"/>

        </div>
        <div class="col-md-1">
            <br />
            <i class="fa fa-trash fa-2x" style="margin-top: 6px;color:#ff0000"  onclick="removethisattr(<?php echo $inc ?>)" ></i

        </div>
        <input type="hidden" name="check_rows[]" value="<?php echo $inc ?>" />

    </div>     	

    <?php
}







































if ($_REQUEST['validdatef'] != '') {
    if (strtotime($_REQUEST['validdatef']) > strtotime($_REQUEST['validdatet'])) {
        $data['value'] = '<p style="color:#ff0000;font-size:15px;">Valid To date should be greater than Valid From date  </p>';
    } else if (strtotime($_REQUEST['validdatef']) < strtotime($_REQUEST['validdatet'])) {

        $data['value'] = 1;
    } else {
        $data['value'] = 1;
    }
    echo json_encode($data);
}

if ($_REQUEST['removevalue'] != '') {
    $xs = $db->prepare("DELETE FROM `attribute_value` WHERE  `vid`= ? ");
    $xs->execute(array($_REQUEST['removevalue']));
}
 