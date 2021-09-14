<?php

namespace Sitic\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PHPUnit\Exception;


/**
 * @group Authentication API
 *
 * APIs for OAuth Login, Register, Passowrd / Email change
 */
class AuthController extends Controller
{

    /**
     * Login User
     *
     * This endpoint lets you login with OAuth and return Bearer Token.
     * @bodyParam email email required User email. Example: mharris@example.com
     * @bodyParam password string required User password. Example: 123456
     *
     */
    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'email|required|max:255|min:3',
            'password' => 'min:8|max:255|required'
        ]);

        $client = new Client();

        try {
            return $client->post(env('APP_URL') . config('services.passport.login_endpoint'), [
                "form_params" => [
                    'client_secret' => config('services.passport.client_secret'),
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => __($e->getMessage())]);
        }
    }

    /**
     * Register User
     *
     * This endpoint lets you regsiter new user with OAuth and return Bearer Token.
     * @bodyParam name string required User name. Example: Michal Harris
     * @bodyParam email email required User email. Example: mharris@example.com
     * @bodyParam password string required User password. Example: 12345678
     * @bodyParam password_confirmation string required User password confirmed. Example: 12345678
     *
     */
    public function register(Request $request) {
        $this->validate($request, [
            'email' => 'email|required|max:255|min:3|unique:users,email',
            'password' => 'min:8|max:255|required|confirmed',
            'name' => 'min:3|max:255|required',
        ]);

        if (User::where('email', '=', $request->email)->exists()) {
            return response()->json(['status' => 'error', 'message' => __('User with this email already exists.')]);
        }

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);

            if ($user->save()) {
                return $this->login($request);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => __($e->getMessage())]);
        }
    }

    /**
     * Logout User
     *
     * This endpoint lets you logout and deactivate all active Bearer Tokens.
     *
     */
    public function logout(Request $request) {
        try {
            auth()->user()->tokens->each(function ($token) {
                $token->delete();
            });
            return response()->json(['status' => 'success', 'message' => __('Logged out successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => __($e->getMessage())]);
        }
    }
}
