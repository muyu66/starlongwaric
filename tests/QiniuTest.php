<?php

use App\Http\Components\Qiniu;

class QiniuTest extends TestCase
{
    private $to_key = 'qiniu_unit_temp.txt';

    /**
     * 测试方法
     *
     * @author Zhou Yu
     */
    public function testStart()
    {
        Storage::disk('unit')->put($this->to_key, 'test');
    }

    public function testPutFile()
    {
        $qiniu = new Qiniu();
        $token = $qiniu->getToken(static::UNIT_QINIU_BUCKET);
        $file_path = storage_path('unit' . '/' . $this->to_key);
        $qiniu->putFile($token, $this->to_key, $file_path);
    }

    public function testGetCount()
    {
        $qiniu = new Qiniu();
        $this->assertTrue($qiniu->getCount(static::UNIT_QINIU_BUCKET) === 1);
    }

    public function testDelete()
    {
        $qiniu = new Qiniu();
        $qiniu->delete(static::UNIT_QINIU_BUCKET, $this->to_key);
    }

    /**
     * 测试方法
     *
     * @author Zhou Yu
     */
    public function testEnd()
    {
        Storage::disk('unit')->delete($this->to_key);
    }
}