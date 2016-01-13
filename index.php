<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>WINTER</title>
        <meta charset="utf-8">
        <meta name="author" content="pixelhint.com">
        <meta name="description" content="La casa free real state fully responsive html5/css3 home page website template"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

        <link rel="stylesheet" type="text/css" href="css/reset.css"> <!--封面圖排版-->
        <link rel="stylesheet" type="text/css" href="css/responsive.css"> <!--排版-->

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/main.js"></script>

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
                <div class="wrapper">
                    <a href="#"><img src="./img/logo.png" class="logo" alt="" titl=""/></a>
                    <a href="#" class="hamburger"></a>
                    <nav>
                        <ul>
                            <li><a href="./account/shop.php">shop</a></li>
                            <li><a href="allproducts.php">All</a></li>
                            <li><a href="about.php">About</a></li>
                        </ul>
                        <!--<a href="login.php" class="login_btn">Login</a>-->                            
                        <?php
                        if (!isset($_SESSION["reg_MUID"])) {
                            echo '<a href="./account/index.php" class="login_btn">Login</a>';
                            //echo '|' . '<a href="./register.php">註冊</a>';
                        } else {
                            echo '<a href="./account/logout.php" class="login_btn">Logout</a>';
                        }
                        ?>

                        </ul>
                    </nav>
                </div>
            </header><!--  end header section  -->

            <section class="caption">
                <h2 class="caption">Choose You Like</h2>
                <!--<h3 class="properties">Go Fighting</h3>-->
            </section>
        </section><!--  end hero section  -->
        

        <!--<section class="search"> 漂亮留著，功能：直接輸入
            <div class="wrapper">
                <form action="#" method="post">
                    <input type="text" id="search" name="search" placeholder="What are you looking for?"  autocomplete="off"/>
                    <input type="submit" id="submit_search" name="submit_search"/>
                </form>
                <a href="#" class="advanced_search_icon" id="advanced_search_btn"></a>
            </div>

            <div class="advanced_search">
                <div class="wrapper">
                    <span class="arrow"></span>
                    <form action="#" method="post">
                        <div class="search_fields">
                            <input type="text" class="float" id="check_in_date" name="check_in_date" placeholder="Check In Date"  autocomplete="off">

                            <hr class="field_sep float"/>

                            <input type="text" class="float" id="check_out_date" name="check_out_date" placeholder="Check Out Date"  autocomplete="off">
                        </div>
                        <div class="search_fields">
                            <input type="text" class="float" id="min_price" name="min_price" placeholder="Min. Price"  autocomplete="off">

                            <hr class="field_sep float"/>

                            <input type="text" class="float" id="max_price" name="max_price" placeholder="Max. price"  autocomplete="off">
                        </div>
                        <input type="text" id="keywords" name="keywords" placeholder="Keywords"  autocomplete="off">
                        <input type="submit" id="submit_search" name="submit_search"/>
                    </form>
                </div>
            </div><!--  end advanced search section  -->
        <!--</section><!--  end search section  -->


        <section class="listings">
            <div class="wrapper">
                <h4><span>HOT PRODUCE</span></h4><br>
                <ul class="properties_list">
                    <div class="property_details">
                        <?php
						require_once("connect.php");
                        $SQLStr = "
							SELECT   商品.商品代號, 商品照片.圖檔名, 商品.商品名稱, 商品.單價
                            FROM     商品 LEFT OUTER JOIN
                                     商品照片 ON 商品.商品代號 = 商品照片.商品代號
			    ORDER BY RAND() LIMIT 6";
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
                            echo '<a href="#">';
                            echo '<img src="./img/product/' . $row["圖檔名"] . ' " alt="img"> <span class="property_img"></span></a> <span class="price">' . $row["單價"] . '</span>';
                            echo "</a>";                            
                            echo "<h1>";
                            echo '<a href="./account/shop.php">' . $row["商品名稱"] . '</a>'. '</em><form action="./account/checkout.php" method="POST"><input type=submit name="addCartOK" value="加到購物車" class="btn-cart"><input type=hidden name="buyproductno" value="' . $row['商品代號'] . '"><input type=hidden name="buyqty" value="1"></form>';
                            echo "</h1>";
                            echo "</div>";
                            echo "</li>";
                        }
                    }
                    ?>  
                    </div>
                </ul>
            </div>
        </section>	
    </body>
</html>