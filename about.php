<?php
session_start();
require_once("connect.php");
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
                    <a href="./index.php"><img src="./img/logo.png" class="logo" alt="" titl=""/></a>
                    <a href="#" class="hamburger"></a>
                    <nav>
                        <ul>
                            <li><a href="./account/shop.php">shop</a></li>
                            <li><a href="allproducts.php">All</a></li>
                            <li><a href="#">About</a></li>
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


        <section class="listings">
            <div class="wrapper">
                <h4><span>About</span></h4><br>                
                <a href="login.php">admin</a>
                <ul class="properties_list">
                    <div class="property_details">
                        
                    </div>
                </ul>
            </div>
            
            <div class="more_listing">
                <a href="#" class="more_listing_btn" id="gotop">返回頂部</a>
            </div>
            </div>
            
        </section>
        
    </body>
</html>