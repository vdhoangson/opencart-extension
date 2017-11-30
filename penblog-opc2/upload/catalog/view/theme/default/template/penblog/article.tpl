<?php echo $header; ?>
<div class="container" id="penblog_article">
   <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
   </ul>
   <div class="row">
      <?php echo $column_left; ?>
      <?php if ($column_left && $column_right) { ?>
      <?php $class = 'col-sm-6'; ?>
      <?php } elseif ($column_left || $column_right) { ?>
      <?php $class = 'col-sm-9'; ?>
      <?php } else { ?>
      <?php $class = 'col-sm-12'; ?>
      <?php } ?>
      <div id="content" class="<?php echo $class; ?>">
         <?php echo $content_top; ?>
         <div class="row">
            <?php if ($column_left && $column_right) { ?>
            <?php $class = 'col-sm-6'; ?>
            <?php } elseif ($column_left || $column_right) { ?>
            <?php $class = 'col-sm-6'; ?>
            <?php } else { ?>
            <?php $class = 'col-sm-8'; ?>
            <?php } ?>
            <div class="<?php echo $class; ?>">
               <ul class="thumbnails">
                  <?php if ($thumb_main_image) { ?>
                  <li>
                  <?php if($img_type['type']=='image'){ ?>
                  <a class="thumbnail" href="<?php echo $popup_main_image; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb_main_image; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
                  <?php } elseif($img_type['type']=='youtube') { ?>
                  <a class="thumbnail">
                  <iframe width="<?php echo $article_thumb_width; ?>" height="<?php echo $article_thumb_height; ?>" src="<?php echo $thumb_main_image; ?>" style="border: none;"></iframe></a>
                  <?php } ?>
                  </li>
                  <?php } ?>
                  <?php if ($images) { ?>
                    <?php foreach ($images as $image) { ?>
                    <li class="image-additional"><a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
                    <?php } ?>
                  <?php } ?>
               </ul>
            </div>
            <?php if ($column_left && $column_right) { ?>
            <?php $class = 'col-sm-6'; ?>
            <?php } elseif ($column_left || $column_right) { ?>
            <?php $class = 'col-sm-6'; ?>
            <?php } else { ?>
            <?php $class = 'col-sm-4'; ?>
            <?php } ?>
            <div class="<?php echo $class; ?>">
               <h1><?php echo $heading_title; ?></h1>
               <?php echo $short_description; ?>
               <?php if ($comment_status && $allow_comment) { ?>
               <div class="rating">
                  <p>
                     <?php for ($i = 1; $i <= 5; $i++) { ?>
                     <?php if ($rating < $i) { ?>
                     <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                     <?php } else { ?>
                     <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                     <?php } ?>
                     <?php } ?>
                     <?php echo $comments; ?>
                  </p>
                  <hr>
               </div>
               <?php } ?>
               <?php if($article_show_author || $article_show_date_added || $article_show_date_modified || $article_show_viewed){ ?>
               <div class="info">
                  <?php if($article_show_author){ ?>
                  <span data-toggle="tooltip" title="<?php echo $text_author; ?>"><i class="fa fa-user"></i> <?php echo $author; ?></span>
                  <?php } ?>
                  <?php if($article_show_date_added){ ?>
                  <span data-toggle="tooltip" title="<?php echo $text_date_added; ?>"><i class="fa fa-pencil"></i> <?php echo $date_added; ?></span>
                  <?php } ?>
                  <?php if($article_show_date_modified){ ?>
                  <span data-toggle="tooltip" title="<?php echo $text_date_modified; ?>"><i class="fa fa-pencil-square"></i> <?php echo $date_modified; ?></span>
                  <?php } ?>
                  <?php if($article_show_viewed){ ?>
                  <span data-toggle="tooltip" title="<?php echo $text_viewed; ?>"><i class="fa fa-eye"></i> <?php echo $viewed; ?></span>
                  <?php } ?>
                  <span data-toggle="tooltip" title="Category"><i class="fa fa-folder"></i>
                  <?php foreach($categories as $category){ ?>
                  <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                  <?php } ?>
                  </span>
               </div>
               <?php } ?>
               <?php if($article_show_share_btn){ ?>
               <hr />
               <!-- AddThis Button BEGIN -->
               <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
               <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
               <!-- AddThis Button END -->
               <?php } ?>
            </div>
         </div>
         <div class="row">
            <?php if(!empty($polls)){ ?>
            <div class="col-md-6"><?php echo $description; ?></div>
            <div class="col-md-6">
            <?php echo $polls; ?>
            </div>
            <?php } else { ?>
            <div class="col-md-12"><?php echo $description; ?></div>
            <?php } ?>
         </div>
         <?php if(!empty($products)){ ?>
         <div class="row">
          <div class="col-md-12">
           <?php if($article_product_display=='grid_carousel'){ $class = 'item-carousel'; } else { $class = 'product-layout col-lg-3 col-md-3 col-sm-12 col-xs-12'; } ?>
              <div id="product-article" class="<?php echo $article_product_display=='grid_carousel'?'owl-carousel':''; ?>">
                <?php foreach($products as $product){ ?>
                <div class="<?php echo $class; ?>">
                  <div class="product-thumb transition">
                    <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                    <div class="caption">
                      <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                      <?php if ($product['rating']) { ?>
                      <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <?php if ($product['rating'] < $i) { ?>
                        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <?php } else { ?>
                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <?php } ?>
                        <?php } ?>
                      </div>
                      <?php } ?>
                      <?php if ($product['price']) { ?>
                      <p class="price">
                        <?php if (!$product['special']) { ?>
                        <?php echo $product['price']; ?>
                        <?php } else { ?>
                        <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                        <?php } ?>
                        <?php if ($product['tax']) { ?>
                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                        <?php } ?>
                      </p>
                      <?php } ?>
                    </div>
                    <div class="button-group">
                      <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                      <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                      <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
              <?php if($article_product_display=='grid_carousel'){ ?>
              <script type="text/javascript"><!--
                $('#product-article').owlCarousel({
                    items: 4,
                    loop: false,
                    autoWidth: true,
                    autoHeight: true,
                    navigation: true,
                    navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
                    autoplay:true,
                    autoPlay: 3000,
                    autoplayHoverPause:true,
                    pagination: true

                });
              --></script>
              <?php } ?>
            </div>
         </div>
         <?php } ?>
         <?php if ($tags) { ?>
         <div class="row">
           <div class="col-md-12 col-xs-12">
            <p><?php echo $text_tags; ?>
              <?php for ($i = 0; $i < count($tags); $i++) { ?>
              <?php if ($i < (count($tags) - 1)) { ?>
              &nbsp; <a href="<?php echo $tags[$i]['href']; ?>"><i class="fa fa-tag"></i> <?php echo $tags[$i]['tag']; ?></a>,
              <?php } else { ?>
              &nbsp; <a href="<?php echo $tags[$i]['href']; ?>"><i class="fa fa-tag"></i> <?php echo $tags[$i]['tag']; ?></a>
              <?php } ?>
              <?php } ?>
            </p>
           </div>
         </div>
         <?php } ?>
         <div class="row">
            <div class="col-md-12">
               <ul class="nav nav-tabs">
                  <?php if ($articles_related) { ?>
                  <li><a href="#tab-related" data-toggle="tab"><?php echo $text_related; ?></a></li>
                  <?php } if ($comment_status && $allow_comment) { ?>
                  <li><a href="#tab-comment" data-toggle="tab"><?php echo $tab_comment; ?></a></li>
                  <?php } if($downloads){ ?>
                  <li><a href="#tab-download" data-toggle="tab"><?php echo $tab_download; ?></a></li>
                  <?php } ?>
               </ul>
               <div class="tab-content">
                  <?php if ($articles_related) { ?>
                  <?php if ($column_left && $column_right) { ?>
                  <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
                  <?php } elseif ($column_left || $column_right) { ?>
                  <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
                  <?php } else { ?>
                  <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
                  <?php } ?>
                  <div class="tab-pane" id="tab-related">
                     <div id="article-related" class="row <?php echo $article_related_display=='grid_carousel'?'owl-carousel owl-theme':''; ?>">
                        <?php $i = 0; ?>
                        <?php foreach ($articles_related as $article) { ?>
                        <div class="<?php echo $article_related_display=='grid_carousel'?'item-carousel':$class; ?>">
                           <div class="product-thumb transition">
                              <div class="image">
                                <?php if($article['img_type']=='image'){ ?>
                                <a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a>
                                <?php } elseif($article['img_type']=='youtube') { ?>
                                   <iframe width="<?php echo $article_related_width; ?>" height="<?php echo $article_related_height; ?>" src="<?php echo $article['thumb']; ?>" style="border: none;"></iframe>
                                <?php } ?>
                              </div>
                              <div class="caption">
                                 <h4><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h4>
                                 <p><?php echo $short_description; ?></p>
                                 <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <?php if ($article['rating'] < $i) { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                    <?php } else { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                    <?php } ?>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php $i++; ?>
                        <?php } ?>

                        <?php if($article_related_display=='grid_carousel'){ ?>
                        <script type="text/javascript"><!--
                          $('#article-related').owlCarousel({
                              items: 4,
                              loop: false,
                              autoWidth: true,
                              autoHeight: true,
                              navigation: true,
                              navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
                              autoplay:true,
                              autoPlay: 3000,
                              autoplayHoverPause:true,
                              pagination: true

                          });
                        --></script>
                        <?php } ?>
                     </div>
                  </div>
                  <?php } ?>
                  <?php if ($comment_status && $allow_comment) { ?>
                  <div class="tab-pane" id="tab-comment">
                     <form class="form-horizontal" id="form-comment">
                        <div id="comment"></div>
                        <h2><?php echo $text_write; ?></h2>
                        <div class="form-group required">
                           <div class="col-sm-6">
                              <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                              <input type="text" name="name" value="" id="input-name" class="form-control" />
                           </div>
                           <div class="col-sm-6">
                              <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                              <input type="text" name="email" value="" id="input-email" class="form-control" />
                           </div>
                        </div>
                        <div class="form-group required">
                           <div class="col-sm-12">
                              <label class="control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                              <textarea name="text" rows="5" id="input-comment" class="form-control"></textarea>
                              <div class="help-block"><?php echo $text_note; ?></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="col-sm-3">
                              <label class="control-label"><?php echo $entry_rating; ?></label>
                              &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                              <input type="radio" name="rating" value="1" />
                              &nbsp;
                              <input type="radio" name="rating" value="2" />
                              &nbsp;
                              <input type="radio" name="rating" value="3" />
                              &nbsp;
                              <input type="radio" name="rating" value="4" />
                              &nbsp;
                              <input type="radio" name="rating" value="5" />
                              &nbsp;<?php echo $entry_good; ?>
                           </div>
                           <div class="col-sm-9">
                              <?php echo $captcha; ?>
                           </div>
                        </div>
                        <div class="buttons clearfix">
                           <div class="pull-right">
                              <button type="button" id="button-comment" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                           </div>
                        </div>
                     </form>
                  </div>
                  <?php } ?>
                  <?php if($downloads) { ?>
                  <div class="tab-pane" id="tab-download">
                    <div class="list-group">
                    <?php foreach($downloads as $download){ ?>
                      <a href="<?php echo $download['href']; ?>" class="list-group-item"><?php echo $download['name']; ?><i class="fa fa-download pull-right"></i></a>
                    <?php } ?>
                    </div>
                  </div>
                  <?php } ?>
               </div>
            </div>
         </div>
         
         <?php echo $content_bottom; ?>
      </div>
      <?php echo $column_right; ?>
   </div>
