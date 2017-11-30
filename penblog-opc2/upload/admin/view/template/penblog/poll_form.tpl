<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <div class="pull-right">
      <button type="submit" form="form-comment" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
      <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
    <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form-poll" name="form-poll" class="form-horizontal">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
        <li><a href="#tab_results" data-toggle="tab"><?php echo $tab_results; ?></a></li>
        <li><a href="#tab_data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
      </ul>
      <div class="tab-content">
        <div id="tab_general" class="tab-pane active">
          <input type="hidden" name="color" data-selected="<?php echo $color;?>" class="form-control with-nav"/>
          <ul class="nav nav-tabs" id="language">
            <?php foreach($languages as $language){?>
            <li><a href="#language<?php echo $language['language_id'];?>" data-toggle="tab"><img src="<?php echo $language['code']; ?>" title="<?php echo $language['name'];?>"/> <?php echo $language['name'];?></a></li>
            <?php }?>
          </ul>
          <div class="tab-content">
            <?php foreach($languages as $language){?>
            <div id="language<?php echo $language['language_id'];?>" class="tab-pane fade">
              <table class="table table-bordered table-hover">
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_question;?></td>
                  <td><input name="poll_description[<?php echo $language['language_id'];?>][question]" value="<?php echo isset($poll_description[$language['language_id']]) ? $poll_description[$language['language_id']]['question'] : '';?>" class="form-control"/>
                    <?php if(isset($error_question[$language['language_id']])){?>
                    <span class="text-danger"><?php echo $error_question[$language['language_id']];?></span>
                    <?php }?>
                  </td>
                </tr>
                <?php for($i = 1;
                  $i <= 10;
                  $i++){?>
                <tr>
                  <td><?php echo $entry_answer.'&nbsp;'.$i;?></td>
                  <td><input name="poll_description[<?php echo $language['language_id'];?>][answer_<?php echo $i;?>]" value="<?php echo isset($poll_description[$language['language_id']]) ? $poll_description[$language['language_id']]['answer_'.$i] : '';?>" class="form-control"/>
                    <?php if(isset($errors_answer[$i][$language['language_id']])){?>
                    <span class="text-danger"><?php echo $errors_answer[$i][$language['language_id']];?></span>
                    <?php }?>
                  </td>
                </tr>
                <?php }?>
              </table>
            </div>
            <!-- //tab-pane--> 
            <?php }?>
          </div>
          <!-- /tab-content--> 
        </div>
        <div id="tab_results" class="tab-pane fade">
          <?php if(isset($reactions)){?>
          <?php $labels=array();
            $values=array();?>
          <h2><?php echo $text_poll_results;?></h2>
          <h3><?php echo $poll_data['question'];?></h3>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td width="10%"><?php echo $text_percent;?></td>
                  <td><?php echo $text_answer;?></td>
                </tr>
              </thead>
              <tbody>
                <?php $class='odd';?>
                <?php for($i = 0;
                  $i < 15;
                  $i++){?>
                <?php if(!empty($poll_data['answer_' . ($i + 1)])){?>
                <?php $class =$class=='even' ? 'odd' : 'even';?>
                <?php array_push($labels,$poll_data['answer_' . ($i + 1)]);?>
                <?php array_push($values,$percent[$i]);?>
                <tr class="<?php echo $class;?>">
                  <td><strong><?php echo $percent[$i];?>%</strong></td>
                  <td><?php echo $poll_data['answer_' . ($i + 1)];?>  (<?php echo $vote[$i]?> )</td>
                </tr>
                <?php }?>
                <?php }?>
              </tbody>
            </table>
            <div style="text-align: center; margin-top: 10px;">
              <?php $labels = implode('|',$labels);
                $values = implode(',',$values);?>
              <img src="http://chart.apis.google.com/chart?cht=p3&chco=303F4A,E4EEF7,849721&chd=t:<?php echo $values;?>&chs=770x200&chl=<?php echo $labels;?>" width="770" height="200" alt="chart" />
            </div>
            <?php } else { ?>
            <div style="text-align: center; margin-top: 10px;"><?php echo $text_no_votes;?></div>
            <?php }?>
        </div>
        <div id="tab_data" class="tab-pane fade">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <tr>
                <td><?php echo $entry_store;?></td>
                <td>
                  <div class="well well-sm">
                    <?php $class='even';?>
                    <div class="<?php echo $class;?>">
                      <?php if(in_array(0,$poll_store)){?>
                      <input type="checkbox" name="poll_store[]" value="0" checked="checked"/>
                      <?php echo $text_default;?>
                      <?php }else{?>
                      <input type="checkbox" name="poll_store[]" value="0" checked="checked"/>
                      <?php echo $text_default;?>
                      <?php }?>
                    </div>
                    <?php foreach($stores as $store){?>
                    <?php $class = ($class=='even' ? 'odd' : 'even');?>
                    <div class="<?php echo $class;?>">
                      <?php if(in_array($store['store_id'],$poll_store)){?>
                      <input type="checkbox" name="poll_store[]" value="<?php echo $store['store_id'];?>" checked="checked"/>
                      <?php echo $store['name'];?>
                      <?php }else{?>
                      <input type="checkbox" name="poll_store[]" value="<?php echo $store['store_id'];?>" checked="checked"/>
                      <?php echo $store['name'];?>
                      <?php }?>
                    </div>
                    <?php }?>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <!-- //tab-content--> 
    </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
  $('#language a:first').tab('show');
  //--></script>
<?php echo $footer; ?>