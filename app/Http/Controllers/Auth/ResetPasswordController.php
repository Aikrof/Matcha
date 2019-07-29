<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->rules($request->all());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules(array $user)
    {
        $custom_message = [
            'required' => 'The :attribute field is empty.',
        ];

        $validation = Validator::make($user, [
            'login' => ['required', 'string', 'alpha_dash', 'between:4,24'],
            'email' => ['required', 'string', 'email', 'max:64'],
        ], $custom_message);

        if ($validation->fails())
        {
            die(
                json_encode($validation->messages()->first())
            );
        }

        $db_user = User::where('login', $user['login'])->first();

        if (!isset($db_user))
                $this->sendFailedResetResponse('login');
        if (($db_user['email'] !== $user['email']) || !User::checkEmailDomain($user['email']))
                $this->sendFailedResetResponse('inv_email');
        return ($validation);
    }

    /**
     * Get the failed reset password response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedResetResponse($msg)
    {
        $msg = 'auth.' . $msg;

        die(json_encode(trans($msg)));
    }
}
