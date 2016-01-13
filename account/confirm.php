<?php
session_start();
require_once("../connect.php");
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
    <head>
        <title>WINTER</title>
        <meta charset="utf-8">
        <meta name="author" content="pixelhint.com">
        <meta name="description" content="La casa free real state fully responsive html5/css3 home page website template"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

        <link rel="stylesheet" type="text/css" href="../css/reset.css"> <!--封面圖排版-->
        <link rel="stylesheet" type="text/css" href="../css/responsive2.css"> <!--排版-->
        <link rel="stylesheet" type="text/css" href="../css/styleT.css"> <!--排版-->

        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/main.js"></script>

        <script type="text/javascript"> //滑動方式至頁頂
                    $(function () {
                    $("#gotop").click(function () {
                    jQuery("html,body").animate({
                    scrollTop: 0
                    }, 1000);
                    });
                            $(window).scroll(function () {
                    if ($(this).scrollTop() > 300) {
                    $('#gotop').fadeIn("fast");
                    } else {
                    $('#gotop').stop().fadeOut("fast");
                    }
                    });
            });</script>
    </head>
    <body>
        <section class="hero">
            <header>
                <div class="wrapper">
                    <a href="../index.php"><img src="../img/logo.png" class="logo" alt="" titl=""/></a>
                    <a href="#" class="hamburger"></a>
                    <nav>
                        <ul>
                            <li><a href="./shop.php">shop</a></li>
                            <li><a href="../allproducts.php">All</a></li>
                            <li><a href="checkout.php?gotocart=1">Cart</a></li>
                            <li><a href="../about.php">About</a></li>
                        </ul>
                        <?php
                        if (!isset($_SESSION["reg_MUID"])) {
                            echo '<a href="./index.php" class="login_btn">Login</a>';
                            //echo '|' . '<a href="./register.php">註冊</a>';
                        } else {
                            echo '<a href="./logout.php" class="login_btn">Logout</a>';
                        }
                        ?>
                    </nav>
                </div>
            </header><!--  end header section  -->

            <section class="caption">
                
            </section>
        </section><!--  end hero section  -->

            <section class="listings"> <!--CSS：main、responsive-->
                <div class="wrapper">               
                    <!--<ul class="properties_list">-->
                        <!--<div class="property_details">-->
                            <div id="contents">
                                <div id="checkout">
                                    <?php
                                    if (!isset($_SESSION["reg_MUID"])) {
                                        echo '<script>alert("請先登入～！");' .
                                        'location.href = "index.php";</script> ';
                                    }
                                    ?>
                                    <h4><span>購物明細</span></h4>
					<table>
							<?php
								//*** 在購物車裡 按下 『下一步』按鈕 進來 這個網頁
								//*** 先查詢出 此人購物車裡的 所有商品的明細
								if (empty($_POST["confirmOK"])) {
									//*** 這個時候 還沒開始 產生訂單
									$confirm_finish="NO";
									// 查詢 購物車中 所有 購物明細
									//****提示**** 以下『一條』指令要改	
									//****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡  A
									$SQLStr = "select 購物車.商品代號,商品.商品名稱,購物車.數量,購物車.單價,商品.庫存量,商品照片.圖檔名 
												FROM 購物車 inner join 商品 on 購物車.商品代號=商品.商品代號 
												left outer join 商品照片 on 購物車.商品代號=商品照片.商品代號 
												WHERE 購物車.帳號='".$_SESSION["reg_MUID"]."'";
								}
								//*** 按下 『確認無誤結帳』按鈕 又進來 這個網頁
								//*** 現在要開始 產生 新的訂單
								else {	
										// 查詢 購物車 是否有商品 (為了防止 重新整理網頁時 購物車中沒有商品卻產生新訂單)
										//****提示**** 以下『兩條』指令要改	
										//****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡								
										$SQLStr = "select count(商品代號) as 商品數量 FROM 購物車 WHERE 帳號='".$_SESSION["reg_MUID"]."'";
										//echo '<br>查 購物車中是否有商品→'.$SQLStr."<br>";
										$rs = mysql_query($SQLStr); 
										$row = mysql_fetch_array($rs);
										if ($row['商品數量']==0) {
											die("購物車中無商品");
										}
										//確定 結帳
										//決定 新的訂單編號 
										//調整時區 問今天日期 年-月-日 時:分:秒 只問年 只問月 只問日
										date_default_timezone_set('Asia/Taipei');
										$datetime= date("Y-m-d H:i:s");
										$d= date("Y").date("m").date("d");
										// 查詢 某日 訂單 的訂單編號裡的流水號 最大值
										//****提示**** 以下『兩條』指令要改
										$SQLStr = "select Max(substr(訂單編號,9,4)) as 最大流水號 FROM 訂單 
													WHERE substr(訂單編號,1,8)='".$d."'";
										//echo '<br>查 最大流水號→'.$SQLStr;
										$rs = mysql_query($SQLStr); 
										$row = mysql_fetch_array($rs);
										// 決定 新訂單 的 訂單編號，並且儲存在 $orderno 變數裡
										//****提示**** 以下『兩條』指令要改
										//****提示**** 當日訂單 用的流水號最大值 在 $row['最大流水號'] 變數裡
										//****提示**** 當日 年月日 接起來 在 $d 變數裡
										if ($row['最大流水號']==null) {
											$orderno=$d.'1001';
										}
										//****提示**** 以下『一條』指令要改
										//****提示**** 當日訂單 用的流水號最大值 在 $row['最大流水號'] 變數裡
										//****提示**** 當日 年月日 接起來 在 $d 變數裡
										else {
											$orderno=$d.($row['最大流水號']+1);
										}
										//echo '<br>新訂單編號→'.$orderno;
										//****新增一張新的訂單 **** 物流方式為『超商取貨』
										//****提示**** 以下『一條』指令要改
										//****提示**** 訂單編號 在 $orderno 變數裡， 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										//****提示**** 訂購日期 在 $datetime 變數裡，取貨門市代號在 $_POST['cvs711no'] 變數裡
										//****提示**** 物流方式 在 $_POST['logistics'] 變數裡
										if ($_POST['logistics']=="超商取貨"){										
											$SQLStr = "insert into 訂單(訂單編號,帳號,門市代號,訂購日期,物流方式) values(
														'".$orderno."',
														'".$_SESSION["reg_MUID"]."',
														'".$_POST['cvs711no']."',
														'".$datetime."',
														'".$_POST['logistics']."')";
										}
										//****新增一張新的訂單 **** 物流方式為『宅配』
										//****提示**** 以下『一條』指令要改
										//****提示**** 訂單編號 在 $orderno 變數裡， 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										//****提示**** 訂購日期 在 $datetime 變數裡，物流方式 在 $_POST['logistics'] 變數裡
										else {
											$SQLStr = "insert into 訂單(訂單編號,帳號,訂購日期,物流方式) values(
														'".$orderno."',
														'".$_SESSION["reg_MUID"]."',
														'".$datetime."',
														'".$_POST['logistics']."')";
										}
										//echo '<br>新增 訂單→'.$SQLStr;
										//****提示**** 以下『一條』指令要改
										//****提示**** SQL指令記得 送進 資料庫 執行
										$rs = mysql_query($SQLStr); 
										//echo("<br>共新增 <font color=red>".mysql_affected_rows()."</font> 張訂單*****");
										//****當 物流方式為『宅配』，還要新增一筆 宅配收貨資料，收貨代號 同訂單編號
										//****提示**** 以下『兩條』指令要改
										//****提示**** 收貨代號和訂單編號都 在 $orderno 變數裡
										if ($_POST['logistics']=="宅配"){	
											$SQLStr = "insert into 宅配(收貨代號,訂單編號) values('".$orderno."','".$orderno."')";
											//echo '<br>新增 宅配→'.$SQLStr;
											$rs = mysql_query($SQLStr); 
											//echo("<br>共新增 <font color=red>".mysql_affected_rows()."</font> 張宅配送貨*****");		
										}
										//**** 購物車裡的購物明細  都加入 訂單明細 
										//**** 作法：查詢出購物車中所有購買商品之後，整批新增到訂單明細裡
										//****提示**** 以下『兩條』指令要改
										//****提示**** 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										//****提示**** 訂單編號 在 $orderno 變數裡
										//****提示**** 優惠方式 預設為'1'，處理狀態 預設為'收到訂單'
										$SQLStr = "insert into 訂單明細 SELECT '".$orderno."' 
													as 訂單編號,商品代號,單價,數量,'1' as 優惠方式,'收到訂單' as 處理狀態 
													FROM 購物車 WHERE 帳號='".$_SESSION["reg_MUID"]."'";
										//echo '<br>加入 訂單明細→'.$SQLStr;
										$rs = mysql_query($SQLStr);
										//echo("<br>共新增<font color=red>".mysql_affected_rows()."</font>筆訂單明細*****");
										//**** 修改 商品的庫存量(只能對這台 購物車裡的商品 減少 庫存量)
										//**** 作法：查詢出購物車中每一樣購買商品的數量之後，再由庫存 扣掉 購買的數量
										//****提示**** 以下『兩條』指令要改
										//****提示**** 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										$SQLStr = "update 商品 set 庫存量=庫存量-
													(select 數量 from 購物車 where 帳號='".$_SESSION["reg_MUID"]."' and 購物車.商品代號=商品.商品代號) 
													WHERE exists(select * from 購物車 where 帳號='".$_SESSION["reg_MUID"]."' 
													and 購物車.商品代號=商品.商品代號)";
										//echo '<br>修改 商品的庫存量→'.$SQLStr;
										$rs = mysql_query($SQLStr);
										//echo("<br>共修改<font color=red>".mysql_affected_rows()."</font>筆商品的庫存量*****");
										//**** 清空 購物車（刪除購物車裡的　所有商品）
										//****提示**** 以下『兩條』指令要改
										//****提示**** 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										$SQLStr = "delete FROM 購物車 WHERE 帳號='".$_SESSION["reg_MUID"]."'";
										//echo '<br>刪除 購物車明細→'.$SQLStr;
										$rs = mysql_query($SQLStr);
										//echo("<br>共刪除<font color=red>".mysql_affected_rows()."</font>筆購物車明細*****");
										//**** 終於結帳結好了，重新查詢 這張新訂單的訂單明細
										//****提示**** 以下『兩條』指令要改（其中一條在遠遠的那裡～）
										//****提示**** 此　訂單編號在　$orderno 變數裡										
										$SQLStr = "select 訂單明細.訂單編號,訂單明細.單價,訂單明細.數量,商品.商品名稱,商品.庫存量,商品照片.圖檔名 
													FROM 訂單明細 
													inner join 商品 on 訂單明細.商品代號=商品.商品代號 
													left outer join 商品照片 on 商品.商品代號=商品照片.商品代號 
													WHERE 訂單明細.訂單編號='".$orderno."'";
							?>
							<!-- ****顯示**** 從資料庫撈回來的訂單明細資料在網頁裡  -->
							<thead>
								<!-- ****提示**** 以下『一條』指令要改  -->
								<!-- ****提示**** 這張訂單的訂單編號   在　$orderno　變數裡 -->
								<tr>
									<th colspan=5>您的訂單編號是： <?php echo $orderno;?></th>
								</tr>
							<?php
								}							
								//echo "<br>".$SQLStr;
								$rs = mysql_query($SQLStr); //****提示**** 別忘了 這條指令 要修改  對到 A
							?>								
								<tr>
									<th>購買商品</th>
									<th>數量</th>
									<th>單價</th>
									<th>小計</th>
									<th>現貨庫存</th>
								</tr>
								</thead>
								<?php
								if (mysql_num_rows($rs)>0) { 
									$total_payment=0;
									$total = mysql_num_rows($rs); 
									for ($i=0; $i<$total; $i++)      {
										$row = mysql_fetch_array($rs);
										$total_payment=$total_payment*1+$row['單價']*$row['數量'];
								?>	
						<tbody>							
								<tr>	
									<!-- ****提示**** 以下『七條』指令要改  -->
									<!-- ****提示**** 商品照片的圖檔名稱 在 $row['圖檔名'] 變數裡 -->
									<!-- ****提示**** 商品的名稱 在 $row['商品名稱'] 變數裡 -->
									<!-- ****提示**** 商品的購買數量 在 $row['數量'] 變數裡 -->
									<!-- ****提示**** 商品的價錢 在 $row['售價'] 變數裡 -->
									<!-- ****提示**** 記得計算 單項商品 的小計金額 -->
									<!-- ****提示**** 商品的庫存量 在 $row['庫存量'] 變數裡 -->
									<!-- ****提示**** 購買商品的項目 在 $total 變數裡 -->
									<!-- ****提示**** 消費總金額 在 $total_payment 變數裡 -->
									<td><img src="../img/product/<?php echo $row['圖檔名']; ?>" style="width:110px;height:90px;" alt="NoPhoto"> <b><?php echo $row['商品名稱'];?></b></td>
									<td>
										<?php echo $row['數量'];?>
									</td>
									<td>
										<?php echo $row['單價'];?>
									</td>
									<td>
										<?php echo $row['數量'] * $row['單價'];?>
									</td>
									<td class="last"><div>
										<?php if ($row['庫存量']>=1) {echo "有";} else {echo "無";}?>
									</div></td>
								</tr> 								
							<?php
									}
							?> 
								<tr>								
									<td colspan=2 align=right>共<?php echo $total;?>項商品</td>
									<td class="last">總計<?php echo "NT$".$total_payment;?> </td>
								</tr> 								
							<?php							
								}
							?> 
						</tbody>
					</table>
					<?php
						//**** 如果物流方式 是 超商取貨
						//**** 在產生新訂單之前 要先 選擇一間 取貨門市
						if (@$confirm_finish=="NO") {
					 ?>
						<form name="form1" action="confirm.php" method="post">
						<?php
							if ($_POST['logistics']=="超商取貨"){
						?>
						<select name="cvs711no" id="size">
										<option value="0">選擇一間便利商店</option>
								<?php
									//**** 查詢出 所有便利商店門市，而且按照指定順序排好
									//****提示**** 以下『兩條』指令要改
									$SQLStr = "select 門市代號,門市名稱 FROM cvs711 order by 縣市,鄉鎮市區,門市代號";
									$rsC = mysql_query($SQLStr);   
									if (mysql_num_rows($rsC)>0) {
										$totalC = mysql_num_rows($rsC); 
										for ($i=0; $i<$totalC; $i++)      {
											$rowC = mysql_fetch_array($rsC);
												echo "<option value='".$rowC['門市代號']."'>".$rowC['門市名稱']."</option>";
												//**** 顯示 所有便利商店門市，在網頁表單的下拉式選單裡
												//****提示**** 以上『一條』指令要改
												//****提示**** 門市代號 號在 $rowC['門市代號'] 變數裡，名稱在$rowC['門市名稱'] 變數裡
										}
									}
								?>
						</select>
							<?php
								}
							?>
							<!-- ****提示**** 以下『一條』指令要改  -->
							<!-- ****提示**** 物流方式 用隱藏欄位，跟著表單上的其他資料一起送出 -->
							<!-- ****提示**** 物流方式 在 $_POST['logistics'] 變數裡 -->
							<input type="hidden" name="logistics" value="<?php echo $_POST['logistics']; ?>">
							<input type="submit" name="confirmOK" value="確認無誤結帳" class="proceed-btn" >
						</form>
					<?php 
						}
					?>
                                </div>
                            </div>

                        <!--</div>-->                   
                    <!--</ul>-->

            <div class="more_listing">
                <a href="#" class="more_listing_btn" id="gotop">返回頂部</a>
            </div>
            </div>
        </section>	<!--  end listing section  -->
		
    </body>
</html>
