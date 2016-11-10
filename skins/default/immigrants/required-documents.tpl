<div class="clear-fix apply-user">
  <h2 class="header-question">Preparation for Sending Documents</h2>
  <ol>
    <li>Complete the WCES Application, upload scanned copies of all your academic references, and get a Reference Number</li>
    <li>WCES is not responsible for documents that arrive without a WCES Reference Number</li>
    <li>All envelopes must include your WCES Reference Number</li>
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
    <div class="no-country">Error: Country was not found!</div>
  <?php } ?>

  <div class="document-block-a hiddenIM"><a href=""></a></div>

  <h2 class="header-question">Language of Documents</h2>
  <ol>
    <li>Please, provide word-for-word English translations of all submitted documents. All English translations should be sealed by your institution or any certified translation service</li>
    <li>Contact WCES Translation Service or any other professional translation service for more information</li>
    <li>Translations must be submitted to WCES with the online Application</li>
    <li>Documents Issued in German, French, Polish, Russian, Spanish, or Ukrainian does not require English translations if Transliterated Full Name is provided</li>
  </ol>
  <h2 class="header-question">Original Document</h2>
  <ol>
    <li>Documents should have an original institutional seal and/or signature</li>
    <li>Documents are usually issued with the letterhead (logo) of the institution</li>
    <li>WCES will not review photocopies or scans</li>
    <li>Uploading scanned copies of all your documents and translations upon submitting your WCES Application will expedite the evaluation process</li>
    <li>All original documents submitted to WCES (with or without an apostille) will be returned to the applicant upon completion of the evaluation</li>
  </ol>
  <h2 class="header-question">Sealed Envelop</h2>
  <ol>
    <li>Document must be an original or an attested copy with an original institutional seal and signature</li>
    <li>The attested copy of documents should be issued and signed/stamped by the same office that issues original documents</li>
    <li>The envelope should be sealed by the issuing body: with a seal, stamp, or signature of an official on the back side flap closure</li>
    <li>The envelop can be mailed to WCES either by the issuing body OR directly by the applicant,&nbsp;<strong>but must remain sealed</strong></li>
    <li>WCES does not return documents issued in a Sealed Envelope</li>
  </ol>
  <h2 class="header-question">Mailing Instructions</h2>
  <ol>
    <li>Please, follow all the document requirements and fill free to contact us for the additional information</li>
    <li>Documents that received incorrectly or not as specified to your country will be rejected and your credential evaluation will be delayed or cancelled</li>
    <li>Include your WCES Reference Number on all envelopes and documents delivered to WCES</li>
  </ol>

  <b class="iH3 mar-top"> By Postal/Courier Mail:</b>

  <p>WCES Reference No._______________<br> World Class Evaluation Services<br> Documentation Center<br> 4535 Schertz Rd. Unit 406<br> San Antonio, TX, 78233<br> USA
  </p><br>
  <p>* This is a courier mail handling facility accepting DHL, FedEx, UPS, etc. Documents should not be hand delivered. This facility is not walk-in accessible.</p>
</div>