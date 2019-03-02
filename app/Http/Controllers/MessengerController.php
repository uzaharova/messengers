<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MessengerTrait;
use Illuminate\Support\Facades\Validator;

class MessengerController extends Controller
{
    /**
     * Send the message
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required|email',
            'to' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false]);
        }

        $delay = 0;
        if (!empty($request->delay_date)) {
            $delay = MessengerTrait::getDelay((string) $request->delay_date, time());
        }

        $result = MessengerTrait::sendInMessengers((string) $request->from, (string) $request->to, (string) $request->message, (int) $delay);

        return response()->json(['status' => $result]);
    }
}
