<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    //只允许以下后缀名的图片文件上传
    protected $allowed_ext = ["png","jpg","jpeg"];

    public function save($file,$folder, $file_prefix,$max_width=false)
    {
        //构建存储的文件夹规则，如：uploads/images/avatars/201709/21
        //文件夹切割能让查找效率更高。
        $folder_name="uploads/images/$folder/" . date("Ym/d", time());

        //文件具体存储的物理路径，’public——path()'获取的是‘public’文件夹的物理路径。
        $upload_path=public_path() . '/' .$folder_name;

        //后缀名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        //获取文件名，可以加前缀
        $filename=$file_prefix . '_' .time() . '_' . str_random(10) . '.' . $extension;

        //如果上传的不是图片将终止操作
        if(!in_array($extension, $this->allowed_ext)){
            return false;
        }

        //将图片移动到我们的目标存储路径中
        $file->move($upload_path,$filename);

        if($max_width){
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') ."/$folder_name/$filename"

        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        $image = Image::make($file_path);

        $image->resize($max_width,$max_width,function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save();
    }
}