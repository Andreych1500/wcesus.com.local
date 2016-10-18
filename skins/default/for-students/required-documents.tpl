<div class="clear-fix apply-user">
  <h2 class="header-question">Preparation for Sending Documents</h2>
  <ol>
    <li>Complete the WCES Application, upload scanned copies of all your academic references, and get a Reference Number</li>
    <li>WCES is not responsible for documents that arrive without a WCES reference number</li>
    <li>All envelopes must include your WCES reference number</li>
  </ol>

  <div class="header-question">Sending documents</div>
  <?php if($getEl->num_rows > 0){ ?>
    <select name="country_doc">
      <option value="">Select your Country</option>
      <?php while($country = hsc($getEl->fetch_assoc())){ ?>
        <option value="<?=$country['code']?>"><?=$country['name']?></option>
      <?php } ?>
    </select>
  <?php } else { ?>
    <div class="no-country">Помилка: Жодної країни не знайдено!</div>
  <?php } ?>

  <div class="document-block-a hiddenIM"><a href=""></a></div>

  <h2 class="header-question">Additional Instructions:</h2>
  <ol>
    <li>Please, follow all the document requirements and fill free to request for the additional information. Documents that received incorrectly or not as specified will be rejected and your credential evaluation will be delayed or cancelled</li>
    <li>All original documents submitted to WCES with an apostille will be returned to the applicant upon completion of the evaluation</li>
    <li>Upload scanned copies of all documents upon submitting your application for expedite the evaluation process</li>
    <li>Include your WCES Reference number on all envelopes and documents delivered to WCES</li>
  </ol>

  <b class="iH3 mar-top"> By Postal/Courier Mail:</b>

  <p>WCES Reference No._______________<br> World Class Evaluation Services<br> Documentation Center<br> 4535 Schertz Rd. Unit 406<br> San Antonio, TX, 78233<br> USA
  </p><br>
  <p>* This is a courier mail handling facility accepting DHL, FedEx, UPS, etc. Documents should not be hand delivered. This facility is not walk-in accessible.</p>
</div>