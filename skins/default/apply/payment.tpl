<form class="clear-fix bg-net" action="/apply/payment/" method="post">
  <div class="steps">
    <?php for($i = 1; $i <= 7; ++$i){ ?>
      <div <?=($i == 7? 'class="active"' : '')?>>Step <?=$i?></div>
    <?php } ?>
  </div>

  <div class="header-question">Payment</div>

  <div class="input-value">
    <div class="name-section">Amount Due: <?=$price.'.00'?></div>
    <input type="hidden" name="price" value="<?=$price.'.00'?>">
  </div>

  <div class="save-or-continue">
    <a href="/apply/review/" class="back_link">< Back</a> <input <?=(isset($_POST['ok'])? 'id="payment"' : '')?> type="submit" name="ok" value="Payment">
  </div>
</form>