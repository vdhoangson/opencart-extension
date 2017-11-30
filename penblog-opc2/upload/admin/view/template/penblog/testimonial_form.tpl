<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-testimonial" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      <?php echo $shortcut; ?>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
        
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-testimonial" class="form-horizontal">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_avatar; ?></label>
                <div class="col-sm-9">
                  <a href="" id="thumb-avatar" data-toggle="image" class="img-thumbnail">
                  <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="avatar" value="<?php echo $avatar;?>" id="input-avatar"/>
                </div>
              </div>
              <!-- //form-group--> 
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_customer_name; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="form-control"/>
                  <?php if ($error_customer_name) { ?>
                  <span class="text-danger"><?php echo $error_customer_name; ?></span>
                  <?php } ?>
                </div>
              </div>
              <!-- //form-group--> 
              <div class="form-group">
                <label class="col-sm-3"> <?php echo $entry_customer_telephone; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="customer_telephone" value="<?php echo $customer_telephone; ?>" class="form-control"/>
                  <?php if ($error_customer_telephone) { ?>
                  <span class="text-danger"><?php echo $error_customer_telephone; ?></span>
                  <?php } ?>
                </div>
              </div>
              <!-- //form-group--> 
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_customer_email; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="customer_email" value="<?php echo $customer_email; ?>" class="form-control"/>
                  <?php if ($error_customer_email) { ?>
                  <span class="text-danger"><?php echo $error_customer_email; ?></span>
                  <?php } ?>
                </div>
              </div>
              <!-- //form-group-->
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_competence; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="competence" value="<?php echo $competence; ?>" class="form-control"/>
                </div>
              </div>
              <!-- //form-group-->
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_company; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="customer_company" value="<?php echo $customer_company; ?>" class="form-control"/>
                </div>
              </div>
              <!-- //form-group-->
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_store; ?></label>
                <div class="col-sm-9">
                  <select name="store_id" class="form-control">
                    <option value="0"><?php echo $text_default; ?></option>
                    <?php foreach ($stores as $store) { ?>
                    <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <!-- //form-group-->
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_status; ?></label>
                <div class="col-sm-9">
                  <select name="status" class="form-control">
                    <option value="1" <?php if ($status==1) { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                    <option value="0"<?php if ($status==0) { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                  </select>
                </div>
              </div>
              <!-- //form-group-->
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_read; ?></label>
                <div class="col-sm-9">
                  <?php if ($read == 0) { ?>
                  <input type="radio" name="read" value="0" checked /><?php echo $text_unread;?>
                  <?php } else { ?>
                  <input type="radio" name="read" value="0" /><?php echo $text_unread;?>
                  <?php } ?>&nbsp;
                  <?php if ($read == 1) { ?>
                  <input type="radio" name="read" value="1" checked /> <?php echo $text_read;?> 
                  <?php } else { ?>
                  <input type="radio" name="read" value="1" /><?php echo $text_read;?>
                  <?php } ?>
                </div>
              </div>
              <!-- //form-group-->
            </div>
            <!--//col -->
            <div class="col-sm-6">
              <!-- //form-group-->
              <div class="form-group">
                <label class="col-sm-3"><?php echo $entry_rating; ?></label>
                <div class="col-sm-9">
                  <b class="rating"><?php echo $entry_bad; ?></b>&nbsp;
                  <input type="radio" name="rating" value="1" <?php if ($rating == 1) { ?> checked  <?php } ?>/>            
                  &nbsp;
                  <input type="radio" name="rating" value="2" <?php if ($rating == 2) { ?> checked  <?php } ?>/>
                  &nbsp;
                  <input type="radio" name="rating" value="3"  <?php if ($rating == 3) { ?> checked  <?php } ?> />             
                  &nbsp;
                  <input type="radio" name="rating" value="4"  <?php if ($rating == 4) { ?> checked  <?php } ?> />
                  &nbsp;
                  <input type="radio" name="rating" value="5"  <?php if ($rating == 5) { ?> checked  <?php } ?> />    
                  &nbsp; <b class="rating"><?php echo $entry_good; ?></b>
                  <?php if ($error_rating) { ?>
                  <span class="text-danger"><?php echo $error_rating; ?></span>
                  <?php } ?>
                </div>
              </div>
              <!-- //form-group-->
              <div class="form-group">
                <label class="col-sm-3"><?php echo $text_h2_request; ?></label>
                <div class="col-sm-9">
                  <textarea name="message" style="width:100%; height:200px; resize:none;" rows="10" class="form-control"><?php echo $message; ?></textarea>
                  <?php if ($error_message) { ?><br> 
                  <span class="text-danger"><?php echo $error_message; ?></span>
                  <?php } ?>
                </div>
              </div>
              <!-- //form-group-->
            </div>
            <!--//col --> 
          </div>
          <!--//row --> 
        </form>
      </div>
      <div class="panel-footer">Pen Blog &copy; 2016 - <a href="http://pencms.com" target="_blank">pencms.com</a></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>