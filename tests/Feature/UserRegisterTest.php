<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    public function test_send_register_sms_code()
    {
        $result = $this->postJson('/api/auth/register_code', [
            'phone' => '13888888888',
        ]);

        dd($result->json());
    }

    /**
     * A basic test example.
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
