<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Module</title>
    <script src="/local/js/script.js"></script>
</head>
<body>
    <button id="showPopupButton">Показать попап</button>
    <div id="popup" style="display:none;">
        <input type="text" id="userData" />
        <button id="submitButton">Отправить</button>
    </div>
</body>
</html>
