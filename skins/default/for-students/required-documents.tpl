<div class="clear-fix apply-user">
  <?php if($getEl->num_rows > 0){ ?>
    <select name="country_doc">
      <option value="">Select country of education</option>
      <?php while($country = hsc($getEl->fetch_assoc())){ ?>
      <option value="<?=$country['code']?>"><?=$country['name']?></option>
      <?php } ?>
    </select>
  <?php } else { ?>
    <div class="no-country">Жодної країни не знайдено</div>
  <?php } ?>

  <a class="documents hiddenIM" href=""></a>
</div>