<div class="slick_bor">
<script src="<?php bloginfo('template_url'); ?>/js/responsiveslides.min.js"></script>
<ul class="slick">
<?php
if (dopt('git_slick1img_b')) { ?><li><a href="<?php
    echo dopt('git_slick1url_b'); ?>"><img class="img_855x300" src="<?php
    echo dopt('git_slick1img_b'); ?>" alt="<?php
    echo dopt('git_slick1title_b'); ?>"><span><?php
    echo dopt('git_slick1title_b'); ?></span></a></li><?php
} ?>
<?php
if (dopt('git_slick2img_b')) { ?><li><a href="<?php
    echo dopt('git_slick2url_b'); ?>"><img class="img_855x300" src="<?php
    echo dopt('git_slick2img_b'); ?>" alt="<?php
    echo dopt('git_slick2title_b'); ?>"><span><?php
    echo dopt('git_slick2title_b'); ?></span></a></li><?php
} ?>
<?php
if (dopt('git_slick3img_b')) { ?><li><a href="<?php
    echo dopt('git_slick3url_b'); ?>"><img class="img_855x300" src="<?php
    echo dopt('git_slick3img_b'); ?>" alt="<?php
    echo dopt('git_slick3title_b'); ?>"><span><?php
    echo dopt('git_slick3title_b'); ?></span></a></li><?php
} ?>
<?php
if (dopt('git_slick4img_b')) { ?><li><a href="<?php
    echo dopt('git_slick4url_b'); ?>"><img class="img_855x300" src="<?php
    echo dopt('git_slick4img_b'); ?>" alt="<?php
    echo dopt('git_slick4title_b'); ?>"><span><?php
    echo dopt('git_slick4title_b'); ?></span></a></li><?php
} ?>
<?php
if (dopt('git_slick5img_b')) { ?><li><a href="<?php
    echo dopt('git_slick5url_b'); ?>"><img class="img_855x300" src="<?php
    echo dopt('git_slick5img_b'); ?>" alt="<?php
    echo dopt('git_slick5title_b'); ?>"><span><?php
    echo dopt('git_slick5title_b'); ?></span></a></li><?php
} ?>
<?php
if (dopt('git_slick6img_b')) { ?><li><a href="<?php
    echo dopt('git_slick6url_b'); ?>"><img class="img_855x300" src="<?php
    echo dopt('git_slick6img_b'); ?>" alt="<?php
    echo dopt('git_slick6title_b'); ?>"><span><?php
    echo dopt('git_slick6title_b'); ?></span></a></li><?php
} ?>
<?php
if (dopt('git_slick7img_b')) { ?><li><a href="<?php
    echo dopt('git_slick7url_b'); ?>"><img class="img_855x300" src="<?php
    echo dopt('git_slick7img_b'); ?>" alt="<?php
    echo dopt('git_slick7title_b'); ?>"><span><?php
    echo dopt('git_slick7title_b'); ?></span></a></li><?php
} ?>
</ul>
<script>
$(function() {
	var mx = document.body.clientWidth;
	$(".slick").responsiveSlides({
	   auto: true,
	   pager: true,
	   nav: true,
	   speed:700,
	   timeout: 7000,
	   maxwidth: mx,
	   namespace: "centered-btns"
    });
});
</script>
<div class="ws_shadow"></div>
</div>
