<div class="clear-fix bottom-20px">
  <div class="main-free-item">
    <h2>Latest Courses</h2>
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

  <hr class="divider-color">

  <div class="grid-row">
    <div class="left-grid-row">
      <!--      <div class="grid-col grid-col-6">-->
      <!--        <a href="" class="service-icon"><i class="flaticon-pie"></i></a>-->
      <!--        <a href="" class="service-icon"><i class="flaticon-medical"></i></a>-->
      <!--        <a href="" class="service-icon"><i class="flaticon-restaurant"></i></a>-->
      <!--        <a href="" class="service-icon"><i class="flaticon-website"></i></a>-->
      <!--        <a href="" class="service-icon"><i class="flaticon-hotel"></i></a>-->
      <!--        <a href="" class="service-icon"><i class="flaticon-web-programming"></i></a>-->
      <!--        <a href="" class="service-icon"><i class="flaticon-camera"></i></a>-->
      <!--        <a href="" class="service-icon"><i class="flaticon-speech"></i></a>-->
      <!--      </div>-->
    </div>
    <div class="right-grid-row">
      <h2>Our Services</h2>
      <p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at susp. Vivamus orci urna, ornare vitae tellus in, condimentum imperdiet eros. Maecea accumsan, massa nec vulputate congue. Maecenas nec odio et ante tincidunt creptus alarimus tempus.</p>
      <a href="#" title="#">Learn More <i>&gt;</i></a>
    </div>
  </div>
</div>