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
                        <td><?=$f['size'];?></td>
                        <td><?=json_decode($f['data'])?></td>
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
        <form enctype="multipart/form-data" method="POST" action="">
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
    $comment = htmlspecialchars($_POST['comment']);
    $description = htmlspecialchars($_POST['description']);
    $upload_dir = '../uploads/';
    $fileType = explode('.',$_FILES['userfile']['name']);
    $fileType = $fileType[count($fileType)-1];
    $fileIndexName = generate_name();
    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');
    $upload_file = $upload_dir.$fileIndexName;
    if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_file)){

    }else{
        echo '<script> alert("Ошибка при копировании файла") </script>';
    }


}


function generate_name(){
    $name = '';
    for($i=0;$i<20;$i++){
        $name  .= rand(0,9);
    }
    return md5($name);
}
?>