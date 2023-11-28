<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include("config.php");
$dateid=exec("sudo date +%Y%m%d%H%M%S-");
#echo $dateid;
$uuid=exec("sudo cat /proc/sys/kernel/random/uuid");
#echo $uuid;
$id=$dateid."".$uuid;
#echo $id;
#echo "<br/>";
createdir($id);

?>

<body>
DataCollector01.csv chart Show
<br/>
<hr/>
<script>
function check(){
var str = document.getElementById("file").value;
if(str.length==0)
{
alert("Please select DataCollector01.csv to upload~");
return false;
}
return true;
}
</script>

<form onsubmit="return check()" action="<?php echo "upload_file.php?id=$id" ?>" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" accept=".csv" /> 
<input type="submit" name="submit" value="Submit" />
</form>

<?php
$cip="$clientip";
echo "The Client IP address is: ".$cip;
echo "<br/>";
$cip="$sid";
echo "Session_id: $id";

?>

</body>
</html>
