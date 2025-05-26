<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Burada, uygulamanın varsayılan guard ve password reset ayarlarını belirleyebilirsiniz.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'kullanici_yonetimis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Her guard, kullanıcı provider'ı ile ilişkilendirilir. Guard, kullanıcının
    | nasıl doğrulanacağını belirtir (session, token, vs.).
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'kullanici_yonetimis',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'kullanici_yonetimis',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Burada kullanıcıları veritabanından nasıl alacağını belirleyen provider'lar tanımlanır.
    |
    */

    'providers' => [
        'kullanici_yonetimis' => [
            'driver' => 'eloquent',
            'model' => App\Models\KullaniciYonetimi::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Parola sıfırlama ayarları.
    |
    */

    'passwords' => [
        'kullanici_yonetimis' => [
            'provider' => 'kullanici_yonetimis',
            'table' => 'password_resets',  // Eğer password reset kullanacaksan, migration olması lazım
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Parola onayının zaman aşımı (dakika cinsinden).
    |
    */

    'password_timeout' => 10800,

];
