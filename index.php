<?php

include_once 'sql.calss.php';
include_once 'files.class.php';

$db = new DB();
$file = new Files();
$list = $db->getFilesList();

?>
<html>
<head>
    <meta charset="UTF-8">
    <title>File Uploads</title>
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="js/app.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="container">
    <div id="header">
        <div id="slogan">
            File Uploads
        </div>
    </div>

    <div id="content">
        <div id="buttons">
            <div id="add_file">+</div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Название файла</th>
                    <th>Размер</th>
                    <th>Инфо</th>
                    <th>Дата добавления</th>
                </tr>
            </thead>
            <tbody>
                <? foreach($list as $f): ?>
                    <tr>
                        <td><?=$f['originalName'];?></td>
                        <td><?=$f['fileSize'];?></td>
                        <td><?=$f['fileType'];?></td>
                        <td><?=$f['added'];?></td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="footer">
        &copy; Власов Максим 2016г.
    </div>
</div>

<div id="popup">
    <div id="close">x</div>
    <div id="form_content">
        <form id="form" enctype="multipart/form-data" method="POST" action="">
            <p>
                <label for="userfile">Файл: </label>
                <input id="userfile" name="userfile" type="file">
            </p>
            <p>
                <label for="comment">Комментарий: </label>
                <input id="comment" name="comment" type="text">
            </p>
            <p>
                <label for="description">Описание: </label>
                <textarea id="description" name="description"></textarea>
            </p>
            <p><input type="submit" name="submit" value="Загрузить"></p>
        </form>
    </div>
</div>

</body>
</html>
<?php
if(isset($_POST['submit'])){
    $data = null;
    $comment = htmlspecialchars($_POST['comment']);
    $description = htmlspecialchars($_POST['description']);
    if(false != ($data = $file->saveFile())){
        $data['comment'] = $comment;
        $data['description'] = $description;
        if(false != ($id = $db->saveFileData($data))){
            echo "<script>window.location = 'http://{$_SERVER['HTTP_HOST']}';</script>";
        }else{
            echo '<script> alert("Произошла ошибка при сохранении файла"); </script>';
        }
    }


}



?>