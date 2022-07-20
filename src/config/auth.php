<?php

return [
    'components' => [
        'authApi' => [
            'class' => 'vademecumas\auth\components\AuthApi',
            'apiUrl' => '',
            'appToken' => '',
            'appIds' => ''
        ],
        'agreementApi' => [
            'class' => 'common\components\AgreementApi',
            'url' => '',
            'appId' => null,
            'partnerId' => null,
            'username' => '',
            'password' => '',
        ],
    ],
];
