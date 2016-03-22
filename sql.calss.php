<?php

class DB {

    private $host = '127.0.0.1';
    private $user = 'root';
    private $password = '';
    private $connection = null;

    public function __construct(){
        $this->connection = mysql_connect($this->host,$this->user,$this->password);
        mysql_select_db('file_uploads',$this->connection);
    }

    public function saveFileData(array $data){
        $query = "INSERT INTO `files_info` (`id`, `fileName`, `originalName`, `fileType`, `fileSize`, `comment`, `description`, `added`) VALUES (NULL, '{$data['fileName']}', '{$data['originalName']}', '{$data['fileType']}', '{$data['fileSize']}', '{$data['comment']}', '{$data['description']}', '{$data['added']}')";
        if(mysql_query($query)){
            return mysql_insert_id($this->connection);
            //return $data;
        }else{
            return false;
        }
    }

    public function deleteFile($id){
        if($id!=''){
            if(mysql_query("DELETE FROM file_uploads WHERE id={$id}")){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getFilesList($param = null){
            $query = '';
        if($param == null){
            $query = "SELECT * FROM files_info ORDER BY added DESC";
        }else{
            $query = "SELECT * FROM files_info ORDER BY {$param['field']} {$param['type']}";
        }
        $list = [];
        $res = mysql_query($query);
        while($f = mysql_fetch_array($res)){
            $list[] = $f;
        }
        return $list;
    }

}