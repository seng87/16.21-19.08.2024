<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use My\Module\OrmTable;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require($_SERVER['DOCUMENT_ROOT'] . "/local/modules/my.module/lib/OrmTable.php");
Loader::includeModule('my.module');

$APPLICATION->IncludeComponent(
	"my:my.module",  // Имя компонента
	"",                              // Шаблон компонента (оставьте пустым для использования по умолчанию)
	array(
		// Массив параметров компонента
		"PARAM1" => "value1",
		"PARAM2" => "value2",
		// Добавьте другие параметры, если требуется
	),
	false                            // Не меняйте этот параметр
);
$codeWord = "пароль";
$userName = "пользователь";

OrmTable::add([
	'CODEWORD' => $codeWord,
	'USER' => $userName,
]);

require_once($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/epilog_after.php");
