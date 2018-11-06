<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewRequestRequest;
use App\Models\Request;
use App\Models\User;
use App\Notifications\RequestNotification;
use App\Notifications\RequestConfirmation;

class RequestsController extends Controller
{

    /**
     * Creates a new request
     * @param NewRequestRequest $request
     * @return array
     */
    public function new(NewRequestRequest $request)
    {

        /** @var User $customer */
        $customer = $request->user();

        $quoteRequest = new Request([
            'service_id' => $request->service_id,
            'user_id' => $customer->id,
        ]);
        $quoteRequest->save();

        // notify the requesting user (confirmation)
        $customer->notify(new RequestConfirmation($quoteRequest));

        // notify all the providers that provides the service
        foreach ($request->service->users as $provider) {
            $provider->notify(new RequestNotification($quoteRequest));
        }

        return response(null, 201);
    }
}
