<?php
$dname = 'Sky 1.0';
add_action( 'after_setup_theme', 'deel_setup' );

include('admin/Sky.php');
include('widgets/index.php');

function deel_setup(){
	//去除头部冗余代码
	remove_action( 'wp_head',   'feed_links_extra', 3 ); 
	remove_action( 'wp_head',   'rsd_link' ); 
	remove_action( 'wp_head',   'wlwmanifest_link' ); 
	remove_action( 'wp_head',   'index_rel_link' ); 
	remove_action( 'wp_head',   'start_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head',   'wp_generator' ); 
	//
	add_theme_support( 'custom-background' );

	//隐藏admin Bar
	add_filter('show_admin_bar','hide_admin_bar');

	//关键字
	//add_action('wp_head','deel_keywords');   

	//页面描述 
	//add_action('wp_head','deel_description');   

	//阻止站内PingBack
	if( dopt('d_pingback_b') ){
		add_action('pre_ping','deel_noself_ping');   
	}   

	//评论回复邮件通知
	add_action('comment_post','comment_mail_notify'); 

	//自动勾选评论回复邮件通知，不勾选则注释掉 
	// add_action('comment_form','deel_add_checkbox');

	//评论表情改造，如需更换表情，img/smilies/下替换
	add_filter('smilies_src','deel_smilies_src',1,10); 

	//文章末尾增加版权
	add_filter('the_content','deel_copyright');    

	//移除自动保存和修订版本
	if( dopt('d_autosave_b') ){
		add_action('wp_print_scripts','deel_disable_autosave' );
		remove_action('pre_post_update','wp_save_post_revision' );
	}

	//去除自带js
	wp_deregister_script( 'l10n' ); 

	//修改默认发信地址
	add_filter('wp_mail_from', 'deel_res_from_email');
	add_filter('wp_mail_from_name', 'deel_res_from_name');

	//缩略图设置
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(220, 150, true); 
	add_editor_style('editor-style.css');
	//定义菜单
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
			'nav' => __('网站导航'),
			'pagemenu' => __('页面导航'),
			'header-menu' => __('导航自定义菜单'),
		));
	}
}

if(function_exists('register_sidebar')){
	register_sidebar(array(
		'name'          => '全站侧栏',
		'id'            => 'widget_sitesidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2><sapn class="title_span">',
		'after_title'   => '</span></h2></div>'
	));
	register_sidebar(array(
		'name'          => '首页侧栏',
		'id'            => 'widget_sidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2><sapn class="title_span">',
		'after_title'   => '</span></h2></div>'
	));
	register_sidebar(array(
		'name'          => '分类/标签/搜索页侧栏',
		'id'            => 'widget_othersidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2><sapn class="title_span">',
		'after_title'   => '</span></h2></div>'
	));
	register_sidebar(array(
		'name'          => '文章页侧栏',
		'id'            => 'widget_postsidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2><sapn class="title_span">',
		'after_title'   => '</span></h2></div>'
	));
	register_sidebar(array(
		'name'          => '页面侧栏',
		'id'            => 'widget_pagesidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="title"><h2><sapn class="title_span">',
		'after_title'   => '</span></h2></div>'
	));
}

function deel_breadcrumbs(){
    if( !is_single() ) return false;
    $categorys = get_the_category();
    $category = $categorys[0];
    return '<a title="返回首页" href="'.get_bloginfo('url').'"><i class="fa fa-home"></i></a> <small>></small> '.get_category_parents($category->term_id, true, ' <small>></small> ').'<span class="muted">'.get_the_title().'</span>';
}

// 取消原有jQuery
function footerScript() {
    if ( !is_admin() ) {
        wp_deregister_script( 'jquery' );
 	wp_register_script( 'jquery','//libs.baidu.com/jquery/1.8.3/jquery.min.js', false,'1.0');
	wp_enqueue_script( 'jquery' );
        wp_register_script( 'default', get_template_directory_uri() . '/js/jquery.js', false, '1.0', dopt('d_jquerybom_b') ? true : false );   
        wp_enqueue_script( 'default' );   
	wp_register_style( 'style', get_template_directory_uri() . '/style.css',false,'1.0' );
	wp_enqueue_style( 'style' ); 
    }  
}  
add_action( 'wp_enqueue_scripts', 'footerScript' );

