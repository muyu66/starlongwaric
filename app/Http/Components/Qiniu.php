<?php

namespace App\Http\Components;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Qiniu
{
    private $ak, $sk;

    private $auth;

    private $bucket;

    private $upload;

    const BUCKET_MAIN = 'starlongwaric';
    const PIPELINE_MAIN = 'starlongwaric';

    public function __construct()
    {
        $this->ak = config('services.qiniu')['ak'];
        $this->sk = config('services.qiniu')['sk'];
    }

    private function getAuth()
    {
        if (! $this->auth) {
            $this->auth = new Auth($this->ak, $this->sk);
        }
        return $this->auth;
    }

    private function getBucket()
    {
        if (! $this->bucket) {
            $this->bucket = new BucketManager($this->getAuth());
        }
        return $this->bucket;
    }

    private function getUpload()
    {
        if (! $this->upload) {
            $this->upload = new UploadManager();
        }
        return $this->upload;
    }

    public function putFile($token, $to_key, $file_path)
    {
        return $this->getUpload()->putFile($token, $to_key, $file_path);
    }

    public function getToken($bucket)
    {
        return $this->getAuth()->uploadToken($bucket);
    }

    public function getList($bucket)
    {
        return $this->getBucket()->listFiles($bucket);
    }

    public function delete($bucket, $key)
    {
        return $this->getBucket()->delete($bucket, $key);
    }

    public function getStat($bucket, $key)
    {
        return $this->getBucket()->stat($bucket, $key);
    }

    public function getCount($bucket)
    {
        $total = $list = [];
        do {
            $list = $this->getBucket()->listFiles($bucket, null, $list[1]);
            $total = array_merge($total, $list[0] ? : []);
        } while ($list[1]);
        return count($total);
    }
}
