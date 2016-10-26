<?php

return [
    [
        'class' => 'Swift_SmtpTransport',
        'host' => '',
        'username' => '',
        'password' => '',
        'streamOptions' => [ 'ssl' =>
            [ 'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]
    ]
];
