<?php

namespace Sitic\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetCreated;
use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetUpdated;
use Sitic\Auth\Http\Models\UserPasswordReset;
use Sitic\Auth\Http\Resources\UserPasswordResetResource;


/**
 * @group Authentication API
 *
 * APIs for OAuth Login, Register, Passowrd / Email change
 */
class UserPasswordResetController extends Controller
{

    /**
     * Send Password Reset Code
     *
     * This endpoint lets you send a code for password reset on users email address.
     * @queryParam email email required User email. Example: mharris@example.com
     *
     */
    public function code(Request $request) {
        $this->validate($request, [
            'email' => 'email|required|max:255|min:3|exists:users'
        ]);

        $user = User::where('email', $request->email)->first();

        try {
            $userPasswordReset = UserPasswordReset::create([
                'user_id' => $user->id,
                'old_password' => $user->password,
                'expired_at' => Carbon::now()->addMinutes(15),
                'code' => $this->generatePIN(6),
                'token' => Str::random(255)
            ]);
            Event::dispatch(new UserPasswordResetCreated($userPasswordReset));
            return response()->json(['status' => 'success', 'data' => new UserPasswordResetResource($userPasswordReset)]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => __($exception->getMessage())]);
        }
    }

    /**
     * Change Password With Reset Code
     *
     * This endpoint lets you send a code for password reset on users email address.
     * @bodyParam code integer required 6 digits code. Example: 123456
     * @bodyParam new_password string required New password for user. Example: 87654321
     * @bodyParam new_password_confirmation string required Same as new_password. Example: 87654321
     * @bodyParam token string required 255 length string from previous request. Example: XXBmpdga70EYYkSWgK64YMF7gg6pwaL8uaaJzhba5gtfh9pLPvD73yqYi9Ezx9MMbcitbXi1hf38nnAMUnfHBgAXZwomJZLMfd9tSk4CdFT0ExkMHEwvHboR67Ztc9SoCXD06mUDCCfwMdv31DFZKo7LQQF8DZYKNuCIxS3SxJk6Jl23lSNoVUr8M9bk0eDlcgY8cjrgkKjkN4NEMX7eK1JxfzdYrVqLwqm80eyIaYMyKK8x7hEIQsPLDz8XGmw
     *
     */
    public function change(Request $request) {
        $this->validate($request, [
            'code' => 'string|required|min:6|max:6|exists:user_password_resets',
            'token' => 'string|required|min:255|max:255|exists:user_password_resets',
            'new_password' => 'string|required|min:8|max:255|confirmed'
        ]);

        $userPasswordReset = UserPasswordReset::where([
            'code' => $request->code,
            'token' => $request->token
        ])->first();

        if (!$userPasswordReset) {
            return response()->json(['status' => 'error', 'message' => __('The selected code is invalid.')]);
        }

        if ($userPasswordReset->expired_at < Carbon::now()) {
            return response()->json(['status' => 'error', 'message' => __('The selected code is invalid.')]);
        }

        try {
            if ($userPasswordReset->update(['new_password' => app('hash')->make($request->new_password)])) {
                Event::dispatch(new UserPasswordResetUpdated($userPasswordReset));
                $userPasswordReset->delete();
                UserPasswordReset::where(['user_id' => $userPasswordReset->user_id])->delete();
                return response()->json(['status' => 'success', 'message' => __('Password has been changed.')]);
            };
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => __($exception->getMessage())]);
        }

    }

    private function generatePIN($digits = 4){
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while($i < $digits){
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
}