if ( ! function_exists( 'deel_paging' ) ) :
function deel_paging() {
    $p = 4;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<div class="pagination"><ul>';
    if ( empty( $paged ) ) $paged = 1;
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    echo '<li class="prev-page">'; previous_posts_link('上一页'); echo '</li>';
    if ( $paged > $p + 1 ) p_link( 1, '<li>第一页</li>' );
    if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
        if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_link( $i );
    }
    if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
    //if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
    echo '<li class="next-page">'; next_posts_link('下一页'); echo '</li>';
    // echo '<li><span>共 '.$max_page.' 页</span></li>';
    echo '</ul></div>';
}

function p_link( $i, $title = '' ) {
    if ( $title == '' ) $title = "第 {$i} 页";
    echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
}
endif;

function deel_strimwidth($str ,$start , $width ,$trimmarker ){
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
    return $output.$trimmarker;
}

function dopt($e){
	return stripslashes(get_option($e));
}

if ( ! function_exists( 'deel_views' ) ) :
function deel_record_visitors(){
	if (is_singular()){
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID){
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1))){
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}

add_action('wp_head', 'deel_record_visitors');  

function deel_views($after=''){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  echo $views, $after;
}

endif;

//baidu分享
$dHasShare = false;
function deel_share(){
	if( !dopt('d_bdshare_b') ) return false;
  echo '<span class="action action-share bdsharebuttonbox"><i class="fa fa-share-alt"></i>分享 (<span class="bds_count" data-cmd="count" title="累计分享0次">0</span>)<div class="action-popover"><div class="popover top in"><div class="arrow"></div><div class="popover-content"><a href="#" class="sinaweibo fa fa-weibo" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_qzone fa fa-star" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="tencentweibo fa fa-tencent-weibo" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="qq fa fa-qq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_renren fa fa-renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin fa fa-weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_more fa fa-ellipsis-h" data-cmd="more"></a></div></div></div></span>';
  global $dHasShare;
  $dHasShare = true;
}

function deel_avatar_default(){ 
  return get_bloginfo('template_directory').'/img/default.png';
}

//关键字
function deel_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_single() ) {
	if ( get_the_tags( $post->ID ) ) {
	  foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
	}
	foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
	$keywords = substr_replace( $keywords , '' , -2);
  } elseif ( is_home () )    { $keywords = dopt('d_keywords');
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }

  if ( $keywords ) {
	echo "<meta name=\"keywords\" content=\"$keywords\">\n";
  }
}

//网站描述
function deel_description() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
	if( !empty( $post->post_excerpt ) ) {
	  $text = $post->post_excerpt;
	} else {
	  $text = $post->post_content;
	}
	$description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
	if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
  } elseif ( is_home () )    { $description = dopt('d_description'); // 首頁要自己加
  } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
  } elseif ( is_category() ) { $description = trim(strip_tags(category_description()));
  } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  }
  $description = mb_substr( $description, 0, 220, 'utf-8' );
  echo "<meta name=\"description\" content=\"$description\">\n";
}

function hide_admin_bar($flag) {
	return false;
}

//最新发布加new 单位'小时'
function deel_post_new($timer='48'){
  $t=( strtotime( date("Y-m-d H:i:s") )-strtotime( $post->post_date ) )/3600; 
  if( $t < $timer ) echo "<i>new</i>";
}

//修改评论表情调用路径
function deel_smilies_src ($img_src, $img, $siteurl){
	return get_bloginfo('template_directory').'/img/smilies/'.$img;
}

//阻止站内文章Pingback 
function deel_noself_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}

//移除自动保存
function deel_disable_autosave() {
  wp_deregister_script('autosave');
}

//修改默认发信地址
function deel_res_from_email($email) {
	$wp_from_email = get_option('admin_email');
	return $wp_from_email;
}
function deel_res_from_name($email){
	$wp_from_name = get_option('blogname');
	return $wp_from_name;
}
//评论回应邮件通知
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; // admin 要不要收回复通知 ( '1'=要 ; '0'=不要 )
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改为你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
	$wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
	$wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
	$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 发出点, no-reply 可改为可用的 e-mail.
	$to = trim(get_comment($parent_id)->comment_author_email);
	$subject = 'Hi，您在 [' . get_option("blogname") . '] 的留言有人回复啦！';
	$message = '
	<div style="color:#333;font:100 14px/24px microsoft yahei;">
	  <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
	  <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br /> &nbsp;&nbsp;&nbsp;&nbsp; '
	   . trim(get_comment($parent_id)->comment_content) . '</p>
	  <p>' . trim($comment->comment_author) . ' 给您的回应:<br /> &nbsp;&nbsp;&nbsp;&nbsp; '
	   . trim($comment->comment_content) . '<br /></p>
	  <p>点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回应完整內容</a></p>
	  <p>欢迎再次光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
	  <p style="color:#999">(此邮件由系统自动发出，请勿回复.)</p>
	</div>';
	$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
	$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail( $to, $subject, $message, $headers );
	//echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}

