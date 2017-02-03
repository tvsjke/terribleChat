<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

if(isset($_POST['txt_msg'])) {
    $msg = trim($_POST['txt_msg']);
    $homepage = isset($_POST['txt_homepage']) ? trim($_POST['txt_homepage']) :'';

    //тут нужно бы было подключить wysiwyg редактор, но т.к. это слишком тяжеловесно для данной задачи, попробуем решить эту проблему своими силами

    //ремонтируем строку
    $msg = tidy_repair_string($msg, ['show-body-only'=>true]);

    //смотрим, есть ли неразрешенные теги
    $pattern = '/<(br|basefont|hr|input|source|frame|param|area|meta|!--|col|link|option|base|img|wbr|!DOCTYPE).*?>|<(abbr|acronym|address|applet|article|aside|audio|b|bdi|bdo|big|blockquote|body|button|canvas|caption|center|cite|colgroup|command|datalist|dd|del|details|dfn|dialog|dir|div|dl|dt|em|embed|fieldset|figcaption|figure|font|footer|form|frameset|head|header|hgroup|h1|h2|h3|h4|h5|h6|html|iframe|ins|kbd|keygen|label|legend|li|map|mark|menu|meter|nav|noframes|noscript|object|ol|optgroup|output|p|pre|progress|q|rp|rt|ruby|s|samp|script|section|select|small|span|style|sub|summary|sup|table|tbody|td|textarea|tfoot|th|thead|time|title|tr|track|tt|u|ul|var|video).*?<\/\2>/i';

    //и проверяем
    if(!preg_match($pattern, $msg)) {
        $msg = htmlentities($msg);

        $model->postAdd($msg, $homepage);
    }
}

$user->redirect('index.php');