<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php if ( is_home() ) {
        bloginfo('name'); echo " - "; bloginfo('description');
    } elseif ( is_category() ) {
        single_cat_title(); echo " - "; bloginfo('name');
    } elseif (is_single() || is_page() ) {
        single_post_title();echo " - "; bloginfo('name');
    }  elseif (is_tag() ) {
        single_tag_title();echo " - "; bloginfo('name');
    } 
       elseif (is_search() ) {
        echo "搜索结果"; echo " - "; bloginfo('name');
    } elseif (is_404() ) {
        echo '页面未找到!';
    } else {
        wp_title('',true);
    } ?></title>
<?php
if (is_home() || is_front_page()){
	$description = dopt('d_description');
	$keywords = dopt('d_keywords');
}elseif (is_category()){
	$description = strip_tags(trim(category_description()));
	$keywords = single_cat_title('', false);
}elseif (is_tag()){
	$description = sprintf( __( '与标签 %s 相关联的文章列表'), single_tag_title('', false));
    $keywords = single_tag_title('', false);
}elseif (is_single()){
	$keywords = get_post_meta($post->ID, 'keywords', true);
	if(!$keywords){
		$keywords = "";
		$tags = wp_get_post_tags($post->ID);
		foreach ($tags as $tag ) {
			if($tag != end($tags)){
				$keywords = $keywords . $tag->name . ",";
			}else{
				$keywords = $keywords . $tag->name;
			}
		}
	} 
	$description = get_post_meta($post->ID, 'description', true);
	if(!$description){
		if($post->post_excerpt){
			$description = $post->post_excerpt;
		}else{
			$description = mb_strimwidth(strip_tags($post->post_content),0,120,"");
		}	
	}
}elseif(is_page()){
	$keywords = get_post_meta($post->ID, "keywords", true);
	$description = get_post_meta($post->ID, "description", true);
}
	?>
<meta name="keywords" content="<?php echo $keywords ?>" />
<meta name="description" content="<?php echo $description?>" />
<?php
$sr_1 = 0; $sr_2 = 0; $commenton = 0; 
if( dopt('d_sideroll_b') ){ 
    $sr_1 = dopt('d_sideroll_1');
    $sr_2 = dopt('d_sideroll_2');
}

if( is_singular() ){ 
    if( comments_open() ) $commenton = 1;
}
?>
<script>
window._deel = {name: '<?php bloginfo('name') ?>',url: '<?php echo get_bloginfo("template_url") ?>', ajaxpager: '<?php echo dopt('d_ajaxpager_b') ?>', commenton: <?php echo $commenton ?>, roll: [<?php echo $sr_1 ?>,<?php echo $sr_2 ?>]}
</script>
<?php wp_head();if( dopt('d_headcode_b') ) echo dopt('d_headcode'); ?>
<!--[if lt IE 9]><script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script><![endif]-->
</head>

<body <?php body_class(); ?>>
<header id="masthead" class="site-header">
  <nav id="top-header">
    <div class="top-nav">
      <div id="user-profile">
        <?php 
		if( dopt('d_sign_b') ){ 
			global $current_user; 
			get_currentuserinfo();
			$uid = $current_user->ID;
			$u_name = get_user_meta($uid,'nickname',true);
	   ?>
        <span class="nav-set"><span class="nav-login">
        <?php if(is_user_logged_in()){echo 'Hi, '.$u_name.'&nbsp; ';echo '<a href="'.wp_logout_url($url_this).'" class="signin-loader">登 出</a>';}else{?>
            <a href="<?php echo wp_login_url($url_this); ?>" class="signin-loader">Hi, 请登录</a>&nbsp; &nbsp; <a href="/wp-login.php?action=register" class="signup-loader">我要注册</a>
        <?php } ?>
        </span> </span>
      <?php } ?>
      </div>
      <div class="menu-container">
        <ul id="menu-%e5%a4%b4%e9%83%a8" class="top-menu">
          <?php if( dopt('d_topindex_01_b') ) printf(dopt('d_topindex_01')); ?>
        </ul>
      </div>
    </div>
  </nav>
  <div id="nav-header">
    <div id="top-menu">
      <div id="top-menu_1"><span class="nav-search"><i class="fa fa-search"></i></span> <span class="nav-search_1"><a href="javascript:void(0);"><i class="fa fa-navicon"></i></a></span>
        <hgroup class="logo-site">
          <h1 class="site-title"> <a href="/"><img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="Sky 1.0博客主题" /></a></h1>
        </hgroup>
        <div id="site-nav-wrap">
          <nav id="site-nav" class="main-nav">
            <div>
              <ul class="down-menu nav-menu">
                <?php echo str_replace("</ul></div>", "", preg_replace("/<div[^>]*><ul[^>]*>/", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>              
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <nav>
    <ul class="nav_sj" id="nav-search_1">
      <?php echo str_replace("</ul></div>", "", preg_replace("/<div[^>]*><ul[^>]*>/", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
    </ul>
  </nav>
</header>
<div id="search-main">
  <div id="searchbar">
    <form id="searchform" action="/" method="get">
      <input id="s" type="text" required placeholder="输入搜索内容" name="s" value="">
      <button id="searchsubmit" type="submit">搜索</button>
    </form>
  </div>
  <div id="searchbar">
    <form id="searchform" target="_blank" action="http://i.g-fox.cn/search" method="get">
      <input type="hidden" name="entry" value="1">
      <input class="swap_value" name="q" placeholder="输入百度站内搜索关键词">
      <button id="searchsubmit" type="submit">百度</button>
    </form>
  </div>
  <div class="clear"></div>
</div>
<section class="container">
<div class="speedbar">
<?php if(dopt('d_tui')){?>
  <div class="toptip"><?php echo dopt('d_tui'); ?></div>
<?php }?>
</div>
<?php if( dopt('d_adsite_01_b') ) echo '<div class="banner banner-site">'.dopt('d_adsite_01').'</div>'; ?>