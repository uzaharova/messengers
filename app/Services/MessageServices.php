<?php

namespace App\Services;

use App\Jobs\ViberJob;
use App\Jobs\TelegramJob;
use App\Jobs\WhatsAppJob;
use App\Message;

class MessageServices
{
    /**
     * Checks the message. If message has - true
     *
     * @param string $to      The email
     * @param string $message The message
     *
     * @return bool the result of the check
     */
    public function checkMessage(string $to, string $message) : bool
    {
        $message = Message::select('id')->where([['to', $to], ['message', $message]])->first();

        return empty($message) ? false : true;
    }

    /**
     * Checks the email
     *
     * @param string $email The email
     *
     * @return bool the result of the check
     */
    public function checkValidateEmail(string $email) : bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Sends the message in Viber, Telegram, WhatsApp
     *
     * @param string $from    The email
     * @param string $to      The email
     * @param string $message The message
     * @param int    $delay   The delay time
     *
     * @return bool the send
     */
    public function sendInMessengers(string $from, string $to, string $message, int $delay = 0) : bool
    {
        $messengers = config('messengers');

        $recipients = explode(',', $to);

        foreach ($recipients as $recipient) {
            if (!$this->checkValidateEmail($recipient)) {
                continue;
            }

            if ($this->checkMessage($recipient, $message)) {
                continue;
            }

            Message::insert(['from' => $from, 'to' => $recipient, 'message' => $message]);

            foreach ($messengers as $messenger => $messenger_job) {
                $class_name = 'App\\Jobs\\' . $messenger_job;
                dispatch((new $class_name($from, $recipient, $message))->onQueue($messenger)->delay($delay));
            }
        }

        return true;
    }

    /**
     * Gets the delay
     *
     * @param string  $delay_date The date
     * @param integer $start      The time now
     *
     * @return int the delay
     */
    public function getDelay(string $delay_date, int $start) : int
    {
        $delay = 0;

        $delay_time = strtotime($delay_date);

        if ($start < $delay_time) {
            $delay = $delay_time - $start;
        }

        return $delay;
    }
}