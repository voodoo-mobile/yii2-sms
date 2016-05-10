<?php

namespace vm\sms;

use yii\base\Component;

class SmsMessage extends Component
{
    /**
     * @var SmsProvider
     */
    public $provider;

    public $recipient;

    public $text;

    public $errorException;

    public function setTo($phone)
    {
        $this->recipient = $phone;

        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function send()
    {
        return $this->provider->deliver($this);
    }

    public function verifyPhone()
    {
        return $this->provider->verifyPhone($this->recipient);
    }
}