<?php

namespace Tests\Unit;

use App\Models\SmsLog;
use App\Services\SmsCodeService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SmsServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_generate_code()
    {
        $phone = '13888888888';
        $service = new SmsCodeService($phone);
        $result = $service->generateRegisterCode();

        dd($result);

    }

    public function test_generate_code_over_send_count()
    {
        $phone = '13888888888';

        create(SmsLog::class,[
            'phone' => $phone,
            'code' => '1234'
        ],10);
        $phone = '13888888888';
        $service = new SmsCodeService($phone);
        $result = $service->generateRegisterCode();

        dd($result);

    }

}
