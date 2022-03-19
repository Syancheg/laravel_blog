<?php

namespace App\Http\Controllers\Admin\Common;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

const IMAGE_EXTENTIONS = [
    'jpg',
    'jpeg',
    'png',
    'webp'
];

const VIDEO_EXTENTIONS = [
    'mp4',
    'webm'
];

const PAGE_MAX = 18;

class FilemanagerController extends AdminController
{
    private $filelist;
    private $resultArray;
    private $storagePath;
    private $currentPath;

    public function __construct()
    {
        $this->storagePath = storage_path() . '/app/public/origin';
        $this->currentPath = storage_path() . '/app/public/origin';
        $this->filelist['base_settings']['upload_url'] = route('admin.filemanager.upload');
        $this->filelist['base_settings']['new_folder_url'] = route('admin.filemanager.new_folder');
        $this->filelist['base_settings']['delete_url'] = route('admin.filemanager.delete');
    }

    public function getFiles(Request $request)
    {
        $directory = '';
        $page = 1;
        if(isset($request['url'])) {
            $directory = $request['url'];
        }
        if(isset($request['page'])) {
            $page = $request['page'];
        }
        $this->getFilesFromDirectory($directory, $page);
        return $this->filelist;
    }

    private function getFilesFromDirectory($directory, $page){
        $this->currentPath .= $directory;
        if(!file_exists($this->currentPath)){
            return;
        }
        if ($directory) {
            $this->filelist['current_directory'] = '' . $directory;
        } else {
            $this->filelist['current_directory'] = '/';
        }
        $this->filelist['items'] = [];
        $scanDir = array_filter(scandir($this->currentPath, SCANDIR_SORT_ASCENDING),function ($item) {
            return $item[0] !== '.';
        });
        $pages = 1;
        if (count($scanDir) > PAGE_MAX) {
            $pages = (int)(count($scanDir) / PAGE_MAX);
        }
        $this->filelist['pages'] = $pages;
        $this->filelist['page'] = $page;
        $filesPage = [];
        for ($i = 0; $i < $pages; $i++) {
            $filesPage[$i+1] = array_slice($scanDir, PAGE_MAX * $i, PAGE_MAX);
        }

        foreach ($filesPage[$page] as $item){
            $filename = $this->currentPath . '/' . $item;
            if(file_exists($filename) && is_dir($filename)){
                $this->filelist['items'][] = [
                    'name' => $item,
                    'link' => str_replace($this->storagePath, '', $filename),
                    'type' => 'dir',
                    'id' => random_int(100, 1000)
                ];
            } else if(file_exists($filename)) {
                if(in_array(pathinfo($filename)['extension'], IMAGE_EXTENTIONS)) {
                    $this->filelist['items'][] = [
                        'name' => $item,
                        'link' => str_replace($this->storagePath, '', $filename),
                        'src' => str_replace($this->storagePath, '/storage/origin', $filename),
                        'file_id' => File::select('id')->where(['path_origin' => str_replace($this->storagePath, 'public/origin', $filename)])->first()->id,
                        'type' => 'image',
                        'id' => random_int(100, 1000)
                    ];
                } else if (in_array(pathinfo($filename)['extension'], VIDEO_EXTENTIONS)) {
                    $this->filelist['items'][] = [
                        'name' => $item,
                        'link' => str_replace(storage_path() . '/app/', '', $filename),
                        'type' => 'video',
                        'id' => random_int(100, 1000)
                    ];
                }
            }
        }
    }

    public function newFolder(Request $request) {
        $url = $request['url'];
        $error = [];
        if(!is_null($url)){
            $path  = $this->storagePath . $url;
            if (!file_exists($path)) {
                return mkdir($path, 0777, true);
            } else {
                $error[] = [
                    'filename' => $url,
                    'Не удалось создать папку, так как она уже существует'
                ];
            }
        } else {
            $error[] = [
                'filename' => $url,
                'Не удалось создать папку, нет имени'
            ];
        }
        if($error) {
            return $error;
        }
    }

    public function uploadFiles(Request $request) {
        $dirPath = '';
        if(!is_null($request['dir_path'])) {
            $dirPath = substr($request['dir_path'],1) . '/';
        }
        $error = [];
        foreach ($_FILES as $file) {
            if($this->validateFile($file['name'])){
                $imageHelper = new ImageHelper();
                $uploadedFile = new UploadedFile(
                    $file['tmp_name'],
                    $file['name'],
                    $file['type']
                );
                $imageHelper->saveImage($uploadedFile, $dirPath);
            } else {
                $imageExt = implode(',', IMAGE_EXTENTIONS);
                $videoExt = implode(',', VIDEO_EXTENTIONS);
                $error[] = [
                    'filename' => $file['name'],
                    'message' => "Загрузка файла данного формата не поддерживается. Пожалуйста загрузите фото с разрешением $imageExt, или видел $videoExt .",
                ];
            }

        }
        if($error) {
            return $error;
        }
        return true;
    }

    private function validateFile($filename){
        $extention  = pathinfo($filename)['extension'];
        if(in_array($extention, IMAGE_EXTENTIONS)){
            return true;
        }
        if(in_array($extention, VIDEO_EXTENTIONS)){
            return true;
        }
        return false;
    }

    public function deleteEntity(Request $request){
        $error = [];
        if($request){
            foreach ($request['files'] as $file) {
                $filename = $this->storagePath . $file['url'];
                if(file_exists($filename) && is_dir($filename)) {
                    $this->deleteDir($filename);
                } else if(file_exists($filename)){
                    $this->deleteFile($filename);
                } else {
                    $error[] = [
                        'filename' => $file['url'],
                        'Не удалось удалить, так как файл или папка не существует'
                    ];
                }
            }
        }
        if($error){
            return $error;
        }
        return true;
    }

    private function deleteFile($filename){
        $file = File::where(['path_origin' => str_replace($this->storagePath, 'public/origin', $filename)])->first();
        if ($file) {
            $file->delete();
        }
        return unlink($filename);
    }

    private function deleteDir($dir){
        if($files = glob($dir . "/*")) {
            foreach ($files as $file) {
                if(is_dir($file)){
                    $this->deleteDir($file);
                } else {
                    unlink($file);
                }
            }
        }
        return rmdir($dir);
    }

    public function saveImages($images) {

    }

}
