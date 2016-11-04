<div class="clear-fix">
  <div class="apply-user">
    <div class="header-question">Credential Evaluation Report for students.</div>
    Being highly educated and have degrees from your country does not guarantee the recognition of the international documents here in the United States institutions. Hence you cannot take full benefit of coming to the US and study or work here.
  </div>

  <div class="faq-items">
    <?php if(count($faq) > 0){ ?>

      <?php foreach($faq as $k => $v){ ?>
        <div class="item">
          <span class="x-icon-question">?</span>
          <p class="question-text"><?=$v['question']?></p>
          <div class="answer"><?=nl2br($v['answer'])?></div>
        </div>
      <?php } ?>

    <?php } else { ?>
      <div class="no-question">No questions were found!</div>
    <?php } ?>
  </div>
</div>