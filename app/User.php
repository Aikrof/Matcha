<?php

namespace App;

use Auth;
use Hash;
use App\Notifications\ConfirmEmailSender;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;


    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'login', 'email', 'password', 'gender', 'first_entry',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function creatUserDir($login)
    {
        $path = resource_path() . '/profiles/';

        if (!file_exists($path))
            mkdir($path);
        if (!file_exists($path . $login))
            mkdir($path . $login);
    }

    /**
    * Override default method sendEmailVerificationNotification Illuminate/Auth/Listeners/SendEmailVerificationNotification
    */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new ConfirmEmailSender());
    }

    /**
     * Validate request email domain.
     *
     * @param  string  $email
     * @return bool
     */
    public static function checkEmailDomain($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        $mx = getmxrr($domain, $mx_records, $mx_weight);
        if ($mx == false || count($mx_records) == 0 ||
            (count($mx_records) == 1 && ($mx_records[0] == null || $mx_records[0] == "0.0.0.0")))
            return false;
        else
            return true;
    }
}
