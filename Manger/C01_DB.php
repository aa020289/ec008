<?php
session_start();
require_once("CheckPermission.php");
require_once("../global.php");
require_once("../connect.php");
require_once("Time.php");
unset($_SESSION['OPERATION']);
$_SESSION['OPERATION']="ID";
?>
<HTML>
<HEAD>
<TITLE><?php echo $site_title;?></TITLE>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
</HEAD>
<body>
<?php
check_permision("C");
            //******壓縮圖檔 用 函數******
              function mkthumb( $orig, $thumb, $maxLength ){
                $ext = strtolower(strrchr($orig, "."));
                //依照副檔名, 使用不同函式將原始照片載入記憶體
                switch ($ext){
                case '.jpg':
                  $picSrc = imagecreatefromjpeg($orig);
                  break;
                case '.png':
                  $picSrc = imagecreatefrompng($orig);
                  break;
                case '.gif':
                  $picSrc = imagecreatefromgif($orig);
                  break;
                case '.bmp':
                  $picSrc = imagecreatefrombmp($orig);
                  break;
                default:
                  //傳回錯誤訊息
                  return "不支援 $ext 圖檔格式";
                }

                //取得原始圖的高度 ($picSrc_y) 與寬度 ($picSrc_x)
                $picSrc_x = imagesx($picSrc);
                $picSrc_y = imagesy($picSrc);

                //依照 $maxLength 參數, 計算縮圖應該使用的
                //高度 ($picDst_y) 與寬度 ($picDst_x)
                if ($picSrc_x > $picSrc_y) {
                  $picDst_x = $maxLength;
                  //intval() 可取得數字的整數部分
                  $picDst_y = intval($picSrc_y / $picSrc_x * $maxLength);
                } else {
                  $picDst_y = $maxLength;
                  $picDst_x = intval($picSrc_x / $picSrc_y * $maxLength);
                }

              //在記憶體中建立新圖
              $picDst = imagecreatetruecolor($picDst_x, $picDst_y);

              //將原始照片複製並且縮小到新圖
              imagecopyresized($picDst, $picSrc, 0, 0, 0, 0,
                               $picDst_x, $picDst_y, $picSrc_x, $picSrc_y);

              //將新圖寫入 $thumb 參數指定的縮圖檔名
              imagejpeg($picDst, $thumb);

              return 'ok';
            }

            // ******顯示 指定資料夾的內容******
              function showdir($cuurDIR) {
              $arrDirFile=scandir($cuurDIR);
              unset($arrDirFile[0]);unset($arrDirFile[1]);
              $html='<table border=2><tr><th>資料夾中的檔案</th></tr>';
              foreach($arrDirFile as $name){
                  $html .= '<tr><td>'.'<a href='.$cuurDIR.$name.'>'.$name.'</a></td></tr>';
              }
                $html .= '</table>';
              unset($arrDirFile);
              return $html;
              }

            //************
              // if(! isset($_SESSION['ADMINUSER']) || $_SESSION['ADMIN']) {
              //   echo '<script>alert("犯規~違法~請以 店家 身分登入後再使用這個網頁!");'.'location.href = "login.php";<script>'; 
              //  }
              if(! isset($_SESSION['OPERATION'])) {
                die("犯規~違法~");
              }
              else {
                if (@$_POST["OK"]=="刪除") {
                  $_SESSION['OPERATION']="DELONE";
                }
                else if (@$_POST["adminok"]=="確定修改") {
                  $_SESSION['OPERATION']="UPDONE";
                }
                if (@$_POST["adminok"]=="確定新增") {
                  $_SESSION['OPERATION']="ADDNEW";
                }
                }
              
            if($_SESSION['OPERATION']=="ADDNEW") {
            //******上傳檔案******
              $upload_dir='../upload/'.'images'.'/'; //儲存 原圖 的資料
              $thumb_dir='../img/product'.'/'; //儲存 壓縮過的圖 的資料夾

              echo '$upload_dir='.$upload_dir; //程式寫好後可刪
              if (!is_dir($upload_dir)) mkdir($upload_dir);
              if (!is_dir($thumb_dir)) mkdir($thumb_dir);
              $sourcefile=$_FILES['newproductphoto']['name'];
              if (move_uploaded_file($_FILES['newproductphoto']['tmp_name'],$upload_dir.$sourcefile)){
                //顯示上傳的檔案的相關訊息
                echo '上傳成功...'; //程式寫好後可刪
                echo '<br />原始檔名:' . $_FILES['newproductphoto']['name']; //程式寫好後可刪
                echo '<br />檔案類型:' . $_FILES['newproductphoto']['type']; //程式寫好後可刪
                echo '<br />檔案大小:' . $_FILES['newproductphoto']['size']; //程式寫好後可刪
                echo '<br />暫存檔名:' . $_FILES['newproductphoto']['tmp_name']; //程式寫好後可刪
                $err=mkthumb( $upload_dir.$sourcefile, $thumb_dir.$sourcefile, 168 );
                if ($err != 'OK') {
                  echo '圖檔壓縮錯誤<br>';
                }
                echo "成功儲存".$sourcefile."在".$thumb_dir.'<br>';
              }
              else {
                echo '同名檔案已存在('.$upload_dir . $_FILES['newproductphoto']['name'].')<br>';
              }
              echo '<br>'.showdir($upload_dir); //顯示指定的資料夾裡的內容

            //******新增 商品資料 商品照片資料 到資料庫裡*****
              echo "類別代號=".$_POST['productcategory']."號"; //程式寫好後可刪
              $SQLStr = "insert into 商品 values(".$_POST['newproductnumber'].", ".$_POST['productcategory'].", '".$_POST['newproductname']."', ".$_POST['newproductprice'].", '".$_POST['newcolor']."', '".$_POST['newmaterial']."', ".$_POST['newlength'].")"; //,".$_POST['ChkEnable']."
              echo "<p>SQL=".$SQLStr."</p>"; //程式寫好後可刪
              $rs=mysql_query($SQLStr); //執行SQL新增指令
              if (mysql_error()){
                die( "新增商品 發生錯誤" . mysql_error());
              }
              $SQLStr = "insert into 商品照片 values('".$_FILES['newproductphoto']['name']."',".$_POST['newproductnumber'].")";
              echo "<p>SQL=".$SQLStr."</p>"; //程式寫好後可刪
              $rs=mysql_query($SQLStr); //執行SQL新增指令
              if (mysql_error()){
                die( "新增商品照片 發生錯誤 " .mysql_error());
              }
            }
            else if($_SESSION['OPERATION']=="DELONE") {
              //******照片圖檔名暫存於二維陣列******
                $upload_dir='../upload/'.'images'.'/'; //儲存 原圖 的資料
                $thumb_dir='../img/product'.'/'; //儲存 壓縮過的圖 的資料夾
                $SQLStr = "select 商品照片.* from 商品照片 where 商品照片.商品代號 =".$_POST['delproductno'];
                $rs = mysql_query($SQLStr);
                if (mysql_num_rows($rs)>0) {
                  $total = mysql_num_rows($rs);
                  for ($i=0; $i<$total; $i++) {
                    $row = mysql_fetch_array($rs);
                    $filename[]=$upload_dir.$row['圖檔名'];
                    $filename[]=$thumb_dir.$row['圖檔名'];
                  }
                  $filenames[]=$filename;
                }
              //******刪除商品照片******
                $SQLStr = "delete from 商品照片 where 商品照片.商品代號 =".$_POST['delproductno'];
                echo "<p>SQL=".$SQLStr."</p>";//程式寫好後可刪
                $rs=mysql_query($SQLStr);//執行SOL新增指令
                if (mysql_error()) {
                  die( "刪除商品照片 發生錯誤" . mysql_error() );
                }
                else {
                  echo "刪除".mysql_affected_rows()."筆";
                  $message="商品照片 (".$_POST['delproductno'].") 已刪除";
                  echo "<script type='text/javascript'>alert('".$message."');</script>";

                  //******刪除照片圖檔(從 二維陣列裡 拿出 原圖和小圖 的路徑和檔名)******
                    foreach ($filenames as $fi) {
                      if(@unlink($fi[0]) && @unlink($fi[1])) {
                        $message="已經成功刪除圖檔(".$fi[0].'與'.$fi[1].")";
                        echo "<script type='text/javascript'>alert('".$message."');</script>";
                      }
                      else {
                        $message="無法刪除照片檔案 請自行刪除(".$fi[0].' 與 '.$fi[1].")";
                        echo "<script type='text/javascript'>alert('".$message."');</script>";
                      }
                    }
                }
              //******刪除商品資料******
                $SQLStr = "delete from 商品 where 商品.商品代號 =".$_POST['delproductno'];
                echo $_SESSION['OPERATION']."<p>SQL=".$SQLStr."</p>";//程式寫好後可刪
                $rs=mysql_query($SQLStr);//執行SOL新增指令
                if (mysql_error()) {
                  die( "刪除商品 發生錯誤" . mysql_error() ); 
                }
                else {
                  echo "刪除".mysql_affected_rows()."筆";                
                  echo '<script> alert("(商品'.$_POST['delproductno'].'")已刪除"); </script>'; 
                }
            }
            else if($_SESSION['OPERATION']=="UPDONE") {
              $upload_dir='./upload/'.'images'.'/';//儲存 原圖 的資料夾
              $thumb_dir='../img/product'.'/';//儲存 壓縮過的圖 的資料夾
              $sourcefile=$_FILES['newproductphoto']['name'];
              if (empty($sourcefile)) {
                $sourcefile=$_SESSION['PHOTOfilename'];
                echo "無新檔 用舊的 ".$sourcefile;
              }
              //修改 商品照片資料表的 圖檔名欄位值
              $SQLStr = "update 商品照片 set 商品照片.圖檔名 ='".$sourcefile."' where 商品照片.商品代號=".$_POST['updproductno'];
              echo "<p>SQL=".$SQLStr."</p>";//程式寫好後可刪
              $rs=mysql_query($SQLStr);//執行SOL新增指令
              if (mysql_error()){
                die ( "修改商品照片 發生錯誤 " . mysql_error());
              }
              else{
                echo "修改".mysql_affected_rows()."筆";
                $message="商品照片 (".$_POST['updproductno'].") 已修改";
                echo"<script type='text/javascript'>alert('".$message."');</script>";
                //***************刪除舊的 上傳新的
                if (mysql_affected_rows()>0){//刪除舊的照片圖檔
                  if(!empty($_SESSION['PHOTOfilename'])){
                    if (@unlink($upload_dir.$_SESSION['PHOTOfilename']) && @unlink($thumb_dir.$_SESSION['PHOTOfilename'])){
                      $message="已經成功刪除圖檔(".$upload_dir.$_SESSION['PHOTOfilename'].' 與 '.$thumb_dir.$_SESSION['PHOTOfilename'].")";
                      echo "<script type='text/javascript'>alert('".$message."');</script>";
                    }
                    else{
                      $message="無法刪除照片檔案,請自行刪除(".$upload_dir.$_SESSION['PHOTOfilename'].' 與 '.$thumb_dir.$_SESSION['PHOTOfilename'].")";
                      echo"<script type='text/javascript'>alert('".$message."');</script>";
                    }
                  } 
                  if (!empty($sourcefile)){//上傳新的照片圖檔
                    if (move_uploaded_file($_FILES['newproductphoto']['tmp_name'],$upload_dir.$sourcefile)){
                      $err=mkthumb( $upload_dir.$sourcefile, $thumb_dir.$sourcefile, 168 );
                      if ($err != 'ok'){
                        echo '圖檔壓縮錯誤<br>';
                      }
                    }
                  }
                }
              }
              $SQLStr = "update 商品 set 商品.商品名稱='".$_POST['newproductname']."', 商品.單價=".$_POST['newproductprice'].", 商品.顏色='".$_POST['newcolor']."', 商品.材質='".$_POST['newmaterial']."', 商品.庫存量=".$_POST['newlength']." where 商品.商品代號=".$_POST['updproductno'];
              echo $_SESSION['OPERATION']."<p>SQL=".$SQLStr."</p>";//可刪
              $rs=mysql_query($SQLStr);
              if (mysql_error()){
                die( "修改商品 發生錯誤 " . mysql_error());
              }
              else{
                echo "修改".mysql_affected_rows()."筆";
                echo '<script> alert("商品'.$_POST['updproductno'].'")已修改");</script>';
              }
              $_SESSION['OPERATION']="ID";
            }
              
              // $SQLStr = "select 商品.商品代號,商品照片.圖檔名,商品.商品名稱,商品.單價 
              //       from 商品 inner join 商品照片 
              //       where 商品.商品代號=商品照片.商品代號 
              //       order by 商品.類別代號 ,商品.商品代號";
              // echo '<br>SQLStr ='.$SQLStr.'<br>';
              // $rs = mysql_query($SQLStr);
              // echo("共有 ".mysql_num_rows($rs)."個商品*****");
              // if(mysql_num_rows($rs) > 0) {
              //   $total = mysql_num_rows($rs);
              //   for ($i=0; $i<$total; $i++) {
              //     $row = mysql_fetch_array($rs);
              //     echo "<li>";
              //     echo '<a href="product.html" class="preview" title="Preview">';
              //     echo '<img src="images/'.$row["圖檔名"].' " alt="Img"> <span class="icon"></span></a> <span>'
              //       .$row["單價"].'元</span>'.$row["商品名稱"].' <em>Quick Shop</em> 
              //       <form action="addandbrowse.php" method="POST">
              //       <input type=submit name="OK" value="刪除" class="btn-cart">
              //       <input type=hidden name="delproductno" value="'.$row['商品代號'].'">
              //       </form>
              //       <form action="editproduct.php" method="POST">
              //       <input type=submit name="OK" value="修改" class="btn-wish">
              //       <input type=hidden name="updproductno" value="'.$row['商品代號'].'">
              //       </form>';
              //     echo "</li>";
              //   }
              // }   
?>
<SCRIPT language=javascript>
<!--
	alert ("成功!"); 
	location.href='C01.php';
//-->
</SCRIPT>
</body>
</html>
