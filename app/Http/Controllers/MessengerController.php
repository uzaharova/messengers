<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SendMessagePost;
use App\Services\MessageServices;

class MessengerController extends Controller
{
    /**
     * Send the message
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(SendMessagePost $request, MessageServices $message_services)
    {
        $delay = 0;
        if ($request->has('delay_date')) {
            $delay = $message_services->getDelay((string) $request->delay_date, time());
        }

        $result = $message_services->sendInMessengers((string) $request->from, (string) $request->to, (string) $request->message, (int) $delay);

        return response()->json(['status' => $result]);
    }
}
