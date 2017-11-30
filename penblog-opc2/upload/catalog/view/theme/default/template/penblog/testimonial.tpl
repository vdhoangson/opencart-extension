<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>

      <form action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data" id="form-testimonial" class="form-horizontal">
          <div class="row clearfix">
            <div class="col-md-6">
              <h4 class="upper"><?php echo $text_information; ?></h4>
              <fieldset>
                <div class="form-group">
                  <label class="col-lg-4 control-label"><?php echo $entry_name; ?> <span class="require">*</span></label>
                  <div class="col-lg-8">
                    <input type="text" name="name" value="<?php echo $name; ?>" class="form-control"/>
                    <?php if ($error_name) { ?>
                    <span class="text-danger"><?php echo $error_name; ?></span>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label"><?php echo $entry_email; ?> <span class="require">*</span></label>
                  <div class="col-lg-8">
                    <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"/>
                    <?php if ($error_email) { ?>
                    <span class="text-danger"><?php echo $error_email; ?></span>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label"><?php echo $entry_telephone; ?></label>
                  <div class="col-lg-8">
                    <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="form-control"/>
                    <?php if ($error_telephone) { ?>
                    <span class="text-danger"><?php echo $error_telephone; ?></span>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label"><?php echo $entry_company; ?></label>
                  <div class="col-lg-8">
                    <input type="text" name="company" value="<?php echo $company; ?>" class="form-control"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label"><?php echo $entry_competence; ?></label>
                  <div class="col-lg-8">
                    <input type="text" name="competence" value="<?php echo $competence; ?>" class="form-control"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 control-label"><?php echo $text_avatar;?><span class="fa fa-info-circle tooltip_help" data-toggle="tooltip" title="<?php echo $help_avatar;?>"></span></label>
                  <div class="col-lg-8 text-center">
                    <div class="image"><img class="avatar" src="<?php echo $thumb; ?>" alt="" id="thumb"/><br />
                      <input type="hidden" name="avatar" value="<?php echo $avatar; ?>" id="avatar"/>
                      <a id="upload_image"><i class="fa fa-cloud-upload"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#avatar').attr('value', '');"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="col-md-6">
              <h4 class="upper"><?php echo $text_enquiry; ?></h4>
              <fieldset>               
                <textarea class="form-control" name="message" style="height:230px;" id="message"><?php echo $message; ?></textarea>
                <?php if ($error_message) { ?>
                <span class="text-danger"><?php echo $error_message; ?></span>
                <?php } ?>
              </fieldset>
            </div>
            <!--col --> 
          </div>
          <!--row --> 
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-lg-3 control-label"><?php echo $entry_rating; ?> </label>
                <div class="col-lg-9 radio-list">
                  <b><?php echo $text_bad; ?></b>&nbsp;             
                  <input type="radio" name="rating" value="1" <?php if ($rating == 1) { ?> checked  <?php } ?>/>            
                  &nbsp;
                  <input type="radio" name="rating" value="2" <?php if ($rating == 2) { ?> checked  <?php } ?>/>
                  &nbsp;
                  <input type="radio" name="rating" value="3"  <?php if ($rating == 3) { ?> checked  <?php } ?> />             
                  &nbsp;
                  <input type="radio" name="rating" value="4"  <?php if ($rating == 4) { ?> checked  <?php } ?> />
                  &nbsp;
                  <input type="radio" name="rating" value="5"  <?php if ($rating == 5) { ?> checked  <?php } ?> />             
                  &nbsp; <b><?php echo $text_good; ?></b>
                  <?php if ($error_rating) { ?><br> 
                  <span class="text-danger"><?php echo $error_rating; ?></span>
                  <?php } ?>
                </div>
              </div>
              <!--form-group --> 
            </div>
            <!--col -->      
            <div class="col-md-6">
              <?php echo $captcha; ?>
              
            </div>
            <!--col -->      
          </div>
          <!--row --> 
          <div class="buttons">
            <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> <?php echo $button_back; ?></a></div>
            <div class="pull-right">    
              <button type="submit" class="btn btn-primary"><?php echo $text_send; ?> <i class="fa fa-arrow-right"></i></button>
            </div>
          </div>
        </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
<script type="text/javascript">
  $('#upload_image').on('click', function() {
  var node = this;

  $('#form-upload').remove();

  $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

  $('#form-upload input[name=\'file\']').trigger('click');

  if (typeof timer != 'undefined') {
      clearInterval(timer);
  }

  timer = setInterval(function() {
    if ($('#form-upload input[name=\'file\']').val() != '') {
      clearInterval(timer);

      $.ajax({
        url: 'index.php?route=penblog/testimonial/image',
        type: 'post',
        dataType: 'json',
        data: new FormData($('#form-upload')[0]),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $(node).button('loading');
        },
        complete: function() {
          $(node).button('reset');
        },
        success: function(json) {
          $('.text-danger').remove();

          if (json['error']) {
           alert(json['error']);
          }

          if (json['success']) {
            alert(json['success']);
            $('#avatar').attr('value', json['filename']);
            $('#thumb').attr('src', json['thumb']);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }
  }, 500);
});
</script> 
</div>

<style type="text/css">
  .image img.avatar {
        width: 75px;
        height: 75px;
        border-radius: 100px;
    }
</style>
<?php echo $footer; ?>
