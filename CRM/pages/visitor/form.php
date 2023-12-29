<html>
<body>
<?php
include ('../../config/config.inc.php');

extract($_POST);

$target_dir = $fsitename . "test_upload/";

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if($upd)
{

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if($imageFileType != "mp4" && $imageFileType != "avi" && $imageFileType != "mov" && $imageFileType != "3gp" && $imageFileType != "mpeg")
{
    echo "File Format Not Suppoted";
} 

else
{

$video_path=$_FILES['fileToUpload']['name'];

mysql_query("INSERT INTO `video` (`video_name`) values ('$video_path')");
 $resa = $db->prepare("INSERT INTO `video`(`video_name`) VALUES(?)");
                $resa->execute(array($video_path));

// move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_file);

if (copy($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
    	echo $target_file;
        echo "Sorry, there was an error uploading your file.";
    }
// echo "uploaded ";
// echo $target_dir;
// echo $video_path;

}

}

//display all uploaded video

if($disp)

{

$query=mysql_query("SELECT * from `video`");

	while($all_video=mysql_fetch_array($query))

	{
?>
	 
	 <video width="300" height="200" controls>
	<source src="test_upload/<?php echo $all_video['video_name']; ?>" type="video/mp4">
	</video> 
	
	<?php } }
?>
<form method="post" enctype="multipart/form-data">

<table border="1" style="padding:10px">

<tr>

<td>Upload  Video</td></tr>

<tr><td><input type="file" name="fileToUpload"/></td></tr>

<tr><td>

<input type="submit" value="Uplaod Video" name="upd"/>

<input type="submit" value="Display Video" name="disp"/>

</td></tr>

</table>

</form>
</body>
</html>