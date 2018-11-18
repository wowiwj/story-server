<?php

namespace Tests\Unit;

use App\Exceptions\FrontEndException;
use App\Models\SmsLog;
use App\Services\SmsCodeService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SmsServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_generate_code()
    {
        $phone = '13888888888';
        $service = new SmsCodeService($phone);
        $result = $service->generateRegisterCode();

        $this->assertTrue($result >= 1000 && $result <= 9999);
    }

    public function test_generate_code_over_send_count()
    {
        $phone = '13888888888';

        create(SmsLog::class, [
            'phone' => $phone,
            'code'  => '1234',
        ], 10);
        $service = new SmsCodeService($phone);

        $message = null;

        try {
            $service->generateRegisterCode();
        } catch (FrontEndException $e) {
            $message = $e->getMessage();
        }

        $this->assertNotNull($message);
    }

    public function test_generate_code_in_one_minutes()
    {
        $phone = '13888888888';

        create(SmsLog::class, [
            'phone' => $phone,
            'code'  => '1234',
        ]);

        $service = new SmsCodeService($phone);

        $message = null;

        try {
            $service->generateRegisterCode();
        } catch (FrontEndException $e) {
            $message = $e->getMessage();
        }

        $this->assertNotNull($message);
    }

    public function test_validate_code()
    {
        $phone = '13888888888';
        $code = 1234;

        create(SmsLog::class, [
            'phone' => $phone,
            'code'  => $code,
        ]);

        $service = new SmsCodeService($phone);

        $this->assertTrue($service->validate($code));
    }

    public function test_validate_code_with_too_many_attempt()
    {
        $phone = '13888888888';
        $code = 1234;

        create(SmsLog::class, [
            'phone'         => $phone,
            'code'          => $code,
            'attempt_count' => 3,
        ]);
        $service = new SmsCodeService($phone);

        $this->assertFalse($service->validate($code));
    }
}
