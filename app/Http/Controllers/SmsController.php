<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    /**
     * User: wangju
     * Date: 2018/11/17 9:03 PM
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function registerCode(Request $request){

        $this->validate($request,[
            'phone' => 'required'
        ]);

        $phone = $request->phone;

        // generate random sms code
        $code = random_int(1000,9999);

        $key = snake_case(__FUNCTION__).'_'.$phone;

        cache()->put($key,$code,5);

        return api()->success(['sms_code' => cache()->pull($key)]);



        dd($key);



        dd($code);

        dd($phone);


    }
}
