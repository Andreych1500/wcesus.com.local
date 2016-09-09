<?php
class Pagination {
  static $error = '';
  static $pagination = array();

  static function formNav($arParam){
    $issetTab = q("
        SHOW TABLES FROM `".Core::$DB_NAME."` 
        LIKE '".mres($arParam['db_table'])."'
    ");

    if(!$issetTab->num_rows){
      self::$error .= 'Error: no param table '.$arParam['db_table'].'; ';
    }

    $getPage = (($_GET['page'] == 'main')? '\/' : '\/'.$_GET['page'].'\/');

    if(!preg_match("#\/".$_GET['module'].$getPage."#uisU", $arParam['url'])){
      self::$error .= 'Error: no param url '.$arParam['url'].'; ';
    }

    if(empty($arParam['css_class'])){
      self::$error .= 'Error: no css class; ';
    }

    if(!mb_strlen(self::$error)){
      $active = $arParam['numPage']; // номер активної сторінки
      $count_show = $arParam['count_show']; // кількість порядкових сторінок які виводяться у пагінаії
      $url = $arParam['url']; // url сторінки від корня

      /* Кількість усіх записів */
      $all_element = q("
          SELECT `id`
          FROM `".$arParam['db_table']."`
          ".$arParam['filter']."
      ")->num_rows;

      $count_pages = ceil($all_element / $arParam['records_el']);

      if($count_pages > 1){
        $left = $active - 1;
        $right = $count_pages - $active;

        if($left < floor($count_show / 2)){
          $start = 1;
        } else {
          $start = $active - floor($count_show / 2);
        }

        $end = $start + $count_show - 1;

        if($end > $count_pages){
          $start -= ($end - $count_pages);
          $end = $count_pages;
          if($start < 1){
            $start = 1;
          }
        }

        if($arParam['numPage'] > $count_pages || $arParam['numPage'] <= 0){
          if($arParam['notFound404'] == 'Y'){
            header("HTTP/1.0 404 Not Found");
            echo bufferStartError404($arParam['lang'], $arParam['link_lang']);
            exit();
          } else {
            header('Location: '.$arParam['url']);
            exit();
          }
        }

        if($arParam['seo'] == 'Y'){
          /*
           * this seo Prev or Next
           * */
        }

        ob_start(); ?>
        <div class="<?=$arParam['css_class']?>">
          <?php if($active != 1){ ?>
            <a href="<?=(($active == 2)? $url : $url.'?numPage='.($active - 1))?>">&lt;</a>
          <?php } ?>

          <?php for($i = $start; $i <= $end; $i++){
            if($i == $active){ ?>
              <span class="act-nav"><?=$i?></span>
            <?php } else { ?>
              <a href="<?=(($i == 1)? $url : $url.'?numPage='.$i)?>"><?=$i?></a>
            <?php }
          } ?>

          <?php if($active != $count_pages){ ?>
            <a href="<?=$url.'?numPage='.($active + 1)?>">&gt;</a>
          <?php } ?>
        </div>
        <?
        self::$pagination['pagination'] = ob_get_contents();
        ob_get_clean();

        $start_el = ($arParam['numPage'] - 1) * (int)$arParam['records_el'];

        self::$pagination['result_DB'] = q("
            SELECT *
            FROM `".$arParam['db_table']."`
            ".$arParam['filter']."
            ORDER BY ".$arParam['sort']." `id` DESC
            LIMIT ".$start_el.", ".(int)$arParam['records_el']."
        ");

        return self::$pagination;
      } else {
        if(isset($_GET['numPage'])){
          header('Location: '.$arParam['url']);
          exit();
        } else {
          self::$pagination['result_DB'] = q("SELECT * FROM `".$arParam['db_table']."` ".$arParam['filter']." ORDER BY ".$arParam['sort']." `id` DESC ");
          self::$pagination['pagination'] = '<div class="'.$arParam['css_class'].'"><span class="act-nav">1</span></div>';

          return self::$pagination;
        }
      }
    } else {
      return self::$error;
    }
  }
}