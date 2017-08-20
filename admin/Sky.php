<?php
$themename = $dname.'主题';
$options = array(
    "d_description", "d_keywords", "d_tui", "d_sticky_b", "d_linkpage_cat", "d_tougao_b", "d_tougao_time", "d_tougao_mailto", "d_avatar_b", "d_avatarDate", "d_sideroll_b", "d_sideroll_1", "d_sideroll_2", "d_pingback_b", "d_autosave_b", "d_tqq_b", "d_tqq", "d_weibo_b", "d_weibo", "d_facebook_b", "d_facebook", "d_twitter_b", "d_twitter", "d_rss","d_qqContact_b","d_qqContact","d_weixin_b","d_weixin","d_emailContact_b","d_emailContact", "d_track_b", "d_track", "d_headcode_b", "d_headcode", "d_footcode_b","d_footcode_a", "d_footcode_1", "d_footcode", "d_adsite_01_b", "d_adsite_01", "d_adindex_02_b", "d_adindex_02", "d_adindex_01_b", "d_adindex_01", "d_adindex_03_b", "d_adindex_03", "d_adpost_01_b", "d_adpost_01", "d_adpost_02_b", "d_adpost_02", "d_adpost_03_b", "d_adpost_03", "d_sign_b", "d_jquerybom_b", "d_ajaxpager_b", "d_thumbnail_b", "d_bdshare_b", "d_related_count", "d_post_views_b", "d_post_author_b", "d_post_comment_b", "d_post_time_b","hot_list_title","hot_list_number","hot_list_date","hot_list_check","d_post_like_b","d_singleMenu_b","Mobiled_adindex_02_b","Mobiled_adindex_02","Mobiled_adpost_01_b","Mobiled_adpost_01","Mobiled_adpost_02_b","Mobiled_adpost_02","d_spamComments_b","d_topindex_01_b","d_topindex_01","git_slick1url_b","git_slick1img_b","git_slick1title_b","git_slick2url_b","git_slick2img_b","git_slick2title_b","git_slick3url_b","git_slick3img_b","git_slick3title_b","git_slick4url_b","git_slick4img_b","git_slick4title_b","git_slick5url_b","git_slick5img_b","git_slick5title_b","git_slick6url_b","git_slick6img_b","git_slick6title_b","git_slick7url_b","git_slick7img_b","git_slick7title_b"
);

