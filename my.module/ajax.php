<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use My\Module\OrmTable;

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
Loader::includeModule('my.module');

$request = Context::getCurrent()->getRequest();
$codeWord = $request->getPost('code_word');
$userName = $request->getPost('user_name');

if ($userName && $codeWord) {
    OrmTable::add([
        'CODEWORD' => $codeWord,
        'USER' => $userName,
    ]);
}

echo 'success';
?>
