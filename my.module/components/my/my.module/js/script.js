document.getElementById('open-popup').addEventListener('click', function () {
    document.getElementById('popup').style.display = 'block';
});

document.getElementById('send-data').addEventListener('click', function () {
    const codeWord = document.getElementById('code-word').value;
    const userName = document.getElementById('user-name').value;


    fetch('/local/modules/my.module/ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'code_word=' + encodeURIComponent(codeWord) + '&user_name=' + encodeURIComponent(userName),
    })
        .then(response => response.text())
        .then(result => {
            alert('Данные отправлены');
            document.getElementById('popup').style.display = 'none';
        });
});
