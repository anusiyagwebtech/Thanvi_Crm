<?php
if($_REQUEST['eid']!=''){
$thispageeditid=26;    
}
else{
$thispageaddid=26;	
	}
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
$editor = 1;

if (isset($_REQUEST['submit']) || isset($_REQUEST['submit_x']))
{
    $ress = FETCH_all("SELECT `pid` FROM `permission` WHERE `name`=? AND `Status`!=?",trim($_REQUEST['name']),2);
    
    if($ress['pid']=='')
    {
    $pageid = $_REQUEST['pageid'];
   pFETCH("INSERT INTO `permission`(`name`,`date_added`,`last_upd_by`,`status`) VALUES(?,?,?,?)",trim($_REQUEST['name']),date("Y-m-d H:i:s"),$_SESSION['UID'],$_REQUEST['status']);
   

    $iid = $db->lastInsertId();
    for ($i = 0; $i <= (count($pageid) - 1); $i++) {
        $view2 = "view" . $pageid[$i];
        $edit2 = "edit" . $pageid[$i];
        $addnew2 = "addnew" . $pageid[$i];
        $delete2 = "delete" . $pageid[$i];

        $view = $_REQUEST[$view2];
        $addnew = $_REQUEST[$addnew2];
        $edit = $_REQUEST[$edit2];
        $delete = $_REQUEST[$delete2];

       pFETCH("INSERT INTO `permission_details`(`page`,`pview`,`paddnew`,`pedit`,`pdelete`,`permission_id`) VALUES(?,?,?,?,?,?)",$pageid[$i],$view,$addnew,$edit,$delete,$iid);
    
        $htry = pFETCH("INSERT INTO `history` (`page`,`pageid`,`action`,`userid`,`ip`,`actionid`) VALUES (?,?,?,?,?,?)",'Item Group',1,'Insert',$_SESSION['UID'],$ip,$insert_id);
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Inserted</h4></div>';

    }   
 } else {
     $res = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> We already have this Employee Name for Permission Group</h4></div>';
 }
}

if (isset($_REQUEST['update']) || isset($_REQUEST['update_x']))
{
    $pageid = $_REQUEST['pageid'];

   pFETCH("UPDATE `permission` SET `name`=?,`date_added`=?,`last_upd_by`=?,`status`=? WHERE `pid`=?",trim($_REQUEST['name']),date("Y-m-d H:i:s"),$_SESSION['UID'],$_REQUEST['status'],$_REQUEST['eid']);

    for ($i = 0; $i <= (count($pageid) - 1); $i++){

        $view2 = "view" . $pageid[$i];
        $edit2 = "edit" . $pageid[$i];
        $addnew2 = "addnew" . $pageid[$i];
        $delete2 = "delete" . $pageid[$i];

        $view = $_REQUEST[$view2];
        $addnew = $_REQUEST[$addnew2];
        $edit = $_REQUEST[$edit2];
        $delete = $_REQUEST[$delete2];
        $depart=pFETCH("SELECT * FROM `permission_details` WHERE `page`=? AND `permission_id`=?",$pageid[$i],$_REQUEST['eid']);
        $ndepart=$depart->rowCount();
        if($ndepart>0){
        						
        pFETCH("UPDATE `permission_details` SET `pview`=?,`paddnew`=?,`pedit`=?,`pdelete`=? WHERE `permission_id`=? AND `page`=? ",$view,$addnew,$edit,$delete,$_REQUEST['eid'],$pageid[$i]);
        }else{
			 pFETCH("INSERT INTO `permission_details` SET `pview`=?,`paddnew`=?,`pedit`=?,`pdelete`=?,`permission_id`=?,`page`=? ",$view,$addnew,$edit,$delete,$_REQUEST['eid'],$pageid[$i]);
		}
    }
    $res='<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Succesfully Updated!</h4></div>';
    //header("location:".$sitename."settings/".$_REQUEST['eid']."/permissionx.htm");
}


$page = FETCH_all("SELECT * FROM `permission` WHERE `pid`=?",$_REQUEST['eid']);
?>
<style type="text/css">
    .row { margin:0;}
    .icheckbox_minimal-blue, .iradio_minimal-blue{
        height:23px;
    }
    .iCheck-helper
    {
        position: absolute;
        top: 0%; 
        left: 0%; 
        display: block;
        width: 100%;
        height: 100%; 
        margin: 0px;
        padding: 0px; 
        border: 0px;
        opacity: 0;
        background: rgb(255, 255, 255);
    }
