<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh">
<?php
session_start();
require_once("../global.php");
require_once("../connect.php");
require_once("CheckPermission.php");
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $site_title; ?></title>
<link rel="stylesheet" href="menu_style.css" type="text/css" />
<link rel="stylesheet" href="body.css" type="text/css" />
<link href="form.css" rel="stylesheet" type="text/css" />
<link href="page.css" rel="stylesheet" type="text/css" />
<link href="title.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
//防滑鼠右鍵  
document.oncontextmenu=function(){  
    return false;  
}  
</script>
<script type="text/javascript">
<!--
var XMLHttpRequestObject = false;
if (window.XMLHttpRequest){
	XMLHttpRequestObject = new XMLHttpRequest();
}else if(window.ActiveXObject){
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function jsCheck() 
{ 
	if (ChkImp('MPassword',form1.MPassword.value,'密碼') == false) return false;
	if (ChkImp('MPasswordCheck',form1.MPasswordCheck.value,'確認密碼') == false) return false;
	if (jsTrim(form1.MPassword.value) != jsTrim(form1.MPasswordCheck.value))
	{
		alert ('您輸入的密碼與確認密碼不相同，請重新輸入！');
		document.form1.MPassword.value = '';
		document.form1.MPasswordCheck.value = '';
		document.form1.MPassword.focus();
		return false;
	}
	if (ChkImp('MName',form1.MName.value,'姓名') == false) return false;
	if (ChkEmail('MEMail',form1.MEMail.value,'E-Mail') == false) return false;
	if (form1.MPer[0].checked == false && form1.MPer[1].checked == false && form1.MPer[2].checked == false && form1.MPer[3].checked == false)
	{
		alert ('您必須選擇一項權限！');
		document.form1.MPer[0].focus();
		return false;
	}
}


//-->
</script>
<Script LANGUAGE="Javascript" SRC="../function/CheckForm.js"></Script>
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>
</head>

<body onload="MM_preloadImages('images/btn_save_on.gif')">
<?php
check_permision("A");
$MUID = $_POST["MUID"];
if (trim($MUID) == "")
{
?>
	<SCRIPT language=javascript>
	<!--
		alert ("查無資料！"); 
		history.go(-1);
	//-->
	</SCRIPT>
<?php	
	exit;
}

$SQL_select="select * from Manger where DelTag = 'N' and MUID = '" . $MUID . "';";
$result_select=mysql_query($SQL_select,$link) or die ("無法執行查詢");

if (mysql_num_rows($result_select) == 0)
{
	mysql_free_result($result_select);
	mysql_close($link);
?>
	<SCRIPT language=javascript>
	<!--
		alert ("查無資料，請冾網站管理員！"); 
		history.go(-1);
	//-->
	</SCRIPT>
<?php	
	exit;
}
$row=mysql_fetch_array($result_select,MYSQL_ASSOC);

?>
    <?php include "Mindex1.php" ?>
<br>
<br>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>       
    <td width="4" class="area_spacer"><!-- 中間的空白 --></td>
    <td width="100%" valign="top"><!-- Main Body -->
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td width="30"><img src="images/title_color_block_01.gif" width="30" height="40" /></td>
          <td class="system_title_cht">權限管理</td>
        </tr>
      </table>
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="5"></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">
		<form name="form1" method="post" action="J02_editDB.php" onSubmit="return jsCheck();" enctype="multipart/form-data">
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td height="10"></td>
            </tr>
          </table>
            
            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">員工編號 ：</td>
                <td colspan="3" class="list_txt"><?=htmlspecialchars($row["ID"])?><input name="ID" type="hidden" value="<?=$row["ID"]?>"></td>
              </tr>
                          <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">帳號 ：</td>
                <td colspan="3" class="list_txt"><?=htmlspecialchars($row["MUID"])?><input name="MUID" type="hidden" value="<?=$row["MUID"]?>"></td>
              </tr>
            <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">姓名 ：</td>
                <td colspan="3" class="list_txt"><?=htmlspecialchars($row["MName"])?><input name="MName" type="hidden" value="<?=$row["MName"]?>"></td>
              </tr>
            <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">職務類別 ：</td>
                <td colspan="3" class="list_txt"><?=htmlspecialchars($row["職務類別"])?><input name="職務類別" type="hidden" value="<?=$row["職務類別"]?>"></td>
              </tr>
                            <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">權限設定 ：</td>
                <td colspan="3" class="list_txt">
                <table width="95%" border="0" cellpadding="0" cellspacing="1">
<?php if (trim(strstr($row["MPer"],'A')) != ""){?>
<tr >
                    <td colspan="3" >A.權限</td>
                  </tr>
<?php }?>
<?php if (trim(strstr($row["MPer"],'B')) != ""){?>
<tr >
                    <td colspan="3" >B.其它1</td>
                  </tr>
<?php }?>
<?php if (trim(strstr($row["MPer"],'C')) != ""){?>
<tr >
                    <td colspan="3" >C.其它2</td>
                  </tr>
<?php }?>
                </table></td>
               <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
                </tr>
            </table>
</form></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"></td>
        </tr>
      </table></td>
  </tr>
</table>
<br />
<center><a href="A03.php"><img src="images/back.bmp" alt="回權限查詢"/</a></center>
</body>
</html>
<?php
mysql_free_result($result_select);
mysql_close($link);
?>