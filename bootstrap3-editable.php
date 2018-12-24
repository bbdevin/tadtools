<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/bootstrap3-editable.php")){
redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/bootstrap3-editable.php";
$bootstrap3_editable=new bootstrap3_editable();
$bootstrap3_editable->render('.editable','ajax.php');

http://vitalets.github.io/x-editable/docs.html
<a href="#" class="editable" data-name="username" data-type="text" data-pk="1" data-title="Enter username" data-params="{op: 'en'}">superuser</a>

type ：輸入類型 (text, textarea, select)
pk ：主索引的值，也可以這樣寫 {id: 1, lang: 'en'}
id or name ：主索引的名稱
value ：預設值，如果是空白，就是以原本內容為主

 */
include_once "tadtools_header.php";
include_once "jquery.php";

class bootstrap3_editable
{
    public $show_jquery;

    //建構函數
    public function __construct($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
    }

    //產生語法
    public function render($name = ".editable", $url = "ajax.php")
    {
        global $xoTheme;

        $jquery = $this->show_jquery ? get_jquery() : "";

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/bootstrap3-editable/css/bootstrap-editable.css');
            $xoTheme->addScript('modules/tadtools/bootstrap3-editable/js/bootstrap-editable.min.js');
            $xoTheme->addScript('', null, "\$(document).ready(function(){
                    \$('{$name}').editable({url: '$url',});
                });");
        } else {
            $main = "
            {$jquery}
            <link href='" . TADTOOLS_URL . "/bootstrap-editable/css/bootstrap-editable.css' rel='stylesheet'>
            <script src='" . TADTOOLS_URL . "/bootstrap-editable/js/bootstrap-editable.js'></script>
            <script type='text/javascript'>
                $(document).ready(function(){
                    $('{$name}').editable({url: '$url',});
                });
            </script>
            ";

            return $main;
        }
    }
}