//自动勾选 
function deel_add_checkbox() {
  echo '<label for="comment_mail_notify" class="checkbox inline" style="padding-top:0"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>有人回复时邮件通知我</label>';
}

//文章（包括feed）末尾加版权说明
function deel_copyright($content) {
	if( !is_page() ){
		$pid = get_the_ID();
		$name = get_post_meta($pid, 'from.name', true);
		$link = get_post_meta($pid, 'from.link', true);
		$show = false;
		if( $name ){
			$show = $name;
			if( $link ){
				$show = '<a target="_blank" href="'.$link.'">'.$show.'</a>';
			}
		}else if( $link ){
			$show = '<a target="_blank" href="'.$link.'">'.$link.'</a>';
		}
		if( $show ){
			$content.= '<p>来源：'.$show.'</p>';
		}
		$content.= '<p>转载请注明：<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a> &raquo; <a href="'.get_permalink().'">'.get_the_title().'</a></p>';
	}
	return $content;
}

//时间显示方式‘xx以前’
function time_ago( $type = 'commennt', $day = 7 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (time() - $d('U') > 60*60*24*$day) return;
  echo ' (', human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前)';
}
function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}



//评论样式
function deel_comment_list($comment, $args, $depth) {
  echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';
  //头像
  echo '<div class="c-avatar">';
  echo str_replace(' src=', ' data-original=', get_avatar( $comment->comment_author_email, $size = '54' , deel_avatar_default())); 
  //内容
  echo '<div class="c-main" id="div-comment-'.get_comment_ID().'">';
	echo str_replace(' src=', ' data-original=', convert_smilies(get_comment_text()));
	if ($comment->comment_approved == '0'){
	  echo '<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';
	}
	//信息
	echo '<div class="c-meta">';
		echo '<span class="c-author">'.get_comment_author_link().'</span>';
		echo get_comment_time('Y-m-d H:i '); echo time_ago(); 
		if ($comment->comment_approved !== '0'){ 
			echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
		echo edit_comment_link(__('(编辑)'),' - ','');
	  } 
	echo '</div>';
  echo '</div></div>';
}

//remove google fonts
if (!function_exists('remove_wp_open_sans')) :
    function remove_wp_open_sans() {
        wp_deregister_style( 'open-sans' );
        wp_register_style( 'open-sans', false );
    }
     add_action('admin_enqueue_scripts', 'remove_wp_open_sans');
     add_action('login_init', 'remove_wp_open_sans');
endif;

//翠竹林@添加钮Download
function DownloadUrl($atts, $content = null) {
	extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="dl" href="'.$href.'" target="_blank" rel="nofollow"><i class="fa fa-cloud-download"></i>'.$content.'</a>';
}

add_shortcode("dl", "DownloadUrl");

//翠竹林@添加钮git
function GithubUrl($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="dl" href="'.$href.'" target="_blank" rel="nofollow"><i class="fa fa-github-alt"></i>'.$content.'</a>';
}
add_shortcode('gt' , 'GithubUrl' );

//翠竹林@添加钮Demo
function DemoUrl($atts, $content=null) {
   extract(shortcode_atts(array("href" => 'http://'), $atts));
	return '<a class="dl" href="'.$href.'" target="_blank" rel="nofollow"><i class="fa fa-external-link"></i>'.$content.'</a>';
}

add_shortcode('dm' , 'DemoUrl' );

//翠竹林@添加编辑器快捷按钮
add_action('admin_print_scripts', 'my_quicktags');
function my_quicktags() {
    wp_enqueue_script(
        'my_quicktags',
        get_stylesheet_directory_uri().'/js/my_quicktags.js',
        array('quicktags')
    );
    }; 

