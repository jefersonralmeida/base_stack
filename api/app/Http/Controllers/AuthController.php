<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\RegisterActivate;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Logs out the user, revoking the token.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response(null, 204);
    }

    /**
     * Register a new user
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verify_email_token' => str_random(60),
            'roles' => [$request->role]
        ]);

        $user->save();

        $user->notify(new RegisterActivate());

        return response(null, 201);
    }

    /**
     * Re-send the activation email
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function sendActivationEmail(User $user)
    {
        if (!is_null($user->email_verified_at)) {
            return response()->json(['message' => __('Email already verified.')], 400);
        }
        $user->notify(new RegisterActivate(true));
        return response(null, 204);
    }

    /**
     * Activates the account based on the provided token
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function activateAccount(string $token)
    {
        /** @var User $user */
        $user = User::where('verify_email_token', $token)->first();
        if (!$user) {
            return view('activate-email', ['message' => 'This activation token is invalid.']);
        }
        $user->email_verified_at = now();
        $user->verify_email_token = '';
        $user->save();
        return view('activate-email', ['message' => 'Your account has been successfully activated']);

    }

}