</style>
<script type="text/javascript">
    function checkdis() {
        var elem = ["1", "2", "3", "4", "5"];

        setTimeout(function () {
            for (var i = 0; i <= elem.length; i++) {
                if (document.getElementById('rows' + elem[i]).checked) {
                    document.getElementById('row' + elem[i]).style.display = 'block';
                } else {
                    document.getElementById('row' + elem[i]).style.display = 'none';
                }
            }
        }, 200);

    }




    function del(a) {
        var h = confirm("Do you want to delete this User Permission ?");
        if (h) {
            location.href = "permissionx.php?delete&eid=" + a;
        }
    }

    function checkall(objForm) {
        // len = objForm.elements.length;
        //alert(len);
        //hvwid
        var clsn = document.getElementsByClassName("clschkvw");
        var len = clsn.length
        var i = 0;
        var k = 3;
        for (i = 0; i < len; i++)
        {
            k++;
            // if (k % 5 == '1')
            // {
            if (clsn[i].type == 'checkbox') {
                clsn[i].checked = objForm.check_alls.checked;
            }
            //  }
            if (k == '5') {
                // var k = '0';
            }

        }
    }

    function checkall1(objForm) {
        //  len = objForm.elements.length;
        //alert(len);
        var clsna = document.getElementsByClassName("clschkadn");
        var len = clsna.length
        var i = 0;
        var k = 2;
        for (i = 0; i < len; i++)
        {
            k++;
            // if (k % 5 == '1')
            // {
            if (clsna[i].type == 'checkbox') {
                clsna[i].checked = objForm.check_allss.checked;
            }
            //  }
            if (k == '5') {
                //  var k = '0';
            }

        }
    }

    function checkall2(objForm) {
        //len = objForm.elements.length;
        //alert(len);
        var clsned = document.getElementsByClassName("clschked");
        var len = clsned.length
        var i = 0;
        var k = 1;
        for (i = 0; i < len; i++)
        {
            k++;
            // if (k % 5 == '1')
            // {
            if (clsned[i].type == 'checkbox') {
                clsned[i].checked = objForm.check_allsss.checked;
            }
            //}
            if (k == '5') {
                //  var k = '0';
            }

        }
    }

    function checkall3(objForm) {
        // len = objForm.elements.length;
        //alert(len);
        var clsndel = document.getElementsByClassName("clschkdel");
        var len = clsndel.length
        var i = 0;
        var k = 0;
        for (i = 0; i < len; i++)
        {
            k++;
            //  if (k % 5 == '1')
            // {
            if (clsndel[i].type == 'checkbox') {
                clsndel[i].checked = objForm.check_allssss.checked;
            }
            //  }
            if (k == '5') {
                //    var k = '0';
            }


        }
    }
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Permission Groups
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
           <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i>&nbsp;Settings</a></li>
           <li><a href="<?php echo $sitename;?>settings/permission.htm"><i class="fa fa-user"></i>&nbsp;&nbsp;Permission Groups</a></li>
            <li class="active"><?php
                        if ($_REQUEST['eid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?>&nbsp;Permission Group</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content ">
        <div class="row">

            <div class="col-md-12" style="padding:0">
                <form name="permission" id="permission" action="#" method="post">
                    <div class="box box-info">
                       
                     
                        <div class="box-body">
                            <?php if($res!=''){ echo $res; } ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Employee Name <span style="color:#FF0000;">*</span></label>
                                     <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                         <input name="name" id="name" pattern="[A-Za-z  0-9]{2,55}" required="required" value="<?php echo getpermission('name', $_REQUEST['eid']); ?>" class="form-control" type="text" /></div>
                                </div>
                                <div class="col-md-3">
                                    <label>Status <span style="color:#FF0000;">*</span></label>
                                    <select class="form-control" name="status" id="status" required="required">
                                       
                                        <option value="1" <?php if(getpermission('status', $_REQUEST['eid'])=='1'){ echo 'selected="selected"'; } ?>>Active</option>
                                        <option value="0" <?php if(getpermission('status', $_REQUEST['eid'])=='0'){ echo 'selected="selected"'; } ?>>Inactive</option>
                                    </select>
                                </div>
                                 <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                            </div>
                            <br />
                            <div class="table-responsive" style="float:left; width:100%;">
                                <table class="table table-bordered table-striped" >
                                    <thead>
                                        <tr>
                                            <th style="width:60%;">Page</th>
                                            <th style="width:10%; text-align:center;">View<br /><input name="check_alls" id="check_alls" value="1" onclick="checkall(this.form)" type="checkbox" ></th>
                                            <th style="width:10%; text-align:center;">Add New<br /><input name="check_allss" id="check_allss" value="1" onclick="checkall1(this.form)" type="checkbox">       
                                            </th>
                                            <th style="width:10%; text-align:center;">Edit<br /><input name="check_allsss" id="check_allsss" value="1" onclick="checkall2(this.form)" type="checkbox">      
                                            </th>
                                            <th style="width:10%; text-align:center;">Delete<br /><input name="check_allssss" id="check_allssss" value="1" onclick="checkall3(this.form)" type="checkbox">     
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $pag = pFETCH("SELECT * FROM `pages` WHERE  `status` =? ORDER BY `displayorder` ASC",1);
                                      
                                        $vad = 0;
                                        while ($pag1 = $pag->fetch(PDO::FETCH_ASSOC)) {
                                            $vad++;
                                            $pagedet = FETCH_all("SELECT * FROM `permission_details` WHERE `permission_id`=? AND `page`=? ",$_REQUEST['eid'],$pag1['pid']);
                                            $viewpage = "view" . $pag1['pid'];
                                            $addnewpage = "addnew" . $pag1['pid'];
                                            $editpage = "edit" . $pag1['pid'];
                                            $deletepage = "delete" . $pag1['pid'];
                                            ?>
                                            <tr>
                                                <td><?php if(trim($pag1['category'])=='no'){ ?>
                                                <b><?php echo $pag1['pagename']; ?></b>
                                                <?php } else { echo $pag1['pagename']; ?>
                                                <input type="hidden" name="pageid[]" value="<?php echo $pag1['pid']; ?>" />
                                                    <?php } ?>
                                                </td>
                                                <td align="center">
                                                    <?php if(trim($pag1['category'])=='yes'){ ?>
                                                    <input type="checkbox" name="<?php echo $viewpage; ?>" value="1" class="clschkvw" id="view" <?php if ($pagedet['pview'] == 1 && $_REQUEST['eid'] != '') { echo "checked=checked"; } ?> /><?php } ?>
                                                </td>
                                                <td align="center">
                                                      <?php if(trim($pag1['category'])=='yes'){ ?>
                                                    <input type="checkbox" name="<?php echo $addnewpage; ?>" value="1"  class="clschkadn" <?php if ($pagedet['paddnew'] == 1 && $_REQUEST['eid'] != '') { echo "checked=checked"; } ?> /><?php } ?>
                                                </td>
                                                <td align="center">
                                                      <?php if(trim($pag1['category'])=='yes'){ ?>
                                                    <input type="checkbox" name="<?php echo $editpage; ?>" value="1"  class="clschked" <?php if ($pagedet['pedit'] == 1 && $_REQUEST['eid'] != '') { echo "checked=checked"; } ?> /><?php } ?>
                                                </td>
                                                <td align="center">
                                                      <?php if(trim($pag1['category'])=='yes'){ ?>
                                                    <input type="checkbox" name="<?php echo $deletepage; ?>" value="1"  class="clschkdel" <?php if ($pagedet['pdelete'] == 1 && $_REQUEST['eid'] != '') { echo "checked=checked"; } ?> /><?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>


                            <h3 class="box-title"></h3>
                            <a href="<?php echo $sitename; ?>settings/permission.htm">Back to listing Page</a>
                            <span style="float:right;">
                                <?php if(isset($_REQUEST['eid'])){ ?>
                                <button name="update" type="submit" class="btn btn-success">
                                    UPDATE
                                </button>
                                <?php } else { ?>
                                <button name="submit" type="submit" class="btn btn-success">
                                    SAVE
                                </button>
                                <?php } ?>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include ('../../require/footer.php');
?>