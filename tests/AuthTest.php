<?php

use App\Http\Controllers\AuthController;

class AuthTest extends TestCase
{
    public function testPostRegister()
    {
        AuthController::$open_code = 0; // 关闭验证码
        $this->post('auth/register', [
            'email' => 'aaa@aaa.com',
            'password' => '111111',
        ]);
        $this->seeInDatabase('users', ['email' => 'aaa@aaa.com']);
        $this->assertResponseOk();
    }

    public function testGetUser()
    {
        $this->get_with_login('auth/user');
        $this->seeJsonContains(['email' => self::UNIT_EMAIL]);
        $this->assertResponseOk();
    }

    public function testPostLogin()
    {
        AuthController::$open_code = 0; // 关闭验证码
        $this->post_with_login('auth/login');
        $this->seeJsonContains(['code' => 200]);
        $this->assertResponseOk();

        // 因为 Captcha 不支持数组引擎, 所以没法单元测试
//        AuthController::$open_code = 1; // 开启验证码
//        dump($this->post_with_login('auth/login'));
//        $this->assertResponseStatus(401);
    }
}
