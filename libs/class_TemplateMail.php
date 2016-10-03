<?php
class TemplateMail {
  static function HtmlMail($param_content, $symbol_code, $arMainParam, $no_act = 1){

    $arSetting = hsc(q("
        SELECT * 
        FROM `admin_setting_mails`
        WHERE `id` = 1
    ")->fetch_assoc());

    if($no_act == 1){
      $no_text_act = 'AND `active` = 1';
    } else {
      $no_text_act = '';
    }

    $arNumType = q("
        SELECT * 
        FROM `admin_type_mails`
        WHERE `symbol_code` = '".$symbol_code."' ".$no_text_act."
        LIMIT 1
    ");

    if($arNumType->num_rows > 0 && !arrOneEmpty($arSetting)){

      $arType = hsc($arNumType->fetch_assoc());

      preg_match_all("#.{2}$#uis", $arType['symbol_code'], $matches);
      if(in_array($matches[0], Core::$SITE_LANG)){
        if($matches[0] == Core::$SITE_LANG[0]){
          $langUrl = '';
        } else {
          $langUrl = $matches[0].'/';
        }
      } else {
        $langUrl = '';
      }

      $arSet = array(
        'background'   => $arMainParam['url_http_site'].'/skins/default/img/mails/pattern.png',
        'logoImage'    => $arMainParam['url_http_site'].'/skins/default/img/mails/logo.png',
        'theme'        => $arType['theme_list'],
        'header'       => $arType['header_list'],
        'text'         => $arType['text'],
        'why'          => $arType['why_list'],
        'wwwSite'      => 'www.'.$arMainParam['url_site'],
        'phone'        => $arSetting['phone'],
        'email_footer' => $arSetting['email_footer'],
        'urlToSite'    => $arMainParam['url_http_site'].'/'.$langUrl,
      );

      Mail::$subject = $arSet['theme']; // Headers from list !!!
      Mail::$from = $arMainParam['from_email'];
      Mail::$hidden_copy = $arType['hidden_copy'];

      if(is_array($param_content) && !empty($param_content)){
        foreach($param_content as $k => $v){
          if(is_array($v)){
            continue;
          }

          $arType['text'] = preg_replace("~#".$k."#~uis", $v, $arType['text']);
        }
      }

      ob_start();
      ?>
      <!DOCTYPE html>
      <html>
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$arSet['theme']?></title>
      </head>
      <body style="background: url(<?=$arSet['background']?>) #fb7d66; line-height:1.5; color:#482200; padding:30px 20px; font-size:17px;">
      <style>
        @media screen and (min-width: 480px) {

        }
      </style>
      <div role="header" style="text-align: center; border: 1px dashed #cccccc; background:#ffffff; padding:10px; margin: auto; max-width: 538px;">
        <a href="<?=$arSet['urlToSite']?>" target="_blank" title="<?=$arSet['wwwSite']?>" style="outline:none; display:inline-block;">
          <img src="<?=$arSet['logoImage']?>" style="width:100%"> </a>
        <p style="font-size: 26px; margin:0; font-weight:bold;"><?=$arSet['header']?></p>
        <div style="clear:both;"></div>
      </div>
      <div role="main" style="border-left: 1px dashed #cccccc; border-right: 1px dashed #cccccc; background:#ffffff; font-family: sans-serif; padding: 10px; margin: auto; max-width: 538px;">
        <?=htmlspecialchars_decode($arType['text'])?>
        <div style="clear:both;"></div>
      </div>
      <div role="footer" style="background:#ffffff; padding: 10px; color: #BFBFBF; text-align: center; border: 1px dashed #cccccc; margin: auto; max-width: 538px;">
        <p style="margin:0 0 10px; font-size: 18px;">E-mail:
          <a href="mailto:<?=$arSet['email_footer']?>" style="color:#8B8B8B !important; font-weight:bold; text-decoration:none;"><?=$arSet['email_footer']?></a> | Phone:
          <a href="callto:<?=calltoPhone($arSet['phone'])?>" style="color:#8B8B8B !important; font-weight:bold; text-decoration:none;"><?=calltoPhone($arSet['phone'])?></a>
        </p>
        <div style="font-size:0; margin:0 0 10px;"></div>
        <p style="font-size:14px;"><?=$arSet['why']?>
          <a href="<?=$arSet['urlToSite']?>" target="_blank" style="color: #cccccc; display: inherit;"><?=$arSet['wwwSite']?></a>
        </p>
        <p>&copy; <?=data($arMainParam['site_data_create'])?></p>
      </div>
      </body>
      </html>
      <?php
      $html = ob_get_contents();
      ob_get_clean();

      return $html;
    } else {
      Mail::$subject = 'Error www'.$arMainParam['url_site'];
      Mail::$from = $arMainParam['from_email'];
      Mail::$text = 'Сталася помилка при відправці листа, код: :'.$symbol_code;
      Mail::$to = $arSetting['test_email'];
      Mail::send();

      return false;
    }
  }
}