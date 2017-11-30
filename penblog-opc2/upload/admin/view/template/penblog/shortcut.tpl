<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#penblog_nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="http://pencms.com" target="_blank" class="navbar-brand">PenBlog</a>
    </div>

    <div class="collapse navbar-collapse" id="penblog_nav">
      <ul class="nav navbar-nav">
        <?php foreach($shortcuts as $shortcut){ ?>
          <?php if(!$shortcut['childs']){ ?>
          <li class="<?php echo $shortcut['route']==$route?'active':''; ?>"><a href="<?php echo $shortcut['href']; ?>"><i class="<?php echo $shortcut['icon']; ?>"></i> <?php echo $shortcut['text']; ?></a></li>
          <?php } else { ?>
          <li class="dropdown <?php echo $shortcut['route']==$route?'active':''; ?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="<?php echo $shortcut['icon']; ?>"></i> <?php echo $shortcut['text']; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <?php foreach($shortcut['childs'] as $child){ ?>
              <li><a href="<?php echo $child['href']; ?>"><i class="<?php echo $child['icon']; ?>"></i> <?php echo $child['text']; ?></a></li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>
        <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>