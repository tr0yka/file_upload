<?php

class Files{

    private $folder= '../uploads/';

    public function saveFile(){
        $data = [];
        $upload_dir = $this->folder;
        $fileType = explode('.',$_FILES['userfile']['name']);
        $fileType = $fileType[count($fileType)-1];
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $fileIndexName = $this->generateName();
        $upload_file = $upload_dir.$fileIndexName;
        if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_file)){
            $data['fileSize'] = filesize($upload_file);
            $data['fileName'] = $fileIndexName;
            $data['fileType'] = $fileType;
            $data['originalName'] = $_FILES['userfile']['name'];
            $data['added'] = $date;
            return $data;
        }else{
            return false;
        }
    }

    public function deleteFile($index){

    }

    public function getFile($id,DB $db){
        $res = $db->getDataOneFile($id);
        $path = $this->folder.$res['fileName'];
        $this->downloadFile($path,$res['originalName']);
    }

    private function generateName(){
        $name = '';
        for($i=0;$i<20;$i++){
            $name  .= rand(0,9);
        }
        return md5($name);
    }

    private function downloadFile($filepath,$filename, $mimetype = 'application/octet-stream')
    {
        $fsize = filesize($filepath); // берем размер файла
        $ftime = date('D, d M Y H:i:s T', filemtime($filepath)); // определяем дату его модификации
        $fd = @fopen($filepath, 'rb'); // открываем файл на чтение в бинарном режиме
        if (isset($_SERVER['HTTP_RANGE'])) {
            // поддерживается ли докачка?
            $range = $_SERVER['HTTP_RANGE']; // определяем, с какого байта скачивать файл
            $range = str_replace('bytes=', '', $range);
            list($range, $end) = explode('-', $range);
            if (!empty($range)) {
                fseek($fd, $range);
            }
        } else {
            // докачка не поддерживается
            $range = 0;
        }
        if ($range) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 206 Partial Content');
            // говорим браузеру, что это часть какого-то контента
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK'); // стандартный ответ браузеру
        }
        // прочие заголовки, необходимые для правильной работы
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Last-Modified: ' . $ftime);
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . ($fsize - $range));
        if ($range) {
            header("Content-Range: bytes $range-" . ($fsize - 1) . '/' . $fsize);
        }
        header('Content-Type: ' . $mimetype);
        fpassthru($fd); // отдаем часть файла в браузер (программу докачки)
        fclose($fd);
        exit;
    }

}