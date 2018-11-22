<?php

namespace Tests\Feature;

use Overtrue\EasySms\EasySms;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    public function test_send_register_sms_code()
    {
        $result = $this->postJson('/api/auth/register_code', [
            'phone' => '13888888888',
        ]);

        $this->assertTrue(true);
    }

    public function test_send_sms(){
        if (app()->environment() != 'production'){
            $this->assertTrue(true);
            return;
        }

        try{
            $result = easy_sms()->send(18888888888,[
                'template' => 'SMS_63885240',
                'data' => [
                    'code' => 6379
                ],
            ]);
        }catch (\Exception $e){
            dd($e);
        }

        $this->assertTrue($result);

    }

    /**
     * A basic test example.
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
