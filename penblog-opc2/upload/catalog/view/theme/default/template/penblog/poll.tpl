<!--Poll module start--> 
<div class="widget">
  <div class="clearfix vote-control" id="poll-box<?php echo $id;?>">
    <?php if($poll_data){?>
    <h5 class="block"><?php echo $poll_data['question'];?></h5>
    <?php if(isset($answered)||isset($disabled)){?>
    <?php if(isset($reactions)){?>
    <div class="front-skills">
      <?php for ($i=0;$i < 15; $i++){?>
      <?php if(!empty($poll_data['answer_'.($i + 1)])){?>
      <span>  <?php echo $percent[$i];?>% - <?php echo $poll_data['answer_'.($i + 1)];?>   (<?php echo $vote[$i]?> )</span>
      <div class="progress">
        <div role="progressbar" class="progress-bar" data-percent="<?php echo $percent[$i];?>" style="width:<?php echo $percent[$i];?>%;"></div>
      </div>
      <?php }?>
      <?php }?>
      <div class="buttons">
        <div class="pull-left">
          <?php echo $text_total_votes;?> <strong class="badge"><?php echo $total_votes;?></strong>
        </div>
      </div>
    </div>
    <?php }
      else{?>
    <div class="text-center"><?php echo $text_no_votes;?></div>
    <?php }?>
    <?php }
      else{?>        
    <!--else !isset($answered --> 
    <ul class="list-unstyled" id="vote-poll<?php echo $id;?>">
      <?php for ($i=0;$i < 15; $i++){?>
      <?php if(!empty($poll_data['answer_'.($i + 1)])){?>
      <li>
        <label for="answer<?php echo $i + 1;?>">
        <input type="radio" name="poll_answer" value="<?php echo $i + 1;?>" id="answer<?php echo $i + 1;?>"> <?php echo $poll_data['answer_'.($i + 1)];?>
        </label>
      </li>
      <?php }?>
      <?php }?>
      <input type="hidden" name="poll_id" value="<?php echo $poll_id;?>"/>
    </ul>
    <!--vote-poll --> 
    <div class="buttons">
      <div class="pull-right">
        <a id="button-vote<?php echo $id;?>" class="btn btn-xs btn-primary"><span><?php echo $text_vote;?></span></a>
      </div>
    </div>
    <div style="display:none">
      <script type="text/javascript"><!--
        $('#button-vote<?php echo $id;?>').bind('click', function() {
              $('.alert.alert-warning').remove();
        if($('input[name=\'poll_answer\']').is(':checked')!=false){
          $.ajax({
            url: 'index.php?route=penblog/poll/answer',
            type: 'post',
            dataType: 'json',
              data: $('#vote-poll<?php echo $id;?> input[type=\'text\'], #vote-poll<?php echo $id;?> input[type=\'radio\']:checked, #vote-poll<?php echo $id;?> input[type=\'hidden\']'),
            beforeSend: function() {
              $('#button-vote<?php echo $id;?>').attr('disabled', true);
            },
            complete: function() {
              $('#button-vote<?php echo $id;?>').attr('disabled', false);
            },
            success: function(data) {
              $('#poll-box<?php echo $id;?>').load('index.php?route=penblog/poll/result&poll_id=<?php echo $poll_id;?>');
            }
          });
          }else{
            $('#vote-poll<?php echo $id;?>').after('<div class="alert alert-warning"><?php echo $text_please_select_poll;?></div>');
          }
        });
        //--></script> 
    </div>
    <?php }?>
    <?php }
      else{?>
    <!--else no $poll_data--> 
    <div style="text-align: center;"><?php echo $text_no_poll;?></div>
    <?php }?>
  </div>
  <!--clearfix --> 
</div>
<!--End poll module -->