//评论过滤  
function refused_spam_comments( $comment_data ) {  
$pattern = '/[一-龥]/u';  
$jpattern ='/[ぁ-ん]+|[ァ-ヴ]+/u';
if(!preg_match($pattern,$comment_data['comment_content'])) {  
err('写点汉字吧，博主外语很捉急！You should type some Chinese word!');  
} 
if(preg_match($jpattern, $comment_data['comment_content'])){
err('日文滚粗！Japanese Get out！日本語出て行け！ You should type some Chinese word！');  
}
return( $comment_data );  
}

if( dopt('d_spamComments_b') ){
	add_filter('preprocess_comment','refused_spam_comments');
}   

//点赞
add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
    $bigfa_raters = get_post_meta($id,'bigfa_ding',true);
    $expire = time() + 99999999;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('bigfa_ding_'.$id,$id,$expire,'/',$domain,false);
    if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
        update_post_meta($id, 'bigfa_ding', 1);
    } 
    else {
            update_post_meta($id, 'bigfa_ding', ($bigfa_raters + 1));
        }
   
    echo get_post_meta($id,'bigfa_ding',true);

    } 
    
    die;
}

//最热排行
function hot_posts_list($days=7, $nums=10) { 
    global $wpdb;
    $today = date("Y-m-d H:i:s");
    $daysago = date( "Y-m-d H:i:s", strtotime($today) - ($days * 24 * 60 * 60) );  
    $result = $wpdb->get_results("SELECT comment_count, ID, post_title, post_date FROM $wpdb->posts WHERE post_date BETWEEN '$daysago' AND '$today' ORDER BY comment_count DESC LIMIT 0 , $nums");
    $output = '';
    if(empty($result)) {
        $output = '<li>None data.</li>';
    } else {
        $i = 1;
        foreach ($result as $topten) {
            $postid = $topten->ID;
            $title = $topten->post_title;
            $commentcount = $topten->comment_count;
            if ($commentcount != 0) {
              $output .= '<li><p><span class="post-comments">评论 ('.$commentcount.')</span><span class="muted"><a href="javascript:;" data-action="ding" data-id="'.$postid.'" id="Addlike" class="action';
	if(isset($_COOKIE['bigfa_ding_'.$postid])) $output .=' actived';
	$output .='"><i class="fa fa-heart-o"></i><span class="count">';
	if( get_post_meta($postid,'bigfa_ding',true) ){ 
		$output .=get_post_meta($postid,'bigfa_ding',true);
 	} else {$output .='0';}
	$output .='</span>喜欢</a></span></p><span class="label label-'.$i.'">'.$i.'</span><a href="'.get_permalink($postid).'" title="'.$title.'">'.$title.'</a></li>';
                $i++;
            }
        }
    }
    echo $output;
}

//在 WordPress 编辑器添加“下一页”按钮
add_filter('mce_buttons','add_next_page_button');
function add_next_page_button($mce_buttons) {
	$pos = array_search('wp_more',$mce_buttons,true);
	if ($pos !== false) {
		$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
		$tmp_buttons[] = 'wp_page';
		$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
	}
	return $mce_buttons;
}

//判断手机广告
function Cui_is_mobile() {
    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        return false;
    } elseif ( ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false  && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') === false) // many mobile devices (all iPh, etc.)
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
            return true;
    } else {
        return false;
    }
}

