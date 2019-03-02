<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ViberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from;
    protected $to;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $from, string $to, string $message)
    {
        $this->from = $from;
        $this->to = $to;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() : void
    {
        $max_attempts = config('default_params.max_attempts');
        $user_id = $this->getUserId($this->to);

        try {
            // TODO send to messenger
        } catch (\Exception $e) {
            if ($this->attempts() < $max_attempts) {
                dispatch((new TelegramJob($this->from, $this->to, $this->message))->onQueue('telegram'));
            }
        }
    }

    /**
     * Gets the user id for messenger
     *
     * @param string $email The email
     *
     * @return int the user id
     */
    private function getUserId(string $email) :int
    {
        $user_id = 1;

        // TODO get id

        return $user_id;
    }
}
