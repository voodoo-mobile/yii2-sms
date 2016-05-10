<?php
namespace vm\sms\twilio;

use vm\sms\SmsMessage;

class TwilioSmsProvider extends \vm\sms\SmsProvider
{
    public $sid;

    public $authToken;

    public $sender;

    public function deliver(SmsMessage $message)
    {
        $http = new \Services_Twilio_TinyHttp(
            'https://api.twilio.com',
            [
                'curlopts' => [
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_SSL_VERIFYHOST => 2,
                ]
            ]
        );

        $client = new \Services_Twilio($this->sid, $this->authToken, "2010-04-01", $http);

        return $client->account->messages->sendMessage($this->sender, $message->recipient, $message->text);
    }

    public function verifyPhone($number)
    {
        $client = new \Lookups_Services_Twilio(
            \Yii::$app->params['twillioSid'],
            \Yii::$app->params['twillioAuthToken']
        );

        $number = $client->phone_numbers->get($number);

        try {
            if ($number->phone_number) {
                return true;
            }

            return false;
        } catch (\Services_Twilio_RestException $e) {
            return false;
        }
    }
}