</div>
<script type="text/javascript"><!--
   $('#comment').delegate('.pagination a', 'click', function(e) {
     e.preventDefault();

       $('#comment').fadeOut('slow');

       $('#comment').load(this.href);

       $('#comment').fadeIn('slow');
   });

   $('#comment').load('index.php?route=penblog/article/comment&article_id=<?php echo $article_id; ?>');

   $('#button-comment').on('click', function() {
     $.ajax({
       url: 'index.php?route=penblog/article/write&article_id=<?php echo $article_id; ?>',
       type: 'post',
       dataType: 'json',
       data: $("#form-comment").serialize(),
       beforeSend: function() {
         $('#button-comment').button('loading');
       },
       complete: function() {
         $('#button-comment').button('reset');
       },
       success: function(json) {
         $('.alert-success, .alert-danger').remove();

         if (json['error']) {
           $('#comment').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
         }

         if (json['success']) {
           $('#comment').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

           $('input[name=\'name\']').val('');
           $('textarea[name=\'text\']').val('');
           $('input[name=\'rating\']:checked').prop('checked', false);
         }
       }
     });
   });

   $(document).ready(function() {
    $('.nav-tabs li a:first').tab('show');
     $('.thumbnails').magnificPopup({
       type:'image',
       delegate: 'a',
       gallery: {
         enabled:true
       }
     });
   });
   //--></script>
<?php echo $footer; ?>

