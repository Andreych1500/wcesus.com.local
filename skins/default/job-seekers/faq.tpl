<div class="clear-fix">
  <div class="apply-user">
    <div class="header-question">Credential Evaluation Report for Job Seekers</div>
    Being highly educated and have degrees from your country does not guarantee the recognition of the international documents by the U.S. companies and employers. Hence you cannot take full benefit of coming to the US and work here.</div>

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
      <div class="no-question">No questions were found!</div>
    <?php } ?>
  </div>
</div>