<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'webapp',
    'name' => 'TTIP GAME OVER',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\SiteTitle'],
    'language' => 'fr',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '234564567878DFkhezref54AaEERMDXXSsqjjeerrdqsdfdvZ88mmlqn5765+65EDDd6+Eze6+dQZs+87zQQD',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'humanized\translation\components\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableDefaultLanguageUrlCode' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['/account'],
            'enableAutoLogin' => true,
            'enableSession' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '45.32.185.124',
                'username' => 'accommodation',
                'password' => '*OAwo11zkdSk5v',
                'port' => '587',
                'encryption' => 'tls',
                'streamOptions' => [ 'ssl' =>
                    [ 'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                                'forceTranslation' => true,
                    //'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                        'mail' => 'mail.php',
                    ],
                ],
                'mail*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                                'forceTranslation' => true,
                    //'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                    ],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    /*
      'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
      ],
     */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
