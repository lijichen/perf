<?php
include("config.php");
$id=$_GET['id'];
$filename = $_FILES["file"]["name"];
$ufile="mkhtml/$id/";
$filecheck = "$ufile$filename";



echo "<br />";
echo $ufile;
echo "<br />";



if ($filename=="")
{
backurl();
}
else
{

if ($_FILES["file"]["error"] > 0)
    {
	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	#echo "file upload error";
	backurl();
    }
  else
 {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

	move_uploaded_file($_FILES["file"]["tmp_name"], "$ufile" . $_FILES["file"]["name"]);
      echo "Stored in: " . "$ufile" . $_FILES["file"]["name"];
	changeurl1($id);

      }
 }


echo "<br />";
#echo $filename;
echo "<br />";


?>
