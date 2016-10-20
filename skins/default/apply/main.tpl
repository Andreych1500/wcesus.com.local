<div class="clear-fix apply-user">
  <h2>Welcome to the WCES Online Application</h2>
  <p>Filling the entire application will take you about 15 minutes. You can return to your application at any time within 7 days. After 7 days if no payment is received your application will be deleted. If you complete all the registration requirements, you will receive the access to your personal WCES account where you will have access to additional features.</p>
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
    <li>Apple Safari 2.0 or later
      <a href="//www.apple.com/safari/" title="Download" rel="nofollow" target="_blank">download</a>
    </li>
  </ul>

  <p>Do not use the browser back and forth buttons. To save your data, please fill the appropriate step and then click the Complete button.</p>

  <div class="go-toForm">
    <p class="header-goForm">Start a New Online Application</p>
    <div>
      <p>If you are starting a new online application for the evaluation of your own credential(s), or that/those of a relative/friend, please click the button below.</p>
      <a href="/apply/application-info/?newCard" title="Start Application" class="Start Application">Start Application</a>
    </div>
  </div>

  <div class="go-toForm">
    <p class="header-goForm">Continue an Online Application</p>
    <form action="" method="post" class="go-toForm">
      <p>Are you returning to continue the online application?<br><br>If you are returning to continue your application, please enter your WCES credentials:
      </p>

      <div class="input-value">
        <div class="name-section">Email address:</div>
        <input <?=(isset($check['email'])? $check['email'] : '')?> type="email" name="email" value="<?=(isset($error)? hsc($_POST['email']) : '')?>">
      </div>

      <div class="input-value">
        <div class="name-section">WCES ID Number:</div>
        <input <?=(isset($check['number'])? $check['number'] : '')?> type="text" name="number" value="<?=(isset($error)? hsc($_POST['number']) : '')?>">
      </div>

      <div class="input-value">
        <div class="name-section">Date of birth:</div>
        <input <?=(isset($check['date'])? $check['date'] : '')?> type="text" name="date" value="<?=(isset($error)? hsc($_POST['date']) : '')?>" placeholder="example: mm-dd-yyyy" pattern="\d{2}-\d{2}-\d{4}">
      </div>

      <div class="forgot-data">Forgot?</div>

      <input type="submit" name="ok" value="Return to Application">
    </form>
  </div>
</div>

<div class="confirm_agreement">
  <div class="header-section">Basic Services</div>
  <p>The standard processing time for the World Class Evaluation Services (WCES) evaluations is seven (5) business days from the day that WCES receives the complete application. The application is considered as complete if the fallowing procedures are met: all required documents are obtained in the manner of demand, the application is complete, and the full payment of fees is received.</p>
  <p>Documents requirements for evaluation report are specific for each country. WCES may terminate some countries from eligibility for evaluation reports. Follow the link for documents requirements for the specific country. ALL Documents received by WCES become the property of WCES and will be preserved for 25 (twenty-five) years. ALL documents submitted to WCES will not be released to the applicant or any other institution. WCES reserves the right to revoke any application among the submitted documents.</p>

  <div class="header-section">WCES Procedures and Policies</div>

  <b class="iH3">DOCUMENT VERIFICATION</b>
  <p>WCES verifies documents for authenticity trough the desired Authorities, Institutions, Ministry of Education, and other recognized organizations.</p>

  <b class="iH3">REQUESTS FOR ADDITIONAL DOCUMENTATION AFTER INITIAL REVIEW OF APPLICATION</b>
  <p>In order, to prepare an accurate evaluation report WCES requires all documentation. If the application is incomplete, WCES will request the additional information or documents. The World Class Evaluation Services reserves the right to request original documents to be sent directly from the issuing authority or institution. The complete evaluation report will be prepared after entire application documents are received and verified by WCES.</p>

  <b class="iH3">FORGED/ALTERED DOCUMENTS</b>
  <p>If the documents that had submitted to WCES has been determined as altered, forged or tampered with the application will be canceled; no refunds will be issued, the evaluation report will not be prepared, the documents become the property of the World Class Evaluation Services; ALL recipients indicated on the application, and ALL appropriate authorities included DHS will be notified. No further reports will be issued to that applicant, and any other applications will be disregarded.</p>

  <b class="iH3">DOCUMENTS FROM INSTITUTIONS THAT ARE NOT LEGITIMATE</b>
  <p>If the documents that had submitted to WCES has been determined as obtained from an institution that is not legitimate, the application will be canceled; no refunds will be issued, the evaluation report will not be prepared, the documents become the property of the World Class Evaluation Services; ALL recipients indicated on the application, and ALL appropriate authorities included DHS will be notified. No further reports will be issued to that applicant, and any other applications will be disregarded.</p>

  <b class="iH3">TRANSLATIONS</b>
  <p>ALL documents submitted to WCES must be translated into English. The exceptions are documents that have been originally issued in English, French, German, Polish, Russian, Spanish, or Ukrainian language. Submit clear and legible photocopies of accurate word-for-word and line-by-line translations of all foreign language documents. Translations from ALL certified translations agency are required. You may contact WCES Translation Service or any certified translation service of your choice.</p>

  <b class="iH3">EVALUATION RECOGNITION</b>
  <p>It is applicant's responsibility to check with the institution, licensing board, or agency to which they intend to submit the WCES report to confirm that the WCES evaluation report will be recognized and accepted.</p>

  <b class="iH3">REASSESSMENTS OF EDUCATIONAL EQUIVALENCIES</b>
  <p> Evaluations are based upon the best information and resources currently available to professional evaluators in the U.S. WCES reserves the right to reassess educational equivalencies as additional information becomes available.</p>

  <b class="iH3">ELECTRONIC DELIVERY</b>
  <p>WCES fees apply both to hard copy and to electronic delivery.</p>

  <b class="iH3">FILE CANCELLATIONS</b>
  <p>Completed report considered as a service received. There is no cancellation after the report is issued.</p>

  <b class="agr-status">You agree to the terms?</b>
</div>