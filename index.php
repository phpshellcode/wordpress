<?php get_header(); ?>
<?php if( dopt('d_adindex_01_b') ) printf('<div class="banner banner-navbar">'.dopt('d_adindex_01').'</div>'); ?>
<div class="content-wrap">
	<div class="content">
	<?php 
		if( $paged && $paged > 1 ){
			if( dopt('d_adindex_03_b') ) printf('<div class="banner banner-contenttop">'.dopt('d_adindex_03').'</div>');
			printf('<header class="archive-header"><h1>最新发布 <span>第'.$paged.'页</span></h1></header>');
		}else{
			if( dopt('d_sticky_b') ) include 'modules/sticky.php';
			if( dopt('d_adindex_03_b') ) printf('<div class="banner banner-contenttop">'.dopt('d_adindex_03').'</div>');
	?>
    <div class="daodu clr">
      <div class="tip">
        <h4>精选导读</h4>
      </div>
      <ul class="dd-list">
      <?php
     	query_posts(array('showposts' => 4 ,"post__in" => get_option("sticky_posts")));	
		while (have_posts()): the_post();
	  ?>
        <li>
          <figure class="dd-img"> 
                    <a title="<?php the_title(); ?>" target="_blank" href="<?php the_permalink(); ?>">
          <?php
			    echo '<img src="' . get_bloginfo("template_url") . '/timthumb.php?src=';
				echo post_thumbnail_src();
				echo '&q=90&zc=1&ct=1&h=112&w=168" style="display: inline;" alt="' . get_the_title() . '" />';
			?>
          </a></figure>
          <div class="dd-content">
            <h2 class="dd-title"> <a rel="bookmark" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h2>
            <div class="dd-site xs-hidden"><?php echo deel_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 40, '...'); ?></div>
          </div>
        </li>
        <?php
        endwhile;
		// 重置query
		wp_reset_query();
		?>
      </ul>
    </div>
    
    <?php
			if((is_home() || is_front_page())) {
				echo '<header class="archive-header"><h1>最新发布</h1></header>';
			}
		}

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
		    'caller_get_posts' => 1,
		    'paged' => $paged,
			'ignore_sticky_posts' => 1
		);
		query_posts($args);
		include 'modules/excerpt.php'; 
	?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>