//翠竹林@搜索结果排除所有页面
function search_filter_page($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','search_filter_page');

//翠竹林@添加相关文章图片文章
if ( function_exists('add_theme_support') )add_theme_support('post-thumbnails');
 

/*//1或3张 输出缩略图地址

function post_thumbnail_src($num){
    global $post;
	if( $values = get_post_custom_values("thumb") ) {	//输出自定义域图片地址
		$values = get_post_custom_values("thumb");
		$post_thumbnail_src = $values [0];
	} elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
    } else {
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);	
		if($num){
			$post_thumbnail_src_array =  $matches [1];	//获取文章所有图片	src
		}else{
			$post_thumbnail_src = $matches [1] [0];   //获取第一张该图片 src
		}
		if(empty($post_thumbnail_src)){	//如果日志中没有图片，则显示随机图片
			$random = mt_rand(1, 10);
			//echo get_bloginfo('template_url');
			//echo '/img/pic/'.$random.'.jpg';
			//如果日志中没有图片，则显示默认图片
			//echo '/img/thumbnail.png';
		}
	};	
	if($num){
		return $post_thumbnail_src_array;	
	}else{
		echo $post_thumbnail_src;	
	}
}*/
//输出缩略图地址

function post_thumbnail_src(){
    global $post;
	if( $values = get_post_custom_values("thumb") ) {	//输出自定义域图片地址
		$values = get_post_custom_values("thumb");
		$post_thumbnail_src = $values [0];
	} elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
    } else {
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$post_thumbnail_src = $matches [1] [0];   //获取该图片 src
		if(empty($post_thumbnail_src)){	//如果日志中没有图片，则显示随机图片
			$random = mt_rand(1, 10);
			echo get_bloginfo('template_url');
			echo '/img/pic/'.$random.'.jpg';
			//如果日志中没有图片，则显示默认图片
			//echo '/img/thumbnail.png';
		}
	};
	echo $post_thumbnail_src;
}


//官方Gravatar头像调用ssl头像链接

function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="http://cn.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');

//管理后台添加按钮

function git_custom_adminbar_menu($meta = TRUE) {
    global $wp_admin_bar;
    if (!is_user_logged_in()) {
        return;
    }
    if (!is_super_admin() || !is_admin_bar_showing()) {
        return;
    }

    $wp_admin_bar->add_menu(array(
        'id' => 'git_option',
        'title' => 'Sky主题使用文档', /* 设置链接名 */
        'href' => 'http://www.cuizl.com/bokezhuti/1822.html',
		'meta' => array(
            target => '_blank'
        )
    ));
    $wp_admin_bar->add_menu(array(
        'id' => 'git_guide',
        'title' => 'SEO教程', /* 设置链接名 */
        'href' => 'http://www.zhixin99.com/page/seojiaocheng', /* 设置链接地址 */
        'meta' => array(
            target => '_blank'
        )
    ));
}

add_action('admin_bar_menu', 'git_custom_adminbar_menu', 100);

//修复4.2表情bug
function disable_emoji9s_tinymce($plugins) {
	if (is_array($plugins)) {
		return array_diff($plugins, array(
			'wpemoji'
		));
	} else {
		return array();
	}
}

//取当前主题下img\smilies\下表情图片路径
function custom_gitsmilie_src($old, $img) {
	return get_stylesheet_directory_uri() . '/img/smilies/' . $img;
}

function init_gitsmilie() {
	global $wpsmiliestrans;
	//默认表情文本与表情图片的对应关系(可自定义修改)
	$wpsmiliestrans = array(
		':mrgreen:' => 'icon_mrgreen.gif',
		':neutral:' => 'icon_neutral.gif',
		':twisted:' => 'icon_twisted.gif',
		':arrow:' => 'icon_arrow.gif',
		':shock:' => 'icon_eek.gif',
		':smile:' => 'icon_smile.gif',
		':???:' => 'icon_confused.gif',
		':cool:' => 'icon_cool.gif',
		':evil:' => 'icon_evil.gif',
		':grin:' => 'icon_biggrin.gif',
		':idea:' => 'icon_idea.gif',
		':oops:' => 'icon_redface.gif',
		':razz:' => 'icon_razz.gif',
		':roll:' => 'icon_rolleyes.gif',
		':wink:' => 'icon_wink.gif',
		':cry:' => 'icon_cry.gif',
		':eek:' => 'icon_surprised.gif',
		':lol:' => 'icon_lol.gif',
		':mad:' => 'icon_mad.gif',
		':sad:' => 'icon_sad.gif',
		'8-)' => 'icon_cool.gif',
		'8-O' => 'icon_eek.gif',
		':-(' => 'icon_sad.gif',
		':-)' => 'icon_smile.gif',
		':-?' => 'icon_confused.gif',
		':-D' => 'icon_biggrin.gif',
		':-P' => 'icon_razz.gif',
		':-o' => 'icon_surprised.gif',
		':-x' => 'icon_mad.gif',
		':-|' => 'icon_neutral.gif',
		';-)' => 'icon_wink.gif',
		'8O' => 'icon_eek.gif',
		':(' => 'icon_sad.gif',
		':)' => 'icon_smile.gif',
		':?' => 'icon_confused.gif',
		':D' => 'icon_biggrin.gif',
		':P' => 'icon_razz.gif',
		':o' => 'icon_surprised.gif',
		':x' => 'icon_mad.gif',
		':|' => 'icon_neutral.gif',
		';)' => 'icon_wink.gif',
		':!:' => 'icon_exclaim.gif',
		':?:' => 'icon_question.gif',
	);
	//移除WordPress4.2版本更新所带来的Emoji钩子同时挂上主题自带的表情路径
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emoji9s_tinymce');
	add_filter('smilies_src', 'custom_gitsmilie_src', 10, 2);
}
add_action('init', 'init_gitsmilie', 5);

