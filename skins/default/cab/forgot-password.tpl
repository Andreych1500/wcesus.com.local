<form class="clear-fix bg-net" action="" method="post">
  <div class="header-question">Відновлення вашого пароля</div>

 <p>Будь ласка, введіть адресу електронної пошти, який ви використовували для доступу до сайту. Якщо неправильний адресу електронної пошти та вами не було проведено жодної оплати на сайті, Вам не буде надіслано листа з даними авторизації до вашому особистого кабінету.</p>

  <div class="input-value">
    <div class="name-section">Email:</div>
    <input <?=(isset($check['email'])? $check['email'] : '')?> type="text" name="email" value="<?=(isset($_POST['email'])? hsc($_POST['email']) : "")?>">
  </div>

  <div class="save-or-continue">
    <input type="submit" name="ok" value="Submit">
  </div>
</form>