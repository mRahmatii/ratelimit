<?php
return [
    'RateLimit'=>[
        'IP_ACTIVATION'=>(int)env('RATE_LIMITER_IP'),
        'PHONE_SMS_ACTIVATION'=>(int)env('RATE_LIMITER_PHONE_SMS'),
        'PHONE_VERIFY_ACTIVATION'=>(int)env('RATE_LIMITER_PHONE_VERIFY'),
        'HOME_ACTIVATION'=>(int)env('RATE_LIMITER_HOME'),

    ]

];