function mytheme_add_admin() {
    global $themename, $options;
    if ( $_GET['page'] == basename(__FILE__) ) {
        if ( 'save' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                update_option( $value, $_REQUEST[ $value ] ); 
            }
            header("Location: admin.php?page=Sky.php&saved=true");
            die;
        }
    }
    add_theme_page($themename." Options", $themename."设置", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
    global $themename, $options;
    $i=0;
    if ( $_REQUEST['saved'] ) echo '<div class="updated settings-error"><p>'.$themename.'修改已保存</p></div>';
?>

<div class="wrap d_wrap">
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/admin/admin.css"/>
    <h2><?php echo $themename; ?>设置
        <span class="d_themedesc">发布来源：<a href="http://www.cuizl.com/" target="_blank">翠竹林wordpress主题</a> &nbsp;&nbsp;</span><span style="font-size:16px;color: rgb(245, 99, 99);padding-left:20px;">觉得主题不错？加Q群484421506时刻关注最新版！</span>
    </h2>
<form method="post" class="d_formwrap">
<h2 class="nav-tab-wrapper">
    	<a class="nav-tab nav-tab-active" href="#panel_cg" onClick="clicke(this)">常规选项</a>
        <a class="nav-tab" href="#panel_gg" onClick="clicke(this)">广告选项</a>
        <a class="nav-tab" href="#panel_hd" onClick="clicke(this)">幻灯选项</a>
</h2>
<div class="panel" id="panel_cg" style="display:block;">
    <table>
    <thead>
        <tr>
            <th width="200"></th>
            <th></th>
        </tr>
    </thead>
    <tr>
        <td class="d_tit">网站描述</td>
        <td>
            <input class="ipt-b" type="text" id="d_description" name="d_description" value="<?php echo dopt('d_description'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">网站关键字</td>
        <td>
            <input class="ipt-b" type="text" id="d_keywords" name="d_keywords" value="<?php echo dopt('d_keywords'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">最新消息</td>
        <td>
            <textarea name="d_tui" id="d_tui" type="textarea" rows=""><?php echo dopt('d_tui'); ?></textarea>
            <span class="d_tip">最新消息显示在全站导航条下方，非常给力的推广位置</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">友情链接页面</td>
        <td>
            <label class="checkbox inline">
                只显示分类ID为 <input name="d_linkpage_cat" id="d_linkpage_cat" type="text" value="<?php echo dopt('d_linkpage_cat'); ?>"> 的链接(id之间用英文逗号隔开)，默认显示全部,如果要显示带头像的友情链接，请在notes中添加上链接邮箱
                &nbsp; &nbsp;
            </label>
        </td>
    </tr>
    <tr>
    	<td class="d_tit">友情链接加到侧栏方法</td>
        <td>
        	<span>用外观-&gt;小工具中的“文本”添加以下代码：<br/><b style="color:#d36b6b;">&lt;div class="d_tags_1"&gt;
&lt;a target="_blank" href="http://友情链接网址/"&gt;友情链接网名&lt;/a&gt;
&lt;a target="_blank" href="http://友情链接网址/"&gt;友情链接网名&lt;/a&gt;
&lt;/div&gt;</b><br/>不够的继续在&lt;/div&gt;前面加&lt;a target="_blank" href="http://友情链接网址/"&gt;友情链接网名&lt;/a&gt;
			</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">文章无特色图时不显示默认缩略图</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_thumbnail_b" name="d_thumbnail_b" <?php if(dopt('d_thumbnail_b')) echo 'checked="checked"' ?>>开启
            </label>
      列表Ajax加载分页内容
            <label class="checkbox inline">
                <input type="checkbox" id="d_ajaxpager_b" name="d_ajaxpager_b" <?php if(dopt('d_ajaxpager_b')) echo 'checked="checked"' ?>>开启
            </label>
		文章页顶部面包屑导航  <label class="checkbox inline">
                <input type="checkbox" id="d_singleMenu_b" name="d_singleMenu_b" <?php if(dopt('d_singleMenu_b')) echo 'checked="checked"' ?>>开启
            </label>
        </td>
    </tr>
 <tr>
      <td class="d_tit">热门排行</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="hot_list_check" name="hot_list_check" <?php if(dopt('hot_list_check')) echo 'checked="checked"' ?>>开启
            </label>
        显示天数 <input class="hot_list_date" name="hot_list_date" id="hot_list_date" type="number" value="<?php echo dopt('hot_list_date'); ?>"> 天（默认7）
	
	显示数量 <input class="hot_list_number" name="hot_list_number" id="hot_list_number" type="number" value="<?php echo dopt('hot_list_number'); ?>">条（默认10）

	&nbsp;&nbsp; 名称 <input class="d_inp_short" name="hot_list_title" id="hot_list_title" type="text" value="<?php echo dopt('hot_list_title'); ?>">
	</td>
    </tr>
    <tr>
        <td class="d_tit">列表文章属性开关</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_post_views_b" name="d_post_views_b" <?php if(dopt('d_post_views_b')) echo 'checked="checked"' ?>>不显示访客数
            </label> &nbsp; &nbsp; 
            <label class="checkbox inline">
                <input type="checkbox" id="d_post_author_b" name="d_post_author_b" <?php if(dopt('d_post_author_b')) echo 'checked="checked"' ?>>不显示作者
            </label> &nbsp; &nbsp; 
            <label class="checkbox inline">
                <input type="checkbox" id="d_post_comment_b" name="d_post_comment_b" <?php if(dopt('d_post_comment_b')) echo 'checked="checked"' ?>>不显示评论数
            </label> &nbsp; &nbsp; 
            <label class="checkbox inline">
                <input type="checkbox" id="d_post_time_b" name="d_post_time_b" <?php if(dopt('d_post_time_b')) echo 'checked="checked"' ?>>不显示时间
            </label> &nbsp; &nbsp; 
  	<label class="checkbox inline">
                <input type="checkbox" id="d_post_like_b" name="d_post_like_b" <?php if(dopt('d_post_like_b')) echo 'checked="checked"' ?>>不显示喜欢
            </label>
        </td>
    </tr>
        </td>
    </tr>
    <tr>
        <td class="d_tit">文章页 - 相关文章显示条数</td>
        <td>
            显示<input class="d_num" name="d_related_count" id="d_related_count" type="number" value="<?php echo dopt('d_related_count'); ?>">条 默认 8
        </td>
    </tr>
    <tr>
        <td class="d_tit">jQuery底部加载</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_jquerybom_b" name="d_jquerybom_b" <?php if(dopt('d_jquerybom_b')) echo 'checked="checked"' ?>>开启
            </label>
            <span class="d_tip">jQuery默认在head区域加载，如果需要页面载入加速，请开启，但是有可能影响部分依赖jQuery的插件失效。</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">用户登录信息和分享</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_sign_b" name="d_sign_b" <?php if(dopt('d_sign_b')) echo 'checked="checked"' ?>>开启用户登录信息
            </label>
 	    <label class="checkbox inline">
                <input type="checkbox" id="d_bdshare_b" name="d_bdshare_b" <?php if(dopt('d_bdshare_b')) echo 'checked="checked"' ?>>开启百度分享
            </label>
        </td>
    </tr>
    <tr>
        <td class="d_tit">投稿</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_tougao_b" name="d_tougao_b" <?php if(dopt('d_tougao_b')) echo 'checked="checked"' ?>>开启
            </label>
            投稿时间间隔 <input class="d_num" name="d_tougao_time" id="d_tougao_time" type="number" value="<?php echo dopt('d_tougao_time'); ?>"> 秒，默认：240
            &nbsp; &nbsp;
            投稿提醒邮箱 <input name="d_tougao_mailto" id="d_tougao_mailto" type="text" value="<?php echo dopt('d_tougao_mailto'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">评论头像缓存</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_avatar_b" name="d_avatar_b" <?php if(dopt('d_avatar_b')) echo 'checked="checked"' ?>>开启
            </label>
            <label class="d_number">
                缓存
                <input class="d_num " name="d_avatarDate" id="d_avatarDate" type="number" value="<?php if( dopt('d_avatarDate') ) echo dopt('d_avatarDate'); else echo '15'; ?>"> 天 
                &nbsp; &nbsp;
                开启后请确保网站根目录（与wp-content平级）有avatar文件夹，且权限设置成777
                <br>
                <span class="d_tip">缓存头像有利于头像加载和防备Gravatar头像站点被墙；如有报错等异常，请关闭，可能你的主机不支持</span>
            </label>
        </td>
    </tr>
 <tr>
        <td class="d_tit">评论内容过滤</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_spamComments_b" name="d_spamComments_b" <?php if(dopt('d_spamComments_b')) echo 'checked="checked"' ?>>开启
            </label>
           <span class="d_tip">开启后，会禁止有日文字符和纯英文的评论，不对外的建议开启。</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">侧栏模块固定</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_sideroll_b" name="d_sideroll_b" <?php if(dopt('d_sideroll_b')) echo 'checked="checked"' ?>>开启
            </label>
            <label class="d_number">
                滚动时 固定侧栏的 第
                <input class="d_num " name="d_sideroll_1" id="d_sideroll_1" type="number" value="<?php echo dopt('d_sideroll_1'); ?>"> 个模块
            </label>
            和
            <label class="d_number">
                第
                <input class="d_num " name="d_sideroll_2" id="d_sideroll_2" type="number" value="<?php echo dopt('d_sideroll_2'); ?>"> 个模块
            </label>
        </td>
    </tr>
    <tr>
        <td class="d_tit">禁止站内文章Pingback</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_pingback_b" name="d_pingback_b" <?php if(dopt('d_pingback_b')) echo 'checked="checked"' ?>>开启
                &nbsp; &nbsp;
                <span class="d_tip">开启后，不会发送站内Pingback，建议开启</span>
            </label>
        </td>
    </tr>
    <tr>
        <td class="d_tit">禁止后台编辑时自动保存</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_autosave_b" name="d_autosave_b" <?php if(dopt('d_autosave_b')) echo 'checked="checked"' ?>>开启
                &nbsp; &nbsp;
                <span class="d_tip">开启后，后台编辑文章时候不会定时保存，有效缩减数据库存储量；但是，一般不建议开启，除非你的数据库容量很小</span>
            </label>
        </td>
    </tr>
    
    <tr>
        <td class="d_tit">腾讯微博</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_tqq_b" name="d_tqq_b" <?php if(dopt('d_tqq_b')) echo 'checked="checked"' ?>>开启
            </label>
            网址：<input class="d_inp_short" name="d_tqq" id="d_tqq" type="text" value="<?php echo dopt('d_tqq'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">新浪微博</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_weibo_b" name="d_weibo_b" <?php if(dopt('d_weibo_b')) echo 'checked="checked"' ?>>开启
            </label>
            网址：<input class="d_inp_short" name="d_weibo" id="d_weibo" type="text" value="<?php echo dopt('d_weibo'); ?>">
        </td>
    </tr>
   <tr>
        <td class="d_tit">腾讯微信</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_weixin_b" name="d_weixin_b" <?php if(dopt('d_weixin_b')) echo 'checked="checked"' ?>>开启
            </label>
            订阅号：<input class="d_inp_short" name="d_weixin" id="d_weixin" type="text" value="<?php echo dopt('d_weixin'); ?>"><span class="d_tip">微信图片直接替换主题同名weixin.gif图片即可。</span>
        </td>
    </tr>
   <tr>
        <td class="d_tit">QQ联系代码</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_qqContact_b" name="d_qqContact_b" <?php if(dopt('d_qqContact_b')) echo 'checked="checked"' ?>>开启
                <span class="d_tip">例：tencent://message/?uin=QQ号码&Site=&Menu=yes </span>
            </label>
            代码：<input class="d_inp_short" name="d_qqContact" id="d_qqContact" type="text" value="<?php echo dopt('d_qqContact'); ?>">
        </td>
    </tr>
   <tr>
        <td class="d_tit">Email</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_emailContact_b" name="d_emailContact_b" <?php if(dopt('d_emailContact_b')) echo 'checked="checked"' ?>>开启
                <span class="d_tip">登录http://openmail.qq.com/获取邮我按钮链接 例：http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=fURFSE5NTUlMRT0MDFMeEhA </span>
            </label>
            网址：<input class="d_inp_short" name="d_emailContact" id="d_emailContact" type="text" value="<?php echo dopt('d_emailContact'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">Facebook</td>
        <td>
            <label class="checkbox inline">
               <input type="checkbox" id="d_facebook_b" name="d_facebook_b" <?php if(dopt('d_facebook_b')) echo 'checked="checked"' ?>>开启
            </label>
            网址：<input class="d_inp_short" name="d_facebook" id="d_facebook" type="text" value="<?php echo dopt('d_facebook'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">Twitter</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_twitter_b" name="d_twitter_b" <?php if(dopt('d_twitter_b')) echo 'checked="checked"' ?>>开启
            </label>
            网址：<input class="d_inp_short" name="d_twitter" id="d_twitter" type="text" value="<?php echo dopt('d_twitter'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">RSS订阅地址</td>
        <td>
            <input class="d_inp_short" name="d_rss" id="d_rss" type="text" value="<?php echo dopt('d_rss'); ?>">
            <span class="d_tip">可以是其他订阅托管站点的地址。边栏只能选择六个社交账户，否则会错位。</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">流量统计代码</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_track_b" name="d_track_b" <?php if(dopt('d_track_b')) echo 'checked="checked"' ?>>开启
  <span class="d_tip">统计网站流量，推荐使用百度统计，国内比较优秀且速度快；还可使用Google统计、CNZZ等</span>
            </label>
            <textarea name="d_track" id="d_track" type="textarea" rows="2"><?php echo dopt('d_track'); ?></textarea>
          
        </td>
    </tr>
    <tr>
        <td class="d_tit">页面头部公共代码</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_headcode_b" name="d_headcode_b" <?php if(dopt('d_headcode_b')) echo 'checked="checked"' ?>>开启
<span class="d_tip">会自动出现在页面头部（head区域），可放置广告代码等自定义（css或js）的全局代码块</span>
            </label>
            <textarea name="d_headcode" id="d_headcode" type="textarea" rows="2"><?php echo dopt('d_headcode'); ?></textarea>        
        </td>
    </tr>
     
    <tr>
        <td class="d_tit">页面头部头部右上角标签导航</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_topindex_01_b" name="d_topindex_01_b" <?php if(dopt('d_topindex_01_b')) echo 'checked="checked"' ?>>开启
                <span class="d_tip">例：&lt;li&gt;&lt;a target="_blank" href="http://www.cuizl.com/"&gt;翠竹林&lt;/a&gt;&lt;/li&gt;</span>
            </label>
            <textarea name="d_topindex_01" id="d_topindex_01" type="textarea" rows=""><?php echo dopt('d_topindex_01'); ?></textarea>
        </td>
    </tr>
    <tr>
        <td class="d_tit">页面底部公共代码1</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_footcode_a" name="d_footcode_a" <?php if(dopt('d_footcode_a')) echo 'checked="checked"' ?>>开启
 <span class="d_tip">例：&lt;h2&gt;企业站定制，我们更专业！&lt;/h2&gt;&lt;a class="btn btn-lg" href="http://www.cuizl.com" target="_blank"&gt;联系我们&lt;/a&gt;</span>
            </label>
            <textarea name="d_footcode_1" id="d_footcode_1" type="textarea" rows="2"><?php echo dopt('d_footcode_1'); ?></textarea>
           
        </td>
    </tr>
    <tr>
        <td class="d_tit">页面底部公共代码2</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_footcode_b" name="d_footcode_b" <?php if(dopt('d_footcode_b')) echo 'checked="checked"' ?>>开启
 <span class="d_tip">同上，但是在全站页面底部出现</span>
            </label>
            <textarea name="d_footcode" id="d_footcode" type="textarea" rows="2"><?php echo dopt('d_footcode'); ?></textarea>
           
        </td>
    </tr>
    <tr>
        <td class="d_tit"></td>
        <td>
            <div class="d_desc">
                <input class="button-primary" name="save" type="submit" value="保存设置">
            </div>
            <input type="hidden" name="action" value="save">
        </td>
    </tr>

    </table>
</div>
<div class="panel" id="panel_gg">
	<table>
        <tr>
            <td class="d_tit">广告：全站 - 导航下横幅</td>
            <td>
                <label class="checkbox inline">
                    <input type="checkbox" id="d_adsite_01_b" name="d_adsite_01_b" <?php if(dopt('d_adsite_01_b')) echo 'checked="checked"' ?>>开启
     <span class="d_tip">广告区域，任意联盟广告和自定义广告的代码均可，下同</span>
                </label>
                <textarea name="d_adsite_01" id="d_adsite_01" type="textarea" rows=""><?php echo dopt('d_adsite_01'); ?></textarea>
               
            </td>
        </tr>
        <tr>
            <td class="d_tit">广告：全站正文列表最前</td>
            <td>
                <label class="checkbox inline">
                    <input type="checkbox" id="d_adindex_02_b" name="d_adindex_02_b" <?php if(dopt('d_adindex_02_b')) echo 'checked="checked"' ?>>开启
                </label>
                <textarea name="d_adindex_02" id="d_adindex_02" type="textarea" rows=""><?php echo dopt('d_adindex_02'); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="d_tit">广告：首页 - 导航下横幅</td>
            <td>
                <label class="checkbox inline">
                    <input type="checkbox" id="d_adindex_01_b" name="d_adindex_01_b" <?php if(dopt('d_adindex_01_b')) echo 'checked="checked"' ?>>开启
                </label>
                <textarea name="d_adindex_01" id="d_adindex_01" type="textarea" rows=""><?php echo dopt('d_adindex_01'); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="d_tit">广告：首页 - 正文最前上</td>
            <td>
                <label class="checkbox inline">
                    <input type="checkbox" id="d_adindex_03_b" name="d_adindex_03_b" <?php if(dopt('d_adindex_03_b')) echo 'checked="checked"' ?>>开启
                </label>
                <textarea name="d_adindex_03" id="d_adindex_03" type="textarea" rows=""><?php echo dopt('d_adindex_03'); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="d_tit">广告：文章页 - 页面标题下</td>
            <td>
                <label class="checkbox inline">
                    <input type="checkbox" id="d_adpost_01_b" name="d_adpost_01_b" <?php if(dopt('d_adpost_01_b')) echo 'checked="checked"' ?>>开启
                </label>
                <textarea name="d_adpost_01" id="d_adpost_01" type="textarea" rows=""><?php echo dopt('d_adpost_01'); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="d_tit">广告：文章页 - 相关文章下</td>
            <td>
                <label class="checkbox inline">
                    <input type="checkbox" id="d_adpost_02_b" name="d_adpost_02_b" <?php if(dopt('d_adpost_02_b')) echo 'checked="checked"' ?>>开启
                </label>
                <textarea name="d_adpost_02" id="d_adpost_02" type="textarea" rows=""><?php echo dopt('d_adpost_02'); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="d_tit">广告：文章页 - 网友评论下</td>
            <td>
                <label class="checkbox inline">
                    <input type="checkbox" id="d_adpost_03_b" name="d_adpost_03_b" <?php if(dopt('d_adpost_03_b')) echo 'checked="checked"' ?>>开启
                </label>
                <textarea name="d_adpost_03" id="d_adpost_03" type="textarea" rows=""><?php echo dopt('d_adpost_03'); ?></textarea>
            </td>
        </tr>
        <tr>
                <td class="d_tit">手机广告：全站正文列表最前</td>
                <td>
                    <label class="checkbox inline">
                        <input type="checkbox" id="Mobiled_adindex_02_b" name="Mobiled_adindex_02_b" <?php if(dopt('Mobiled_adindex_02_b')) echo 'checked="checked"' ?>>开启 <span class="d_tip">手机广告只适合在手机中投放。例如百度联盟移动广告，PC端不会显示。下同。</span>
                    </label>
                    <textarea name="Mobiled_adindex_02" id="Mobiled_adindex_02" type="textarea" rows=""><?php echo dopt('Mobiled_adindex_02'); ?></textarea>
                </td>
            </tr>
        <tr>
                <td class="d_tit">手机广告：文章页 - 页面标题下</td>
                <td>
                    <label class="checkbox inline">
                        <input type="checkbox" id="Mobiled_adpost_01_b" name="Mobiled_adpost_01_b" <?php if(dopt('Mobiled_adpost_01_b')) echo 'checked="checked"' ?>>开启
                    </label>
                    <textarea name="Mobiled_adpost_01" id="Mobiled_adpost_01" type="textarea" rows=""><?php echo dopt('Mobiled_adpost_01'); ?></textarea>
                </td>
            </tr>
        <tr>
                <td class="d_tit">手机广告：文章页 - 相关文章下</td>
                <td>
                    <label class="checkbox inline">
                        <input type="checkbox" id="Mobiled_adpost_02_b" name="Mobiled_adpost_02_b" <?php if(dopt('Mobiled_adpost_02_b')) echo 'checked="checked"' ?>>开启
                    </label>
                    <textarea name="Mobiled_adpost_02" id="Mobiled_adpost_02" type="textarea" rows=""><?php echo dopt('Mobiled_adpost_02'); ?></textarea>
                </td>
            </tr>
        <tr>
            <td class="d_tit"></td>
            <td>
                <div class="d_desc">
                    <input class="button-primary" name="save" type="submit" value="保存设置">
                </div>
                <input type="hidden" name="action" value="save">
            </td>
    	</tr>
    </table>
</div>
<div class="panel" id="panel_hd">
	<table cellspacing="1">
        <tr>
            <td class="d_tit">首页置顶推荐幻灯片</td>
            <td>
                <label class="checkbox inline">
                    <input type="checkbox" id="d_sticky_b" name="d_sticky_b" <?php if(dopt('d_sticky_b')) echo 'checked="checked"' ?>>开启
                </label>
            </td>
        </tr>
        <tr>
            <th>
           		<label for="git_slick1img_b">幻灯片一图片</label>
            </th>
            <td>
                <label>
                    图片链接:<input id="git_slick1img_b" class="regular-text" type="text" value="<?php echo dopt('git_slick1img_b'); ?>" name="git_slick1img_b">
                </label>
                <label>
                    图片跳转:<input id="git_slick1url_b" class="regular-text" type="text" value="<?php echo dopt('git_slick1url_b'); ?>" name="git_slick1url_b">
                </label>
                <label>
                    图片名字:<input id="git_slick1title_b" class="regular-text" type="text" value="<?php echo dopt('git_slick1title_b'); ?>" name="git_slick1title_b">
                </label>
            </td>
        </tr>
                <tr>
            <th>
           		<label for="git_slick1img_b">幻灯片二图片</label>
            </th>
            <td>
                <label>
                    图片链接:<input id="git_slick2img_b" class="regular-text" type="text" value="<?php echo dopt('git_slick2img_b'); ?>" name="git_slick2img_b">
                </label>
                <label>
                    图片跳转:<input id="git_slick2url_b" class="regular-text" type="text" value="<?php echo dopt('git_slick2url_b'); ?>" name="git_slick2url_b">
                </label>
                <label>
                    图片名字:<input id="git_slick2title_b" class="regular-text" type="text" value="<?php echo dopt('git_slick2title_b'); ?>" name="git_slick2title_b">
                </label>
            </td>
        </tr>
                <tr>
            <th>
           		<label for="git_slick1img_b">幻灯片三图片</label>
            </th>
            <td>
                <label>
                    图片链接:<input id="git_slick3img_b" class="regular-text" type="text" value="<?php echo dopt('git_slick3img_b'); ?>" name="git_slick3img_b">
                </label>
                <label>
                    图片跳转:<input id="git_slick3url_b" class="regular-text" type="text" value="<?php echo dopt('git_slick3url_b'); ?>" name="git_slick3url_b">
                </label>
                <label>
                    图片名字:<input id="git_slick3title_b" class="regular-text" type="text" value="<?php echo dopt('git_slick3title_b'); ?>" name="git_slick3title_b">
                </label>
            </td>
        </tr>
                <tr>
            <th>
           		<label for="git_slick1img_b">幻灯片四图片</label>
            </th>
            <td>
                <label>
                    图片链接:<input id="git_slick4img_b" class="regular-text" type="text" value="<?php echo dopt('git_slick4img_b'); ?>" name="git_slick4img_b">
                </label>
                <label>
                    图片跳转:<input id="git_slick4url_b" class="regular-text" type="text" value="<?php echo dopt('git_slick4url_b'); ?>" name="git_slick4url_b">
                </label>
                <label>
                    图片名字:<input id="git_slick4title_b" class="regular-text" type="text" value="<?php echo dopt('git_slick4title_b'); ?>" name="git_slick4title_b">
                </label>
            </td>
        </tr>
                <tr>
            <th>
           		<label for="git_slick1img_b">幻灯片五图片</label>
            </th>
            <td>
                <label>
                    图片链接:<input id="git_slick5img_b" class="regular-text" type="text" value="<?php echo dopt('git_slick5img_b'); ?>" name="git_slick5img_b">
                </label>
                <label>
                    图片跳转:<input id="git_slick5url_b" class="regular-text" type="text" value="<?php echo dopt('git_slick5url_b'); ?>" name="git_slick5url_b">
                </label>
                <label>
                    图片名字:<input id="git_slick5title_b" class="regular-text" type="text" value="<?php echo dopt('git_slick5title_b'); ?>" name="git_slick5title_b">
                </label>
            </td>
        </tr>
                <tr>
            <th>
           		<label for="git_slick1img_b">幻灯片六图片</label>
            </th>
            <td>
                <label>
                    图片链接:<input id="git_slick6img_b" class="regular-text" type="text" value="<?php echo dopt('git_slick6img_b'); ?>" name="git_slick6img_b">
                </label>
                <label>
                    图片跳转:<input id="git_slick6url_b" class="regular-text" type="text" value="<?php echo dopt('git_slick6url_b'); ?>" name="git_slick6url_b">
                </label>
                <label>
                    图片名字:<input id="git_slick6title_b" class="regular-text" type="text" value="<?php echo dopt('git_slick6title_b'); ?>" name="git_slick6title_b">
                </label>
            </td>
        </tr>
                <tr>
            <th>
           		<label for="git_slick1img_b">幻灯片七图片</label>
            </th>
            <td>
                <label>
                    图片链接:<input id="git_slick7img_b" class="regular-text" type="text" value="<?php echo dopt('git_slick7img_b'); ?>" name="git_slick7img_b">
                </label>
                <label>
                    图片跳转:<input id="git_slick7url_b" class="regular-text" type="text" value="<?php echo dopt('git_slick7url_b'); ?>" name="git_slick7url_b">
                </label>
                <label>
                    图片名字:<input id="git_slick7title_b" class="regular-text" type="text" value="<?php echo dopt('git_slick7title_b'); ?>" name="git_slick7title_b">
                </label>
            </td>
        </tr>
        <tr>
            <td class="d_tit"></td>
            <td>
                <div class="d_desc">
                    <input class="button-primary" name="save" type="submit" value="保存设置">
                </div>
                <input type="hidden" name="action" value="save">
            </td>
    	</tr>
    </table>
</div>
</form>
</div>
<script>
var aaa = []
jQuery('.d_wrap input, .d_wrap textarea').each(function(e){
    if( jQuery(this).attr('id') ) aaa.push( jQuery(this).attr('id') )
})
console.log( aaa )
</script>
<style>.catlist{border:2px solid #FFB6C1;padding:5px;margin-top: 12px;text-align: center;color:#000;}.yunluotips{border: 2px solid #FFCC33;padding: 15px}.panel{display:none}.panel h3{margin:0;font-size:1.2em}#panel_update ul{list-style-type:disc}.nav-tab-wrapper{clear:both}.nav-tab{position:relative}.nav-tab i:before{position:absolute;top:-10px;right:-8px;display:inline-block;padding:2px;border-radius:50%;background:#e14d43;color:#fff;content:"\f463";vertical-align:text-bottom;font:400 18px/1 dashicons;speak:none}#theme-options-search{display:none;float:right;margin-top:-34px;width:280px;font-weight:300;font-size:16px;line-height:1.5}.updated+#theme-options-search{margin-top:-91px}.wrap.searching .nav-tab-wrapper a,.wrap.searching .panel tr,#attrselector{display:none}.wrap.searching .panel{display:block !important}#attrselector[attrselector*=ok]{display:block}</style>
<style id="theme-options-filter"></style>
<div id="attrselector" attrselector="ok" ></div>
<script>
jQuery(function ($) {
    $(".nav-tab").click(function () {
        $(this).addClass("nav-tab-active").siblings().removeClass("nav-tab-active");
        $(".panel").hide();
        $($(this).attr("href")).show();
        return false;
    });

    var themeOptionsFilter = $("#theme-options-filter");
    themeOptionsFilter.text("ok");
    if ($("#attrselector").is(":visible") && themeOptionsFilter.text() != "") {
        $(".panel tr").each(function (el) {
            $(this).attr("data-searchtext", $(this).text().replace(/\r|\n/g, '').replace(/ +/g, ' ').toLowerCase());
        });

        var wrap = $(".wrap");
        $("#theme-options-search").show().on("input propertychange", function () {
            var text = $(this).val().replace(/^ +| +$/, "").toLowerCase();
            if (text != "") {
                wrap.addClass("searching");
                themeOptionsFilter.text(".wrap.searching .panel tr[data-searchtext*='" + text + "']{display:block}");
            } else {
                wrap.removeClass("searching");
                themeOptionsFilter.text("");
            };
        });
    };
});
</script>
<?php } ?>
<?php add_action('admin_menu', 'mytheme_add_admin');?>