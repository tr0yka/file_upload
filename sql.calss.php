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
        if(mysql_query("INSERT INTO files_info(filename,originalName,data) VALUES('{$data['filename']}','{$data['originalName']}','{$data['fileInfo']}')")){
            return mysql_insert_id($this->connection);
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

}