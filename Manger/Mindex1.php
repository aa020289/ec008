<div>
<ul class="menu">            
  <?php if (trim(strstr($_SESSION["reg_MPer"],'A')) != ""){?>
	<li class="top"><a href="#" class="top_link"><span>A.員工</span></a>
		<ul class="sub">
	        <li><a href="A01.php">A01.員工管理</a></li>			
          <li><a href="A02.php">A02.權限設定</a></li>
          <li><a href="A03.php">A03.權限查詢</a></li>
		</ul>
  </li> 
  <?php }?>

  <?php if (trim(strstr($_SESSION["reg_MPer"],'B')) != ""){?>
	<li class="top"><a href="#" class="top_link"><span>B.會員</span></a>
  	    <ul class="sub">
	    	<li><a href="B01.php">B01.會員管理</a></li>			
        <li><a href="#">B02.會員查詢</a></li>
		    </ul>
  </li>     
  <?php }?>

  <?php if (trim(strstr($_SESSION["reg_MPer"],'C')) != ""){?>
	<li class="top"><a href="#" class="top_link"><span>C.商品</span></a>
        <ul class="sub">
	    	<li><a href="C01.php">C01.商品管理</a></li>			
        <!-- <li><a href="#">C02.未來開發</a></li> -->
		    </ul>
  </li>     
  <?php }?>

  <?php if (trim(strstr($_SESSION["reg_MPer"],'C')) != ""){?>
  <li class="top"><a href="#" class="top_link"><span>D.訂單</span></a>
        <ul class="sub">
        <li><a href="D01.php">D01.訂單管理</a></li>     
        <!-- <li><a href="#">C02.未來開發</a></li> -->
        </ul>
  </li>     
  <?php }?>

  <li class="top"><a href="logout.php" class="top_link"><span>登出</span></a></li>       
</ul>                        
</div>
