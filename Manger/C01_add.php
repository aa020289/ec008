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
	<title><?php echo $site_title;?></title>
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

// function jsCheck() 
// { 
// 	if (ChkImp('MPassword',document.form1.MPassword.value,'密碼') == false) return false;
// 	if (ChkImp('MPasswordCheck',document.form1.MPasswordCheck.value,'確認密碼') == false) return false;
// 	if (jsTrim(document.form1.MPassword.value) != jsTrim(document.form1.MPasswordCheck.value))
// 	{
// 		alert ('您輸入的密碼與確認密碼不相同，請重新輸入！');
// 		document.form1.MPassword.value = '';
// 		document.form1.MPasswordCheck.value = '';
// 		document.form1.MPassword.focus();
// 		return false;
// 	}
// 	if (ChkImp('MName',document.form1.MName.value,'姓名') == false) return false;
// 	if (ChkEmail('MEMail',document.form1.MEMail.value,'E-Mail') == false) return false;

// }

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
check_permision("C");

// $SQL_select="select max(RID) from account";
// $result_select=mysql_query($SQL_select,$link) or die ("無法執行查詢");
// $MAX=mysql_result($result_select,0);

// $MAX=$MAX+1;

// $會員代號="AA".$MAX;

?>
<?php include "Mindex1.php" ?>
<br>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
        
    <td width="4" class="area_spacer"><!-- 中間的空白 --></td>
    <td width="100%" valign="top"><!-- Main Body -->
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td width="30"><img src="images/title_color_block_01.gif" width="30" height="40" /></td>
          <td class="system_title_cht">商品資料管理 - 新增</td>
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

		    <form action="C01_DB.php" method="post" enctype="multipart/form-data"> <!--改-->
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td height="10"></td>
            </tr>
          </table>
            
            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
              <!-- <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn"><font color="red">*</font>會員代號 ：</td>
                <td colspan="3" class="list_txt"><?=htmlspecialchars($會員代號)?><input name="ID" type="hidden" value="<?=$會員代號?>"></td>
              </tr> -->
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn"><font color="red"></font>商品照片 ：</td>
                <td colspan="3" class="list_txt">
                <input type="file" name="newproductphoto" value="img9.jpg" id="newproductphoto" /></td>
              </tr>
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn"><font color="red">*</font>類別代號 ：</td>
                <td colspan="3" class="list_txt">
                <input name="productcategory" type="text" class="form_input_w200" maxlength="10" id="productcategory" /></td>
              </tr>
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn"><font color="red">*</font>商品代號 ：</td>
                <td colspan="3" class="list_txt">
				        <input name="newproductnumber" type="text" class="form_input_w200" maxlength="20" id="newproductnumber"></td>
              </tr>
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>                                                        
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn"><font color="red">*</font>商品名稱 ：</td>
                <td colspan="3" class="list_txt">
                <input name="newproductname" type="text" class="form_input_w200" maxlength="20" id="newproductname"></td>
                </tr>
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>                                                        
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn"><font color="red"></font>單價 ：</td>
                <td colspan="3" class="list_txt">
                <input name="newproductprice" type="text" class="input-name" maxlength="20" id="newproductprice"></td>
                </tr>
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>                                                    
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn"><font color="red"></font>顏色 ：</td>
                <td colspan="3" class="list_txt">
                <input name="newcolor" type="text" class="input-name" maxlength="10" id="newcolor"></td>
                </tr>
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>                                                        
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">材質 ：</td>
                <td colspan="3" class="list_txt">
                <input name="newmaterial" type="text" class="input-name" maxlength="30" id="newmaterial"></td>
                </tr>
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>                                                                                                               
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">庫存量 ：</td>
                <td colspan="3" class="list_txt">
                <input name="newlength" type="text" class="input-name" maxlength="20" id="newlength"></td>
                </tr>
              <!-- <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>                                                                                                               
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">會員階級 ：</td>
                <td colspan="3" class="list_txt"><select name="會員階級" class="txt_input_180" id="會員階級">
                	  <option value="一般會員">一般會員</option>
                    <option value="白金會員">白金會員</option>
                	</select></td>
              </tr> -->
              <!-- <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
              <tr onmouseout="style.backgroundColor='#ffffff';" onmouseover="style.backgroundColor='#F0F0F0';">
                <td width="110" align="right" class="list_sn">客製化：</td>
                <td colspan="3" class="list_txt">
                	<input name="ChkEnable" type="radio" id="radio" value="Y" />有
                	<input name="ChkEnable" type="radio" id="radio2" value="N" checked="checked" /><font color="red">無</font>
                </td>
              </tr> -->
              <tr>
                <td colspan="4" background="images/body_sep_line.gif" height="2"></td>
              </tr>
            </table>
            <table width="93%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="27%" height="50" align="right">
                <input type="image" src="images/btn_save_off.gif" name="adminok" value="確定新增"></td>             
                <td width="73%">
                  <!-- chk data saved or not --></td>
              </tr>
            </table></form></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"></td>
        </tr>
      </table></td>
  </tr>
</table>
<br />
</body>
</html>
