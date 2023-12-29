<?php 

include ('../../config/config.inc.php');
$domain = $_POST['domain'];
echo "<option>Select Employee Name</option>";
$get1 = $db->prepare("SELECT * FROM `employee` WHERE `domain`=?");
$get1->execute(array($domain));
    while($get = $get1->fetch(PDO::FETCH_ASSOC)){
  echo "<option value='".$get['rid']."'>".ucfirst($get['name'])."</option>";

}
        
?> 