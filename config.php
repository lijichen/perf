<?php
$a = session_id();
if(empty($a)) session_start();
#echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];
$sid=session_id();
$clientip=$_SERVER["REMOTE_ADDR"];



#invoke index.php
function createdir($sdir)
{
exec("mkdir /html/perf/mkhtml/$sdir");
exec("chmod 777 /html/perf/mkhtml/$sdir");
}

function createdirp($dir)
{
exec("sudo /usr/bin/mkdir $dir");
exec("sudo /usr/bin/chmod 777 $dir");
}

function changeurl1($cid)
{
$url="Location: ./mkhtml.php?id=$cid";
header("$url");
}

function changeurl2($filedir)
{
$url="Location: ../upload/$filedir/html/";
header("$url");
}


function backurl()
{

$url="Location: /errorpage.html";
header("$url");
}


function getfiletype($filename)
{
$file = fopen($filename, 'rb');
$bin  = fread($file, 2);
fclose($file);
$strInfo  = @unpack('C2chars', $bin);
$typeCode = intval($strInfo['chars1'].$strInfo['chars2']);
return $typeCode;
}


function changecheckurl($cid)
{
$url="Location: ./check.php?id=$cid";
header("$url");
}


function runcmd($cmd)
{
system("sudo /root/script/http/checkhcl2file.sh $cmd");
system("sudo /root/script/http/checklunlink2file.sh $cmd");
system("sudo /root/script/http/checkmce2file.sh $cmd");
system("sudo /root/script/http/checkscsi2file.sh $cmd");
system("sudo /root/script/http/checkslock2file.sh $cmd");
system("sudo /root/script/http/checknetwork2file.sh $cmd");
}
function delfile($file)
{
exec("sudo /bin/rm -rf /html/upload/$file/*");
}




?>
