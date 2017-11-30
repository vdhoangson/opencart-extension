<div id="reply-<?php echo $comment['comment_id']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reply</h4>
      </div>
      <div class="modal-body body-reply<?php echo $comment['comment_id']; ?>">
        <form class="form-horizontal" id="form-reply-<?php echo $comment['comment_id']; ?>">
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
              <div class="col-sm-8">
                <label class="control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                <textarea name="text" rows="5" id="input-comment" class="form-control"></textarea>
                <div class="help-block"><?php echo $text_note; ?></div>
              </div>
              <div class="col-sm-4">
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
                &nbsp;<?php echo $entry_good; ?></div>
            </div>

            <?php echo $captcha; ?>
            <div class="buttons clearfix">
              <div class="pull-right">
                <button type="button" id="button-reply<?php echo $comment['comment_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
              </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</div>
</div>

<script type="text/javascript">
$('#button-reply<?php echo $comment["comment_id"]; ?>').on('click', function() {
	comment_id = <?php echo $comment['comment_id']; ?>;
  $.ajax({
    url: 'index.php?route=penblog/article/reply&article_id=<?php echo $article_id; ?>&comment_id='+comment_id,
    type: 'post',
    dataType: 'json',
    data: $("#form-reply-<?php echo $comment['comment_id']; ?>").serialize(),
    beforeSend: function() {
      $('#button-reply').button('loading');
    },
    complete: function() {
      $('#button-reply').button('reset');
    },
    success: function(json) {
      $('.alert-success, .alert-danger').remove();

      if (json['error']) {
        $('.body-reply'+comment_id).before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
      }

      if (json['success']) {
      	$('.body-reply'+comment_id).empty();
        $('.body-reply'+comment_id).before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
      }
    }
  });
});
</script>