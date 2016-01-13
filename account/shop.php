<!DOCTYPE HTML >
<?php
session_start();
?>
<html>
    <head>
        <title>WINTER</title>
        <meta charset="utf-8">
        <meta name="author" content="pixelhint.com">
        <meta name="description" content="La casa free real state fully responsive html5/css3 home page website template"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

        <link rel="stylesheet" type="text/css" href="../css/reset.css"> <!--封面圖排版-->
        <link rel="stylesheet" type="text/css" href="../css/responsive.css"> <!--排版-->

        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/main.js"></script>

        <script language="javascript"> //顯示category
        $(function(){
            $('#new').click(function(){ $('html,body').animate({scrollTop:$('#category').offset().top}, 500); }); //代表一個完整的執行區塊
        });
        </script>
        <script type="text/javascript"> //滑動方式至頁頂
        $(function(){
            $("#gotop").click(function(){
                jQuery("html,body").animate({
                    scrollTop:0
                },1000);
            });
            $(window).scroll(function() {
                if ( $(this).scrollTop() > 300){
                    $('#gotop').fadeIn("fast");
                } else {
                    $('#gotop').stop().fadeOut("fast");
                }
            });
        });
        </script>

    </head>
    <body>
        <section class="hero">
            <header>
                <!--<div id="headall">   
<div class="head">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="search1" size=20px>&nbsp;<input type="image" src="images/0012.png" width="20" height="20" align="center"></div>
<div class="head" id="login1"><?php //if(isset($_SESSION["reg_MUID"])) {echo $_SESSION["reg_MName"]."!!! 您好 &nbsp;&nbsp;".'<a href="logout.php" class="login">登出</a>&nbsp;&nbsp;' ;} else {echo '<a href="register.php" class="login">註冊</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./index.php" class="login">登入</a>&nbsp;&nbsp;';}  ?> </div>
</div>-->
                <div class="wrapper">
                    <a href="../index.php"><img src="../img/logo.png" class="logo" alt="" titl=""/></a>
                    <a href="#" class="hamburger"></a>
                    <nav>
                        <ul>
                            <li><a href="#">shop</a></li>
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

                        </ul>
                    </nav>
                </div>
            </header><!--  end header section  -->

            <section class="caption">
                <h2 class="caption">Choose You Like</h2>
            </section>
        </section><!--  end hero section  -->

        <section class="search">
            <div class="wrapper">
                <form action="#" method="post">
                    <input type="text" id="search" name="search" placeholder="What are you looking for?"  autocomplete="off"/>         
                </form>                
            </div>
        </section><!--  end search section  -->


        <section class="listings"> <!--CSS：main、responsive-->
            <div class="wrapper">
                <h4><span id = "category">Category</span></h4><br>
                <ul class="properties_list">
                <div class="property_details">
                    <?php
                        require_once("../connect.php");
                        $SQLStr = "
                            SELECT * FROM 商品類別";
                    ?>
                    <?php
                    $rs = mysql_query($SQLStr);
                    //echo("共有".mysql_num_rows($rs)."個商品*****");
                    if (mysql_num_rows($rs) > 0) { 
                        $total = mysql_num_rows($rs);
                        for ($i = 0; $i < $total; $i++) {
                            $row = mysql_fetch_array($rs);
                            echo "<li>";                           
                            echo '<div class="property_details">';
							//echo '<a href="../img/product/' . $row["類別代號"] . '_001.jpg">';
							/*<form>
							<input type=image  src="圖片位址" 
										border=邊框寬度>
							</form>*/
							/*<input type="button" style="background-image:url(圖片網址);width:80px;height:25px;">*/
                            echo '<img src="../img/product/' . $row["類別代號"] . '_001.jpg" alt="" title="" class="property_img"/>';
                            //echo "</a>";
                            echo "<h1>";
                            echo '<form action="shopproduct.php" method="POST">'.'<input type=submit value="' . $row["類別名稱"] . '" 
                                     style = "background-color: transparent; 
                                     border: 0; 
                                     font-size: 25px;
                                     color: #666464; 
                                     font-family: "lato-bold", Helvetica, Arial, sans-serif; 
                                     font-size: 16px!important;
                                     font-weight: bold;" >'.'<input type=hidden name="productno" value="' . $row['類別代號'] . '">'.'</form>';							
                            echo "</h1>";
                            //echo "<h2>2 kitchens, 2 bed, 2 bath... <span class="property_size">(288ftsq)</span></h2>";
                            echo "</div>";
                            echo "</li>";
                        }
                    }
                    ?>                   
                </div>                         
                </ul>
                
            <div class="more_listing">
                <a href="#" class="more_listing_btn" id="gotop">返回頂部</a>
            </div>
            </div>
        </section>	<!--  end listing section  -->

        <footer>
            <div class="wrapper footer">
                <ul>
                    <li class="links">
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Policy</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </li>

                    <li class="links">
                        <ul>
                            <li><a href="#">Appartements</a></li>
                            <li><a href="#">Houses</a></li>
                            <li><a href="#">Villas</a></li>
                            <li><a href="#">Mansions</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                    </li>

                    <li class="links">
                        <ul>
                            <li><a href="#">New York</a></li>
                            <li><a href="#">Los Anglos</a></li>
                            <li><a href="#">Miami</a></li>
                            <li><a href="#">Washington</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                    </li>

                    <li class="about">
                        <p>La Casa is real estate minimal html5 website template, designed and coded by pixelhint, tellus varius, dictum erat vel, maximus tellus. Sed vitae auctor ipsum</p>
                        <ul>
                            <li><a href="http://facebook.com/pixelhint" class="facebook" target="_blank"></a></li>
                            <li><a href="http://twitter.com/pixelhint" class="twitter" target="_blank"></a></li>
                            <li><a href="http://plus.google.com/+Pixelhint" class="google" target="_blank"></a></li>
                            <li><a href="#" class="skype"></a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="copyrights wrapper">
                Copyright © 2015 <a href="http://pixelhint.com" target="_blank" class="ph_link" title="Download more free Templates">Pixelhint.com</a>. All Rights Reserved.
            </div>
        </footer><!--  end footer  -->

    </body>
</html>
