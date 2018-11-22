<?php

namespace App\Core\Utils;

class Sms
{
    protected static $message;

    /**
     * @param $phone
     * @param $code
     *
     * @return bool
     *
     * @author wangju 18-11-22 下午5:51
     */
    public static function sendRegisterMessage($phone, $code)
    {
        if ('production' != app()->environment()) {
            return true;
        }

        $success = true;
        try {
            static::$message = easy_sms()->send($phone, [
                'template' => 'SMS_63885240',
                'data'     => [
                    'code' => $code,
                ],
            ]);
        } catch (\Exception $e) {
            $success = false;
            static::$message = $e->getMessage();
        }
        if (is_array(static::$message)) {
            static::$message = json_encode(static::$message);
        }

        return $success;
    }

    public static function getMessage()
    {
        return static::$message;
    }
}
