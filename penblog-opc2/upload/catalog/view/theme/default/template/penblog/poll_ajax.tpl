<div class="clearfix">
  <?php if($poll_data){?>
  <h5><?php echo $poll_data['question'];?></h5>
  <?php if(isset($reactions)){?>
  <div class="front-skills">
    <?php for ($i=0;
      $i < 15;
      $i++){?>
    <?php if(!empty($poll_data['answer_'.($i + 1)])){?>
    <p>  <?php echo $percent[$i];?>% - <?php echo $poll_data['answer_'.($i + 1)];?>   (<?php echo $vote[$i]?> )</p>
    <div class="progress">
      <div role="progressbar" class="progress-bar <?php echo $poll_data['color'];?>-bg" data-percent="<?php echo $percent[$i];?>" style="width: <?php echo $percent[$i];?>%;"></div>
    </div>
    <?php }?>
    <?php }?>
    <div class="clearfix">
      <?php echo $text_total_votes;?> <?php echo $total_votes;?>
    </div>
    <?php if($total_votes>0){?> 
    <div class="buttons">
      <div class="pull-right">
        <a href="<?php echo $poll_results;?>"  class="modalbox btn btn-xs btn-primary" data-type="html" data-title="<?php echo $poll_data['question'];?>"><?php echo $text_poll_results;?></a>
      </div>
    </div>
    <?php }?>
  </div>
  <?php }
    else{?>
  <div style="text-align: center;"><?php echo $text_no_votes;?></div>
  <?php }?>
  <?php }?>
</div>