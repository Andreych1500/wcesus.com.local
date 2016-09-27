<div class="clear-fix apply-user">
  <h2>Welcome to the IERF Online Application</h2>
  <p>Applying online will take approximately 15 minutes to complete. You will be able to save your application and return to it at any time during the process.</p>
  <p>Note: You MUST have one of the following to apply online:</p>
  <ul>
    <li>Microsoft Internet Explorer version 6.0 or later
      <a href="//support.microsoft.com/en-us/en/products/internet-explorer" title="Download" rel="nofollow" target="_blank">download</a>
    </li>
    <li>Mozilla Firefox version 1.5 or later
      <a href="//www.mozilla.org/en-US/firefox/new/" title="Download" rel="nofollow" target="_blank">download</a>
    </li>
    <li>Opera version 9.0 or later
      <a href="//www.opera.com/campaign/gomobile" title="Download" rel="nofollow" target="_blank">download</a>
    </li>
    <li>Apple Safari 2.0 or later <a href="//www.apple.com/safari/" title="Download" rel="nofollow" target="_blank">download</a></li>
  </ul>

  <p>DO NOT use the back or forward arrows on your toolbar as this will result in a loss of the information you entered in the application. Use the PREVIOUS and CONTINUE buttons provided on the bottom of each screen.</p>

  <div class="go-toForm">
    <p class="header-goForm">Start a New Online Application</p>
    <div>
      <p>If you are starting a new online application for the evaluation of your own credential(s), or that/those of a relative/friend, please click the button below.</p>
      <a href="/cab/application-info/?newCard" title="Start Application" class="Start Application">Start Application</a>
    </div>
  </div>

  <div class="go-toForm">
    <p class="header-goForm">Continue an Online Application</p>
    <form action="" method="post" class="go-toForm">
      <p>Are you returning to continue the online application?<br><br>If you are returning to continue your application, please enter your temporary IERF reference number below:
      </p>

      <div class="input-value">
        <div class="name-section">IERF Reference #:</div>
        <input <?=(isset($check['number'])? $check['number'] : '')?> type="text" name="number" value="<?=(isset($error)? hsc($_POST['number']) : '')?>">
      </div>

      <div class="input-value">
        <div class="name-section">Date of Birth:</div>
        <input <?=(isset($check['date'])? $check['date'] : '')?> type="text" name="date" value="<?=(isset($error)? hsc($_POST['date']) : '')?>" placeholder="example: mm-dd-yyyy" pattern="\d{2}-\d{2}-\d{4}">
      </div>

      <div class="forgot-data">Forgotten?</div>

      <input type="submit" name="ok" value="Return to Application">
    </form>
  </div>
</div>

<?php if(isset($info)){ ?>
  <div class="modalWindow">
    <div class="modal-content">
      <span class="icon-error"></span>
      <i>Return to Application</i>
      <?=$info['text']?>
      <div class="close">Close</div>
    </div>
  </div>
<?php } ?>