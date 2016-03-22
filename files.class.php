<?php

class Files{

    public function saveFile(){
        $data = [];
        $upload_dir = '../uploads/';
        $fileType = explode('.',$_FILES['userfile']['name']);
        $fileType = $fileType[count($fileType)-1];
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $fileIndexName = $this->generateName();
        $upload_file = $upload_dir.$fileIndexName;
        if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_file)){
            $data['size'] = filesize($upload_file);
            $data['inadexName'] = $fileIndexName;
            $data['fileType'] = $fileType;
            $data['realName'] = $_FILES['userfile']['name'];
            return $data;
        }else{
            return false;
        }
    }

    public function deleteFile($index){

    }

    public function getFile(){

    }

    private function generateName(){
        $name = '';
        for($i=0;$i<20;$i++){
            $name  .= rand(0,9);
        }
        return md5($name);
    }

}