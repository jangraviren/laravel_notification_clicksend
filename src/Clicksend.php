<?php

namespace ClickSendNotification;

use ClickSendLib\Controllers\SMSController;

class Clicksend
{
    /**
     * @var SMSController
     */
    protected $clicksendSmsController;

    /**
     * Default 'from' from config.
     * @var string
     */
    protected $from;

    /**
     * Clicksend constructor.
     *
     * @param  SMSController $clicksendSmsController
     * @param  string $from
     */
    public function __construct(SMSController $clicksendSmsController, $from)
    {
        $this->clicksendSmsController = $clicksendSmsController;
        $this->from = $from;
    }

    /**
     * Send a Message.
     *
     * @param ClicksendMessage $message
     * @param $to
     * @return string
     * @throws \Exception
     */
    public function sendMessage(ClicksendMessage $message, $to)
    {
        if ($message instanceof ClicksendSmsMessage) {
            return $this->sendSmsMessage($message, $to);
        }

        throw new \Exception('Unable to send message.');
    }

    /**
     * Send SMS message.
     *
     * @param $message
     * @param $to
     * @return string
     * @throws \ClickSendLib\APIException
     */
    protected function sendSmsMessage($message, $to)
    {
        $payload = [
            [
                'body' => $message,
                'to' => $to,
            ]
        ];

        return $this->clicksendSmsController->sendSms($payload);
    }
}
