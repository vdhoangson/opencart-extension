<div id="<?php echo $module; ?>">
<?php if($testimonials){ ?>
  <?php foreach ($testimonials as $testimonial) { ?>

    <article class="item testimonial with-subtitle">
        <div class="entry-content">
            <p>
                <?php echo $testimonial['message']; ?>
            </p>
            <p><span class="star-<?php echo $testimonial['rating'];?>"></span></p>
        </div>

			<span class="testimonial-thumbnail">
			<img src="<?php echo $testimonial['avatar']; ?>" class="img-responsive avatar" alt="<?php echo $testimonial['name'];?>">		</span>

        <header class="entry-header">
            <h3 class="entry-title"><?php echo $testimonial['name']; ?></h3>
            <p class="entry-subtitle"><?php echo $testimonial['competence']; ?></p>
        </header>
    </article>


  <?php } ?>
  
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#<?php echo $module; ?>').owlCarousel({
    items: 6,
    autoPlay: 5000,
    singleItem: true,
    navigation: false,
    pagination: false,
    rtl:true,
    transitionStyle: 'fade'
});
--></script>