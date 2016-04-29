<?php
namespace vm\sms;

abstract class SmsProvider
{
    public function compose()
    {
        return new SmsMessage([
            'provider' => $this
        ]);
    }

    public abstract function deliver(SmsMessage $message);

    public abstract function verifyPhone($number);
}