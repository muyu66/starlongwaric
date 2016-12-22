<?php

use App\Http\Components\Qiniu;

class QiniuTest extends TestCase
{
    private $to_key = 'qiniu_unit_temp.txt';

    public function testReady()
    {
        Storage::disk('unit')->put($this->to_key, 'test');
    }

    public function testUpload()
    {
        $qiniu = new Qiniu();
        $token = $qiniu->getToken(Qiniu::BUCKET_MAIN);
        $file_path = storage_path('unit' . '/' . $this->to_key);
        $qiniu->putFile($token, $this->to_key, $file_path);
    }

    public function testDelete()
    {
        $qiniu = new Qiniu();
        $qiniu->delete(Qiniu::BUCKET_MAIN, $this->to_key);
    }

    public function testEnd()
    {
        Storage::disk('unit')->delete($this->to_key);
    }
}