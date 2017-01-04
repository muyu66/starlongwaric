<?php

namespace App\Http\Components;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Qiniu
{
    private $ak, $sk, $auth;
    const BUCKET_MAIN = 'starlongwaric';
    const PIPELINE_MAIN = 'starlongwaric';

    public function __construct()
    {
        $this->ak = config('services.qiniu')['ak'];
        $this->sk = config('services.qiniu')['sk'];
        $this->auth = new Auth($this->ak, $this->sk);
    }

    private function getBucket()
    {
        return new BucketManager($this->auth);
    }

    private function getUpload()
    {
        return new UploadManager();
    }

    public function putFile($token, $to_key, $file_path)
    {
        return $this->getUpload()->putFile($token, $to_key, $file_path);
    }

    public function getToken($bucket)
    {
        return $this->auth->uploadToken($bucket);
    }

    public function getList($bucket)
    {
        return $this->getBucket()->listFiles($bucket);
    }

    public function delete($bucket, $key)
    {
        return $this->getBucket()->delete($bucket, $key);
    }

    public function stat($bucket, $key)
    {
        return $this->getBucket()->stat($bucket, $key);
    }
}