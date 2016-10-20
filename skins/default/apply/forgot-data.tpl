<form class="clear-fix bg-net" action="/apply/forgot-data/" method="post">
  <div class="header-question">Restoring access to card</div>

  <div class="apply-user">Please enter the e-mail, which you used to access the site. If you would be incorrect email address, you will be sent a letter of authorization data in your profile.</div>

  <div class="input-value">
    <div class="name-section">Email:</div>
    <input <?=(isset($check['email'])? $check['email'] : '')?> type="text" name="email" value="<?=(isset($_POST['email'])? hsc($_POST['email']) : "")?>">
  </div>

  <div class="save-or-continue">
    <input type="submit" name="ok" value="Submit">
  </div>
</form>