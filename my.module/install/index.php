<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;

class my_module extends CModule
{
    public function __construct()
    {
        $this->MODULE_ID = 'my.module';
        $this->MODULE_NAME = 'My Module';
        $this->MODULE_DESCRIPTION = 'My Module Description';
        $this->PARTNER_NAME = 'My Company';
        $this->PARTNER_URI = 'http://' . $this->getHost() . '/my.module.php';
    }


    public function DoInstall()
    {
        global $APPLICATION;
        ModuleManager::registerModule($this->MODULE_ID);
        $this->installDB();
        $this->installFiles();
        $APPLICATION->IncludeAdminFile($this->MODULE_NAME . ' installation', $_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/step.php');
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        $this->uninstallFiles();
        $this->uninstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile($this->MODULE_NAME . ' uninstallation', $_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/unstep.php');
    }

    public function installDB()
    {
        $connection = \Bitrix\Main\Application::getConnection();
        if (!$connection->isTableExists('my_module_table')) {
            $query = 'CREATE TABLE my_module_table (
                ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                CODEWORD VARCHAR(255) NOT NULL,
                USER VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
            $connection->queryExecute($query);
        }
    }

    public function installFiles()
    {
        $logFile = __DIR__ . '/install_log.txt';

        // Логируем начало выполнения
        file_put_contents($logFile, "Начало установки: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

        // Логируем попытку копирования компонентов
        $componentsSource = __DIR__ . '/../components';
        $componentsDestination = $_SERVER['DOCUMENT_ROOT'] . '/local/components';

        if (CopyDirFiles($componentsSource, $componentsDestination, true, true)) {
            file_put_contents($logFile, "Компоненты успешно скопированы\n", FILE_APPEND);
        } else {
            file_put_contents($logFile, "Ошибка копирования компонентов\n", FILE_APPEND);
            if (!is_dir($componentsSource)) {
                file_put_contents($logFile, "Исходная папка компонентов не существует: $componentsSource\n", FILE_APPEND);
            }
            if (!is_dir($componentsDestination)) {
                file_put_contents($logFile, "Папка назначения не существует или недоступна: $componentsDestination\n", FILE_APPEND);
            }
        }

        // Логируем попытку копирования файла my.module.php
        $fileSource = __DIR__ . '/../my.module.php';
        $fileDestination = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/www/my.module.php';

        if (CopyDirFiles($fileSource, $fileDestination, true, true)) {
            file_put_contents($logFile, "Файл my.module.php успешно скопирован\n", FILE_APPEND);
        } else {
            file_put_contents($logFile, "Ошибка копирования файла my.module.php\n", FILE_APPEND);
            if (!file_exists($fileSource)) {
                file_put_contents($logFile, "Исходный файл не существует: $fileSource\n", FILE_APPEND);
            }
            if (!is_dir(dirname($fileDestination))) {
                file_put_contents($logFile, "Папка назначения не существует или недоступна: " . dirname($fileDestination) . "\n", FILE_APPEND);
            }
        }

        // Логируем окончание выполнения
        file_put_contents($logFile, "Окончание установки: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    }

    public function uninstallDB()
    {

        $connection = \Bitrix\Main\Application::getConnection();
        if (!$connection->isTableExists('my_module_table')) {
            $query = 'CREATE TABLE my_module_table (
                ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                CODEWORD VARCHAR(255) NOT NULL,
                USER VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
            $connection->queryExecute($query);
        }

        // MyModuleTable::dropTable();
    }

    public function uninstallFiles()
    {
        // Удаляем компоненты из /local/components
        DeleteDirFilesEx('/local/components/my/my.module/');

        // Удаляем файл my.module.php из bitrix/www
        DeleteDirFilesEx('/bitrix/www/my.module.php');
    }
    
    public function getHost()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        return $request->getHttpHost();
    }
    

}
