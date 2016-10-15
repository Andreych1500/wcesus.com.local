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

  <div class="apply-user">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, ad dicta eius est magnam nesciunt qui quibusdam quisquam, repudiandae sapiente tempore unde! Cupiditate dolore non repudiandae! Adipisci in ipsum ut!
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aspernatur dolorum expedita illo quidem ratione tempore vel. Cum deserunt excepturi, illum ipsam laboriosam magni minima modi nisi sed vero? Aperiam asperiores corporis cum dicta, ducimus ea eius error et facere harum illo impedit iure laborum magnam minima natus nemo obcaecati odit perferendis praesentium, quaerat quo repellat sequi similique soluta unde veniam voluptatum. Aliquid amet commodi consequatur corporis, dolorem error excepturi impedit minus molestias natus nulla qui quisquam saepe sit soluta tempore totam velit voluptas voluptate voluptatibus! Consequatur corporis culpa cum enim eos expedita, fuga inventore ipsum itaque libero, molestiae quae recusandae soluta! Eum, in maxime modi officia ratione similique sit? Accusantium consectetur cupiditate eligendi et laudantium non, odit qui quis quos reiciendis veniam vitae voluptatibus voluptatum. Ab accusantium alias aliquid, consectetur deleniti eos excepturi illum iure iusto molestias, natus numquam quae qui rem similique, totam vel veniam! Aliquid assumenda aut beatae consequatur consequuntur dolore enim eum expedita fugit ipsum molestias nemo odio odit perferendis quam qui, reiciendis, saepe tempore vitae voluptate. Ab ad at doloremque earum, et exercitationem hic in ipsum odio quas ratione, recusandae suscipit tempora? Animi delectus ex exercitationem in ipsa, neque nisi non, porro provident, quia similique voluptates! Debitis dolor odio quaerat quisquam quo reiciendis unde veniam voluptatum! Ab adipisci aut blanditiis consequuntur cumque dolores ea, expedita facilis, fuga illo nisi omnis praesentium quam quas quisquam sequi soluta, ullam veritatis voluptatem.
  </div>
</div>