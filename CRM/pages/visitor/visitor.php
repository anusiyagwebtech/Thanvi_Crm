<?php
$menu = "5,5,6";
$thispageid = 20;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';

include ('../../require/header.php');


if(!isset($_REQUEST['btn_update'])) {
    @extract($_REQUEST);
// echo "strcasecmp";
// exit;

$check_visitor = FETCH_all("SELECT * FROM `train_user` WHERE `tid` = 1");
if ($check_visitor != '') {
   
 $htry = $db->prepare("UPDATE `train_user` SET `login_id`=?, `password` = ?");
            $htry->execute(array(trim($login_id), trim($password)));
}
}
?>
<script type="text/javascript" >
    function validcheck(name)
    {
        var chObj = document.getElementsByName(name);
        var result = false;
        for (var i = 0; i < chObj.length; i++) {
            if (chObj[i].checked) {
                result = true;
                break;
            }
        }
        if (!result) {
            return false;
        } else {
            return true;
        }
    }

    function checkdelete(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Please confirm you want to Delete this New(s)"))
            {
                return true;
            } else
            {
                return false;
            }
        } else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to delete.");
            return false;
        }
    }

    function checkall(objForm) {
        len = objForm.elements.length;
        var i = 0;
        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }
</script>
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(2), #normalexamples tbody tr td:nth-child(3) {
        text-align:left;
    }  
    #normalexamples tbody tr td:nth-child(4),#normalexamples tbody tr td:nth-child(5),#normalexamples tbody tr td:nth-child(6),#normalexamples tbody tr td:nth-child(7) {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Visitor |
            <small>Visitor Details</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-newspaper-o"></i> visitor</a></li>
            <li class="active">Visitor Detail</li>
        </ol>

    </section><br>
<div class="row">                               
                                <div class="col-md-5">
                                    <label>Trainer User ID<span style="color:#FF0000;">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Enter Trainer ID" name="login_id" id="login_id" required="required" value="<?php echo stripslashes(gettrainer('login_id',$_REQUEST['tid'])); ?>" disabled/>
                                </div>
                                <div class="col-md-5">


                                    <label>Trainer Password<span style="color:#FF0000;">*</span></label>
                                    <input name="password" id="password" class="form-control" required="required" placeholder="Enter Trainer Password" value="<?php echo stripslashes(gettrainer('password',$_REQUEST['tid'])); ?>" disabled/>
                                </div> 
                              <!--   <div class="col-md-2" style="padding-top: 25px;">
                            <button type="submit" name="btn_update" id="btn_update" class="btn btn-success">update
                                </button>                                   
                                </div>  -->                            
                            </div>


    <!-- Main content -->
    <section class="content">

        <div class="box">
           
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center" width="5%" >id</th>
                                    <th width="20%">Name</th>                                   
									<th width="20%">E-mail</th>
									<th style="text-align: center" width="20%" >In-Time</th>
                                    <th style="text-align: center" width="20%">Out-Time</th>
                                    
                                </tr>
                            </thead>
                           
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var sid = a;
        window.location.href = '<?php echo $sitename; ?>news/' + a + '/editnews.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>
<script type="text/javascript">
    $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=visitortable"
    });
</script>


