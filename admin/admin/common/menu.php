<section class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="../../dist/img/user.png" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>管理員</p>
      <!-- Status -->
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
    <li><a href="../member/admin_list.php?token=<?php echo $token;?>"><i class="fa fa-user-secret"></i> <span>後台帳號管理</span></a></li> 
    <li class="header" style="color:#dd4b39;">巴洛克</li>
    <li><a href="../member/member_list.php?token=<?php echo $token;?>"><i class="fa fa-users"></i> <span>會員管理</span></a></li>  
    <li><a href="../home/banner_list.php?token=<?php echo $token;?>&type=baroque"><i class="fa fa-th-list"></i> <span>BANNER管理</span></a>                
    <li><a href="../home/news_list.php?token=<?php echo $token;?>&type=baroque"><i class="fa fa-newspaper-o"></i> <span>最新消息管理</span></a></li>
    <li><a href="../home/milestone_list.php?token=<?php echo $token;?>&type=baroque"><i class="fa fa-calendar"></i> <span>大紀事管理</span></a></li> 
    <li class="treeview">
      <a href="#">
        <i class="fa fa-rss"></i> <span>影音管理</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu" style="display: none;">
        <li><a href="video_list.php?token=<?php echo $token;?>&type=baroque"><i class="fa fa fa-film"></i>影片管理</a></li>
        <li><a href="image_list.php?token=<?php echo $token;?>&type=baroque"><i class="fa fa-picture-o"></i>照片管理</i></a></li>
    </ul>  
    <li class="header" style="color:#dd4b39;">響享</li>
     <li><a href="../home/banner_list.php?token=<?php echo $token;?>&type=shine"><i class="fa fa-th-list"></i> <span>BANNER管理</span></a>                
    <li><a href="../home/news_list.php?token=<?php echo $token;?>&type=shine"><i class="fa fa-newspaper-o"></i> <span>最新消息管理</span></a></li>
    <li><a href="../home/milestone_list.php?token=<?php echo $token;?>&type=shine"><i class="fa fa-calendar"></i> <span>大紀事管理</span></a></li> 
  </ul><!-- /.sidebar-menu -->
</section>