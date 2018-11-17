<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegisterTest extends TestCase
{

    public function test_send_register_sms_code()
    {
        $result =  $this->postJson('/api/auth/register_code',[
            'phone' => '13888888888'
        ]);

        dd($result->json());


    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
