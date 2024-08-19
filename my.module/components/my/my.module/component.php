<?php

use Bitrix\Main\Loader;
use My\CustomModule\ExampleTable;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code_word']) && isset($_POST['user_name'])) {
    Loader::includeModule('my.module');

    $result = ExampleTable::add([
        'CODE_WORD' => $_POST['code_word'],
        'USER_NAME' => $_POST['user_name'],
    ]);

    if ($result->isSuccess()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $result->getErrorMessages()]);
    }

    die();
}

$this->includeComponentTemplate();
