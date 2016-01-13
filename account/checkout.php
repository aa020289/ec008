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
        <link rel="stylesheet" type="text/css" href="../css/styleT.css"> <!--結帳排版-->

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

        <script>
            function qtyplus1(idx, maxqty) { /*< !--數量 + 1-- >*/ if (document.forms[idx].buyqty.value < maxqty) { 
            /*< !--maxqty庫存數量-- >*/ document.forms[idx].buyqty.value = document.forms[idx].buyqty.value * 1 + 1;
            }
            document.forms[idx].submit();
            }
            function qtyminus1(idx) { /*< !--數量 - 1-- >*/ if (document.forms[idx].buyqty.value > 1) {
            document.forms[idx].buyqty.value = document.forms[idx].buyqty.value * 1 - 1;
                    document.forms[idx].submit();
            }
            }
            function qtychange(idx, maxqty, currqty) {/*<!--數量直接改-->*/
                if (document.forms[idx].buyqty.value > 1 && document.forms[idx].buyqty.value < maxqty) {
                    document.forms[idx].submit();
                }
                else {
                    document.forms[idx].buyqty.value = currqty;
                }
            }
            function goback_shop() {
                window.location = "shop.php";
            }
        </script>
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

            <div class="wrapper">
                <div id="secondary">
                    <p><input type=button name=backtobrowse value='回瀏覽商品' onclick='goback_shop();'></p>                              
                </div>
            </div>
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
                                    <?php
                                    // 因為按下某一樣商品的『加到購物車』按鈕，所以進到這個網頁裡面來              
                                    if (isset($_POST['addCartOK'])) {
                                        // 查詢 此人的購物車中 是否已經有這樣商品
                                        //****提示**** 以下『兩條』指令要改 
                                        //****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡
                                        //****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡
                                        $SQLStr = "select * from 購物車 where 帳號='" . $_SESSION["reg_MUID"] . "' 
                                        and 商品代號='" . $_POST['buyproductno'] . "'";
                                        ;
                                        //"SELECT * FROM 購物車 WHERE 帳號='championliu'and 商品代號=109";
                                        //echo '<br>SQLStr ='.$SQLStr.'<br>';
                                        $rs = mysql_query($SQLStr);

                                        if (mysql_num_rows($rs) == 0) {    // 如果沒有→做 商品新增到購物車（買一個）
                                            // 問：這個商品的售價
                                            //****提示**** 以下『兩條』指令要改 
                                            //****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡
                                            $SQLStr = "select 商品.單價 from 商品 where 商品代號 = '" . $_POST['buyproductno'] . "'";
                                            $rs = mysql_query($SQLStr);
                                            $row = mysql_fetch_array($rs);
                                            date_default_timezone_set('Asia/Taipei');   //設定時區
                                            $datetime = date("Y/m/d H:i:s");             //問現在的系統日期、時間
                                            // 新增這個商品到購物車（買一個）
                                            //****提示**** 以下『兩條』指令要改
                                            //****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡                             
                                            //****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡 
                                            //****提示**** 這個商品的購買數量 在 $_POST['buyqty'] 裡
                                            //****提示**** 這個商品的售價 在  $row['價錢'] 裡
                                            //****提示**** 這個商品加進購物車的時間 在 $datetime 裡
                                            $SQLStr = "insert into 購物車 values(
                                            '" . $_SESSION["reg_MUID"] . "',
                                            " . $_POST['buyproductno'] . ",
                                            " . $_POST['buyqty'] . ",
                                            " . $row['單價'] . ",'" . $datetime . "')";
                                            //echo '<br>SQLStr =' . $SQLStr . '<br>';
                                            $rs = mysql_query($SQLStr);
                                            //echo("共新增" . mysql_affected_rows() . "個購物車中商品*****");
                                        } else {  // 如果有→做 購買數量修改（多買一個）
                                            //****提示**** 以下『兩條』指令要改
                                            //****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡                             
                                            //****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡 
                                            $SQLStr = "update 購物車 SET 數量=數量+1 
                                                    WHERE 帳號='" . $_SESSION["reg_MUID"] . "' and 商品代號=" . $_POST['buyproductno'];
                                            //echo '<br>SQLStr =' . $SQLStr . '<br>';
                                            $rs = mysql_query($SQLStr);
                                            //echo("共修改" . mysql_affected_rows() . "個購物車中商品*****");
                                        }
                                    }
                                    // 在購物車裡，因為按下某一樣商品的『Delete』按鈕，所以進到這個網頁裡面來
                                    // 不買了～　刪除 購物車中 這樣商品
                                    else if (isset($_POST['delCartOK'])) {
                                        //****提示**** 以下『兩條』指令要改
                                        //****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡                             
                                        //****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡 
                                        $SQLStr = "delete FROM 購物車 
                                            WHERE 帳號 = '" . $_SESSION["reg_MUID"] . "' and 商品代號=" . $_POST['buyproductno'];
                                        //echo '<br>SQLStr =' . $SQLStr . '<br>';
                                        $rs = mysql_query($SQLStr);
                                        //echo("共刪除" . mysql_affected_rows() . "個購物車中商品*****");
                                    }
                                    // 在購物車裡，因為按下某一樣商品的『+』或『-』按鈕，所以進到這個網頁裡面來（不是因為點了導覽列的『看購物車』）
                                    // 僅修改 購物車中 商品 購買數量
                                    else if (@$_GET['gotocart'] != 1) {
                                        //****提示**** 以下『兩條』指令要改
                                        //****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡                             
                                        //****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡
                                        //****提示**** 這個商品的購買數量 在 $_POST['buyqty'] 裡
                                        $SQLStr = "update 購物車 set 購物車.數量=".$_POST['buyqty']." 
                                            WHERE 帳號='" . $_SESSION["reg_MUID"] . "' and 商品代號=" . $_POST['buyproductno'];
                                        //echo '<br>SQLStr =' . $SQLStr . '<br>';
                                        $rs = mysql_query($SQLStr);
                                        //echo("共修改" . mysql_affected_rows() . "個購物車中商品的數量*****");
                                    }
                                    ?>

                                    
                                            <?php
                                            // 查詢 這個會員的購物車中 所有 購買商品明細
                                            //****提示**** 以下『兩條』指令要改
                                            //****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡 
                                            $SQLStr = "SELECT 購物車.商品代號,購物車.數量,購物車.單價,商品.商品名稱,商品照片.圖檔名,商品.庫存量  
                                        FROM 購物車 inner join 商品 on 購物車.商品代號=商品.商品代號 left outer join 商品照片 on 商品.商品代號=商品照片.商品代號 
                                        WHERE 購物車.帳號='" . $_SESSION["reg_MUID"] . "' ";
                                            $rs = mysql_query($SQLStr);
                                            if (mysql_num_rows($rs) > 0) {
                                                $total_paymet = 0;
                                                //問：商品買幾樣、算：購物總金額
                                                $total = mysql_num_rows($rs);
                                                for ($i = 0; $i < $total; $i++) {
                                                    $row = mysql_fetch_array($rs);
                                                    //****提示**** 以下『一條』指令要改
                                                    //****提示**** 這個商品的售價 在 $row['售價'] 裡
                                                    //****提示**** 這個商品的購買數量 在 $row['數量'] 裡
                                                    $total_paymet = $total_paymet * 1 + $row['單價'] * $row['數量'];
                                                    ?>
                                                    <h4><span>購物明細</span></h4>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>商品</th>
                                                                <th>數量</th>
                                                                <th>單價</th>
                                                                <th>小計</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>      
                                                    <!-- 顯示 購物車中所有商品 每樣商品也都有自己的表單（為了做購買數量＋－或商品刪除） -->
                                                    <tr>
                                                <form name="buyform" action="checkout.php" method="post">
                                                    <!-- ****提示**** 以下『兩條』指令要改 -->
                                                    <!-- ****提示**** 這個商品的照片圖檔名 在 $row['圖檔名'] 裡 -->
                                                    <!-- ****提示**** 這個商品的名稱 在 $row['商品名稱'] 裡 -->
                                                    <!-- ****提示**** 這個商品的類別名稱 在 $row['商品代號'] 裡 -->
                                                    <td><img src="../img/product/<?php echo $row['圖檔名']; ?>" style="width:110px;height:90px;" alt="Thumbnail"> 
                                                        <b><?php echo $row['商品名稱'];?></b>
                                                        <p><?php echo $row['商品代號'];?></p></td>
                                                    <td>
                                                        <!-- ****提示**** 以下『三條』指令要改 -->
                                                        <!-- ****提示**** 這個商品的購買數量 在 $row['數量'] 裡 -->
                                                        <!-- ****提示**** 這個商品的庫存量 在 $row['庫存量'] 裡 -->
                                                        <!-- ****提示**** 這個商品的代號 在 $row['商品代號'] 裡 -->
                                                        <input type="text" name="buyqty" value="<?php echo $row['數量']; ?>" class="txtfield" onChange="qtychange(<?php echo $i; ?>,<?php echo $row['庫存量']; ?>,<?php echo $row['數量']; ?>);">
                                                        <input type="hidden" name="buyproductno" value="<?php echo $row['商品代號']; ?>">
                                                        <img src="../img/minus1.png" onClick="qtyminus1(<?php echo $i; ?>);" class="minus"> 
                                                        <img src="../img/plus1.png" onClick="qtyplus1(<?php echo $i; ?>,<?php echo $row['庫存量']; ?>);" class="plus">   
                                                    </td>
                                                    <td class="last"><div>
                                                            <!-- ****提示**** 以下『一條』指令要改 -->
                                                            <!-- ****提示**** 這個商品的售價 在 $row['售價'] 裡 -->
                                                            <?php echo $row['單價']; ?>
                                                        </div></td>
                                                    <td class="last"><div>
                                                            <!-- ****提示**** 以下『一條』指令要改 -->
                                                            <!-- ****提示**** 這個商品的售價 在 $row['售價'] 裡 -->
                                                            <?php echo $row['單價'] * $row['數量']; ?> 
                                                            <input type="submit" name="delCartOK" value="Delete" class="btn-delete">
                                                        </div></td>
                                                </form>
                                                </tr>                               
                                                <?php
                                            }
                                            ?> 
                                            <tr>        
                                                <!-- ****提示**** 以下『兩條』指令要改 -->
                                                <!-- ****提示**** 這個購物車中商品的樣數 在 $total 裡 -->
                                                <!-- ****提示**** 這個購物車中購買商品的總金額 在 $total_paymet 裡 -->
                                                <td colspan=2 align=right>共<?php echo $total; ?>項商品</td>
                                                <td class="last">總計<?php echo "NT$" . $total_paymet; ?> </td>
                                            </tr>                               

                                            </tbody>
                                        </table>
                                        <!-- ****提示**** 這裡多加一張表單進來 -->
                                        <!-- ****提示**** 『沒有』指令要改 -->
                                        <!-- ****提示**** 注意一下：物流方式選擇好，是放在 logistics 裡 -->                                    
                                        <form action="confirm.php" method="POST">   
                                            請選擇物流方式：
                                            <input type=radio name="logistics" value="宅配">宅配
                                            <input type=radio name="logistics" value="超商取貨" checked>超商取貨
                                            <input type=submit name="confirmOrder" value="下一步"  
                                            style="float: right; 
                                                   background-color: #87CEFA;
                                                   color: #fff;
                                                   font-family: 'lato-bold', Helvetica, Arial, sans-serif;
                                                   font-size: 20px;
                                                   font-style: italic;
                                                   padding: 6px 12px;"
                                            >
                                        </form>
                                        <?php
                                    } else {
                                        echo "購物車中無商品";
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
        </section>  <!--  end listing section  -->
        
    </body>
</html>
