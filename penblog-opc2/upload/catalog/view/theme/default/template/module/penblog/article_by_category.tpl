<div class="set-default">
<?php if($categories){ ?>
	<?php foreach($categories as $category){ ?>
		<h3><?php echo $category['name']; ?></h3>
	<?php if($category['articles']){ ?>
		<div class="row">
		<?php foreach($category['articles'] as $article){ ?>
		<div class="product-layout <?php echo $display.' '.$cols; ?>">
          <div class="product-thumb">
            <div class="image">
              <?php if($article['img_type']=='image'){ ?>
              	<a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a>
              <?php } elseif($article['img_type']=='youtube') { ?>
                <div class="flex-video">
                  <iframe src="<?php echo $article['image']; ?>" style="border: none;"></iframe>
                </div>
              <?php } ?>
            </div>
            <div>
              <div class="caption">
                <h4><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h4>
                <div class="info hidden-xs">
                  <?php if($setting['catalog_show_author']){ ?>
                  <span data-toggle="tooltip" title="<?php echo $text_author; ?>"><i class="fa fa-user"></i> <?php echo $article['author']; ?></span>
                  <?php } ?>
                  <?php if($setting['catalog_show_date_added']){ ?>
                  <span data-toggle="tooltip" title="<?php echo $text_date_added; ?>"><i class="fa fa-pencil"></i> <?php echo $article['date_added']; ?></span>
                  <?php } ?>
                  <?php if($setting['catalog_show_viewed']){ ?>
                  <span data-toggle="tooltip" title="<?php echo $text_viewed; ?>"><i class="fa fa-eye"></i> <?php echo $article['viewed']; ?></span>
                  <?php } ?>
                </div>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($article['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <p><?php echo $article['short_description']; ?></p>
              </div>
              <a class="btn btn-primary button_readmore" href="<?php echo $article['href']; ?>"><?php echo $text_readmore; ?></a>
            </div>
          </div>
        </div>
		<?php } ?>
		</div>
	<?php } else { ?>
		<div class="row"><?php echo $text_empty; ?></div>
	<?php } ?>
	<?php } ?>
<?php } ?>
</div>