//评论头像缓存
function fa_cache_avatar($avatar, $id_or_email, $size, $default, $alt){
	$avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cn.gravatar.com", $avatar);
	$tmp = strpos($avatar, 'http');
	$url = get_avatar_url( $id_or_email, $size ) ;
	$url = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cn.gravatar.com", $url);
	$avatar2x = get_avatar_url( $id_or_email, ( $size * 2 ) ) ;
	$avatar2x = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cn.gravatar.com", $avatar2x);
	$g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
	$tmp = strpos($g, 'avatar/') + 7;
	$f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
	$w = home_url();
	$e = ABSPATH .'avatar/'. $size . '*'. $f .'.jpg';
	$e2x = ABSPATH .'avatar/'. ( $size * 2 ) . '*'. $f .'.jpg';
	$t = 1209600; 
	if ( (!is_file($e) || (time() - filemtime($e)) > $t) && (!is_file($e2x) || (time() - filemtime($e2x)) > $t ) ) { 
		copy(htmlspecialchars_decode($g), $e);
		copy(htmlspecialchars_decode($avatar2x), $e2x);
	} else { $avatar = $w.'/avatar/'. $size . '*'.$f.'.jpg';
		$avatar2x = $w.'/avatar/'. ( $size * 2) . '*'.$f.'.jpg';
		if (filesize($e) < 1000) copy($w.'/avatar/default.jpg', $e);
		if (filesize($e2x) < 1000) copy($w.'/avatar/default.jpg', $e2x);
		$avatar = "<img alt='{$alt}' src='{$avatar}' srcset='{$avatar2x}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
	}
	return $avatar;
}   

//头像缓存  
if( dopt('d_avatar_b') ){
	add_filter('get_avatar', 'fa_cache_avatar',1,5);
}

//登录函数
function _moloader($name = '', $apply = true) {
	if (!function_exists($name)) {
		include get_stylesheet_directory() . '/modules/' . $name . '.php';
	}

	if ($apply && function_exists($name)) {
		$name();
	}
}
/*后台文章页自定义模块*/
$new_meta_boxes = array("demo" => array("name" => "demo","std" => "","title" => "下载地址:"),"down" => array("name" => "down","std" => "","title" => "下载密码:"));
function new_meta_boxes() {
    global $post, $new_meta_boxes;
    foreach($new_meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
        if($meta_box_value == "")
            $meta_box_value = $meta_box['std'];
        echo'<h4>'.$meta_box['title'].'</h4>';
        echo '<textarea cols="60" rows="3" name="'.$meta_box['name'].'_value">'.$meta_box_value.'</textarea><br />';
    }
    echo '<input type="hidden" name="newmetaboxes_noncename" id="newmetaboxes_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
function create_meta_box() {
    global $theme_name;
    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'new-meta-boxes', '下载模块', 'new_meta_boxes', 'post', 'normal', 'high' );
    }
}
function save_postdata( $post_id ) {
    global $new_meta_boxes;
    if ( !wp_verify_nonce( $_POST['newmetaboxes_noncename'], plugin_basename(__FILE__) ))
        return;
    if ( !current_user_can( 'edit_posts', $post_id ))
        return;
    foreach($new_meta_boxes as $meta_box) {
        $data = $_POST[$meta_box['name'].'_value'];
        if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
            add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
        elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
            update_post_meta($post_id, $meta_box['name'].'_value', $data);
        elseif($data == "")
            delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
    }
}
add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');
/*后台文章页自定义模块end*/
if ( current_user_can('contributor') && !current_user_can('upload_files') )
  add_action('admin_init', 'allow_contributor_uploads');

function allow_contributor_uploads() {
  $contributor = get_role('contributor');
  $contributor->add_cap('upload_files');
}
?>