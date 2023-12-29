<?php
include ('../../config/config.inc.php');

if ($_REQUEST['cid']!='') {
    ?>
    <div class="col-md-6">
        <select name="sid[]" class="form-control" multiple="multiple" >
            <option value="<?php ?>">Select Location</option>
            <?php
            $cata = $_REQUEST['cid'];
            foreach ($cata as $c) {
                $s = $db->prepare("SELECT * FROM `careers` WHERE `status`= ? AND FIND_IN_SET(?,`cid`)");
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
} ?>
