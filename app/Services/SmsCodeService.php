<?php

namespace App\Services;

use App\Models\SmsLog;

class SmsCodeService
{
    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function generateRegisterCode()
    {
        $type = 'register';
        // send sms over 10 time will abort
        $todayCount = SmsLog::query()
            ->where('phone', $this->phone)
            ->where('created_at', '>=', now()->startOfDay())
            ->count();

        if ($todayCount >= 10) {
            return false;
        }

        $latestSend = SmsLog::query()
            ->where('phone', $this->phone)
            ->latest()
            ->first();
        dd($latestSend);

        // generate random sms code
        $code = $this->randomCode();
        $key = $this->cacheKey($type);

        SmsLog::query()->create([
            'type'  => $type,
            'phone' => $this->phone,
            'code'  => $code,
        ]);

        return $code;
    }

    protected function randomCode()
    {
        return random_int(1000, 9999);
    }

    protected function cacheKey($from = null)
    {
        if (empty($from)) {
            return $this->phone;
        }

        return snake_case($from).'_'.$this->phone;
    }

    public function getRegisterCode()
    {
    }
}
