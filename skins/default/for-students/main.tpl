<div class="clear-fix">
  <div class="main-free-item">
    <h2> Latest Courses </h2>
    <?php foreach($arBlock as $k => $v){ ?>
      <div class="course-item">
        <div class="course-hover">
          <img src="<?=$v['img']?>" alt="<?=$v['name']?>" title="<?=$v['name']?>">
          <div class="hover-bg"></div>
          <a href="<?=$v['learn_Link']?>">Learn More</a>
        </div>

        <div class="course-name">
          <span class="price"><?=$v['price']?></span>
          <div><a href="<?=$v['link_T_link']?>"><?=$v['text_link']?></a></div>
        </div>

        <div class="course-date">
          <div class="day"><i class="icon-calendar"></i><?=$v['date']?></div>
          <div class="time"><i class="icon-clock"></i><?=$v['time']?></div>
          <div class="divider"></div>
          <div class="description"><?=$v['description']?></div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>