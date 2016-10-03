<?php
class class_PayPal {
    var $last_error = '';
    var $ipn_response = '';
    var $ipn_log_file;
    var $ipn_log = true;     // Включити/виключити запис в лог файл
    var $ipn_data = array(); // Массив з даними від PayPal про оплату
    var $fields = array();   // Массив з значеннями полів PayPal

    function class_PayPal(){ // Параметри по замовченню, у подальому можуть перезаписуватись.
        $this->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $this->ipn_log_file = $_SERVER['DOCUMENT_ROOT'].'/modules/apply/ipn_results.log';

        $this->add_field('rm', '2');         // Результат у вигляді (0,1 -> GET, 2 -> POST)
        $this->add_field('cmd', '_xclick');  // Кнопка оплати при кліку (оплатити зараз)
    }

    function add_field($field, $value){
        $this->fields[$field] = $value; // Параметри PayPal у вигляді array(key => value)
    }

    function submit_paypal_post(){
        //   ця функція фактично генерує весь HTML-сторінку, що складається з форми з прихованими елементами, який передається через PayPal атрибута OnLoad елемента тіла. Таким чином, в принципі, ви будете мати свою власну форму, представленої для вашого сценарію для перевірки даних, які, в свою чергу, викликає цю функцію, щоб створити ще одну приховану форму і представити PayPal.
        //  Користувач буде на короткий час з'явиться повідомлення на екрані, де говориться: "Будь ласка, зачекайте, ваше замовлення обробляється ...", а потім відразу перенаправляється на PayPal.

        echo "<html>\n";
        echo "<head><title>Processing Payment...</title></head>\n";
        echo "<body onLoad=\"document.forms['paypal_form'].submit();\">\n";
        echo "<form method=\"post\" name=\"paypal_form\" ";
        echo "action=\"".$this->paypal_url."\">\n";

        foreach($this->fields as $name => $value){
            echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
        }

        echo "</form>\n";
        echo "</body></html>\n";
    }

    function validate_ipn(){
        $postData = "";
        foreach($_POST as $field => $value){
            $this->ipn_data[$field] = $value;
            $postData .= $field."=".urlencode($value)."&";
        }
        $postData .= "cmd=_notify-validate";

        $curl = curl_init($this->paypal_url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $this->ipn_response = curl_exec($curl);
        curl_close($curl);

        if($this->ipn_response == 'VERIFIED'){
            $this->log_ipn_results(true);

            return true;
        } else {
            $this->last_error = 'Invalid IPN transaction.';
            $this->log_ipn_results(false);

            return false;
        }
    }

    function log_ipn_results($success){
        if(!$this->ipn_log){
            return;
        }

        // Timestamp and SUCCESS
        $text = '['.date('m/d/Y H:i:s A').'] - '.($success? "SUCCESS!\n" : 'FAIL: '.$this->last_error."\n");

        // Log the Get variable
        $text .= "IPN GET Vars from Paypal:\n";
        foreach($_GET as $key => $value){
            $text .= $key."=".$value."\n";
        }

        // Log the POST variables
        $text .= "IPN POST Vars from Paypal:\n";
        foreach($this->ipn_data as $key => $value){
            $text .= $key."=".$value."\n";
        }

        // Log the response from the paypal server
        $text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;

        // Write to log
        $fp = fopen($this->ipn_log_file, 'a');
        fwrite($fp, $text."\n\n");
        fclose($fp);  // close file
    }

    function dump_fields(){
        echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
            <tr>
               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
            </tr>";

        ksort($this->fields);
        foreach($this->fields as $key => $value){
            echo "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>";
        }

        echo "</table><br>";
    }
}



