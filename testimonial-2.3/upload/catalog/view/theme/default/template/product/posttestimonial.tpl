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
      <h2><?php echo $text_conditions; ?></h2>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="testimonial">
        <div class="content">
          <table class="table table-bordered">
            <tr>
              <td><?php echo $entry_title ?><br />
                <input type="text" name="title" value="<?php echo $title; ?>" class="form-control" />
                <?php if ($error_title) { ?>
                <span class="error"><?php echo $error_title; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_enquiry ?><span class="required">*</span><br />
                <textarea name="description" class="form-control" rows="10"><?php echo $description; ?></textarea><br />
                <?php if ($error_enquiry) { ?>
                <span class="error"><?php echo $error_enquiry; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_name ?><br />
                <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_city ?><br />
                <input type="text" name="city" value="<?php echo $city; ?>" class="form-control" />
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_email ?><br />
                <input type="text" name="email" value="<?php echo $email; ?>" class="form-control" />
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><br><?php echo $entry_rating; ?> &nbsp;&nbsp;&nbsp; <span><?php echo $entry_bad; ?></span>&nbsp;
                <input type="radio" name="rating" value="1" style="margin: 0;" <?php if ( $rating == 1 ) echo 'checked="checked"';?> />
                &nbsp;
                <input type="radio" name="rating" value="2" style="margin: 0;" <?php if ( $rating == 2 ) echo 'checked="checked"';?> />
                &nbsp;
                <input type="radio" name="rating" value="3" style="margin: 0;" <?php if ( $rating == 3 ) echo 'checked="checked"';?> />
                &nbsp;
                <input type="radio" name="rating" value="4" style="margin: 0;" <?php if ( $rating == 4 ) echo 'checked="checked"';?> />
                &nbsp;
                <input type="radio" name="rating" value="5" style="margin: 0;" <?php if ( $rating == 5 ) echo 'checked="checked"';?> />
                &nbsp; <span><?php echo $entry_good; ?></span><br /><br>
              </td>
            </tr>
            <tr>
              <td><?php echo $captcha; ?></td>
            </tr>
                
          </table>
        </div>
        <div class="buttons">
          <div class="pull-left"><a class="btn btn-default" href="<?php echo $showall_url;?>"><span><?php echo $show_all; ?></span></a></div>
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_send; ?>" class="btn btn-primary" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>