<div id="<?php echo $module; ?>" class="owl-carousel">
	<?php foreach ($articles as $article) { ?>
	<div class="item text-center">
        <?php if($article['img_type']=='image'){ ?>
          <a href="<?php echo !empty($article['href'])?$article['href']:''; ?>"><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a>
        <?php } elseif($article['img_type']=='youtube') { ?>
        <div class="flex-video">
          <iframe src="<?php echo $article['image']; ?>" style="border: none;"></iframe>
        </div>
        <?php } ?>
        <div class="ic_caption">
          <h3><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h3>
        </div>
	</div>
	<?php } ?>
</div>

<script type="text/javascript">
$('#<?php echo $module; ?>').owlCarousel({
    items: 4,
    margin: 10,
    <?php if($block_data['show_nav']==1){ ?>
    navigation: <?php echo $block_data['show_nav']==1?true:'false'; ?>,
    navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
    <?php } ?>
    autoplay: <?php echo $block_data['autoscroll']==1?true:'false'; ?>,
    autoplayHoverPause: <?php echo $block_data['pauseonhover']==1?true:'false'; ?>,
    pagination: <?php echo $block_data['show_dot']==1?true:'false'; ?>
});
</script>
