<?php

namespace App\Services;

use App\Models\SmsLog;
use Carbon\Carbon;

class SmsCodeService
{
    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    private function validLastSend()
    {
        $latestSend = SmsLog::query()
            ->where('phone', $this->phone)
            ->latest()
            ->first();
        if (empty($latestSend)) {
            return true;
        }
        $latestSendAt = Carbon::parse($latestSend->created_at);
        if ($latestSendAt->addSecond(60)->greaterThan(now())) {
            return false;
        }

        return true;
    }

    public function generateRegisterCode($code = null)
    {
        $type = 'register';
        // send sms over 10 time will abort
        $todayCount = SmsLog::query()
            ->where('phone', $this->phone)
            ->where('created_at', '>=', now()->startOfDay())
            ->count();

        if ($todayCount >= 10) {
            fe_abort('今日发送次数已超过限制');
        }

        if (! $this->validLastSend()) {
            fe_abort('短信已发送，请在一分钟后重试');
        }

        // generate random sms code
        if (null == $code) {
            $code = $this->randomCode();
        }

        SmsLog::query()->create([
            'type'  => $type,
            'phone' => $this->phone,
            'code'  => $code,
        ]);

        return $code;
    }

    public function validate($code)
    {
        $lastLog = $this->getSendLastLog();

        if (empty($lastLog)) {
            return false;
        }

        if ($lastLog->attempt_count >= 3) {
            return false;
        }
        $lastLog->increment('attempt_count');
        $lastLog->save();

        return $lastLog->code == $code;
    }

    private function randomCode()
    {
        return random_int(1000, 9999);
    }

    private function cacheKey($from = null)
    {
        if (empty($from)) {
            return $this->phone;
        }

        return snake_case($from).'_'.$this->phone;
    }

    /**
     * User: wangju
     * Date: 2018/11/18 11:22 AM.
     *
     * @return SmsLog|null
     */
    private function getSendLastLog()
    {
        $latestSend = SmsLog::query()
            ->where('phone', $this->phone)
            ->latest()
            ->first();
        if (empty($latestSend)) {
            return null;
        }

        $latestSendAt = Carbon::parse($latestSend->created_at);
        if ($latestSendAt->addSecond(60 * 5)->lessThan(now())) {
            return null;
        }

        return $latestSend;
    }
}
