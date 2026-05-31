<?php
session_start();
include("inc/config.inc.php");
include('inc/yzcode.inc.php');
include("inc/incommon.inc.php");

if(isset($_GET["language"]))
{
	$lan=$_GET["language"];
	if($lan=="zh")
	{
		$_SESSION["inclanguage"]="../language/user_zh.php";
		$_SESSION["morelanguage"]="../language/user_more_zh.php";
		include_once("language/user_zh.php");
		$_SESSION["lan"]="zh";
	}elseif($lan=="tw")
	{
		$_SESSION["inclanguage"]="../language/user_tw.php";
		$_SESSION["morelanguage"]="../language/user_more_tw.php";
		include_once("language/user_tw.php");
		$_SESSION["lan"]="tw";
	}
}else
{
	$sqllan=mysql_query("select lan from config where sign='1'",$conn);
	$lan=mysql_result($sqllan,0,"lan");
	if($lan==0) $lens="zh";
	if($lan==1) $lens="tw";
	$_SESSION["inclanguage"]="../language/user_".$lens.".php";
	$_SESSION["morelanguage"]="../language/user_more_".$lens.".php";
	include_once("language/user_".$lens.".php");
	$_SESSION["lan"]=$lens;
}
//common language
if($_SESSION["lan"]=="zh")
{
	$_SESSION["openlist"]="jmenu.jpg";
}elseif($_SESSION["lan"]=="tw")
{
	$_SESSION["openlist"]="fmenu.jpg";
}
//
$sqlkeep=mysql_query("select content from config where sign='15'",$conn);
$keep=@mysql_result($sqlkeep,0,"content");
if($keep==0)
{
	if($_SESSION["user"]!=""||$_SESSION["vip"]!="")
	{
		echo "<div align=center>
		  当前浏览器会话已存在登陆信息，如果重复登陆将清除之前的登陆帐户会话。源码商城ymeso.com
		  <P>
		  如要登陆多帐户请建立会话窗口，或是用其它浏览器进行登陆。[  IE:文件 -> 新建会话 (File -> New session)  ]
		  <BR>
		  <input type=button name=\"exit\" value=\"登陆新帐户\" onclick=\"window.location.href='../opuser/exit.php'\">
		  <input type=button name=\"exit\" value=\"离开\" onclick=\"javascript:window.close()\">
		</div>";
	}else
	{
                $inurl=$_SERVER['HTTP_HOST'];
               if(substr($inurl,0,3)=="nna")
                include("logintemp/readmin1.php");
               else
		include("logintemp/member21.php");
		include("inc/tout_time.inc.php");
	}
}else
{
	$im="";
	include("inc/keep.php");
}
?>