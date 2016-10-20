<form class="clear-fix bg-net" action="" method="post">
  <div class="header-question">Restore your password</div>

  <p>Please enter the email address you used to access the WCES website. If entered an incorrect email address and you have not proceeded a payment, you will be sent a letter of authorization according to your personal account.</p>

  <div class="input-value">
    <div class="name-section">Email:</div>
    <input <?=(isset($check['email'])? $check['email'] : '')?> type="text" name="email" value="<?=(isset($_POST['email'])? hsc($_POST['email']) : "")?>">
  </div>

  <div class="save-or-continue">
    <input type="submit" name="ok" value="Submit">
  </div>
</form>