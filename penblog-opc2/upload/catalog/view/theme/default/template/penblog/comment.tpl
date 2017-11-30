<?php if ($comments) { ?>
<?php foreach ($comments as $comment) { ?>
<table class="table table-striped table-bordered">
  <tr>
    <td style="width: 50%;"><strong><?php echo $comment['author']; ?></strong></td>
    <td class="text-right"><?php echo $comment['date_added']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><p><?php echo $comment['text']; ?></p>
      <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($comment['rating'] < $i) { ?>
      <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
      <?php } else { ?>
      <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
      <?php } ?>
      <?php } ?>
		<a class="btn btn-primary reply" data-toggle="modal" data-target="#reply-<?php echo $comment['comment_id']; ?>">Reply</a>
    </td>
  </tr>
  <?php if($comment['childs']){ ?>
  <?php foreach($comment['childs'] as $child){ ?>
  <tr>
    <td style="width: 50%;"><strong><?php echo $child['author']; ?> was reply <?php echo $comment['author']; ?></strong></td>
    <td class="text-right"><?php echo $child['date_added']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><p><?php echo $child['text']; ?></p>
      <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($child['rating'] < $i) { ?>
      <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } else { ?>
      <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } ?>
      <?php } ?>
    </td>
  </tr>
  <?php } ?>
  <?php } ?>
</table>
<?php require( DIR_TEMPLATE."default/template/penblog/reply.tpl" ); ?>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_comments; ?></p>
<?php } ?>