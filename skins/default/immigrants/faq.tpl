<div class="clear-fix">
  <div class="apply-user">
    <div class="header-question">bla bla bla</div>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, ad dicta eius est magnam nesciunt qui quibusdam quisquam, repudiandae sapiente tempore unde! Cupiditate dolore non repudiandae! Adipisci in ipsum ut! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aspernatur dolorum expedita illo quidem ratione tempore vel. Cum deserunt excepturi, illum ipsam laboriosam magni minima modi nisi sed vero? Aperiam asperiores corporis cum dicta, ducimus ea eius error et facere harum illo impedit iure laborum magnam minima natus nemo obcaecati odit perferendis praesentium, quaerat quo repellat sequi similique soluta unde veniam voluptatum. Aliquid amet commodi consequatur corporis, dolorem error excepturi impedit minus molestias natus nulla qui quisquam saepe sit soluta tempore totam velit voluptas voluptate voluptatibus! Consequatur corporis
  </div>

  <div class="faq-items">
    <?php if(count($faq) > 0){ ?>

      <?php foreach($faq as $k => $v){ ?>
        <div class="item">
          <span class="x-icon-question">?</span>
          <p class="question-text"><?=$v['question']?></p>
          <div class="answer"><?=$v['answer']?></div>
        </div>
      <?php } ?>

    <?php } else { ?>
      <div class="no-question">Жодного запитання не було знайдено.</div>
    <?php } ?>
  </div>
</div>