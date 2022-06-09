## Yii2 Auth

#### Yii2 Auth is a build of yii2 framework with registration & login actions. Built on Bootstrap 4.

#### Table of contents

- [About](#about)
- [Features](#features)
- [Installation](#installation)
- [API Request & Response Examples](#api-request--response-examples)

### About

There will be both db and api support in the future. For now, only api is available.
You should create an api client class which implements `vademecumas\auth\components\AuthApiInterface` methods

You can find samle api responses below.

### Features

- [x] Register
- [x] Login
- [x] Email Verification
- [x] Reset Password
- [ ] User Profiles
- [ ] User Agreement
- [ ] User Roles and Permissions
- [ ] Social Authentication
- [ ] Captcha Protection

### Installation

1. Install via composer

```
composer require vademecumas/yii2-auth
```

2. Common Configration

```
    'bootstrap' => ['auth'],
    'modules' => [
        'auth' => [
            'class' => 'vademecumas\auth\Auth',
            'enableRegister' => true,
            'shouldVerifyEmail' => false,
            'dataSource'=>vademecumas\auth\Auth::DATA_SOURCE_API
        ],
    ],
```

3. App Configration (backend or frontend)

```
    'as access' => [
        'class' => 'vademecumas\auth\components\AccessControl',
        'forceLogin' => true,
        'allowedUrls' => [
            '/auth/account/login',
            '/auth/account/register',
            '/auth/account/request-password-reset',
            '/auth/account/password-reset',
            '/auth/account/resend-verification-email',
            '/auth/account/verify-email',
        ],
    ],

    'components' => [
        'user' => [
            'loginUrl'=>array('auth/account/login'),
        ],
        'i18n' => [
            'translations' => [
                'auth*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'auth' => 'auth.php',
                    ],
                ],
            ],
        ],    
    ],    
```

4. Init Extension

run `php yii auth/init {root directory of web project}`  to publish views, messages, configs and email files to app's
root directory

5. Up Migrations

run `php yii migrate`

6. Update .gitignore

add following file to `{root directory of web project}/config/.gitignore`

`auth-local.php`

7. Update Api Credentials

you should change api credentials at `{root directory of web project}/config/auth.php` like appToken ,appId etc.

8. Visit Login Page

You can access login page at `{project url}/auth/account/login`

### API Request & Response Examples

#### 1. Logın

##### Request :

```
{
  "email": "sampleuser@example.com.tr",
  "password": "******",
  "rememberme": 1
}
```

##### Response :

```
{
  "status": true,
  "data": {
    "user": {
      "id": 32514,
      "email": "sampleuser@example.com.tr",
      "authToken": "TYHlnP9XMh_XzeNAQtQPKxPxmaAx8FgX",
      "tokenExpiresAt": 1972734057,
      "accountStatus": {
        "status": false,
        "description": "waiting_moderation",
        "code": 7
      },
      "key": null,
      "package": null,
      "modules": []
    }
  }
}
```

#### 2. Register

##### Request :

```
{
  "email": "sampleuser@example.com.tr",
  "password": "*****",
  "birthday": false,
  "userData": {
    "firstName": "sampleuser",
    "lastName": "sampleuser",
    "occupationId": "4",
    "areaOfSpecializationId": null,
    "cityId": null,
    "districtId": null,
    "address": null,
    "tcNo": null,
    "dateOfBirth": null,
    "billingAddress": null,
    "billingCityId": null,
    "billingDistrictId": null,
    "companyName": null,
    "taxNo": null,
    "taxOffice": null,
    "phone": null,
    "identifier": null,
    "branch": null
  },
  "appIds": "2",
  "shouldVerifyEmail": 1
}

```

##### Response :

```
{
  "status": true,
  "data": {
    "user": {
      "id": 32517,
      "email": "sampleuser@example.com.tr",
      "accountStatus": {
        "status": false,
        "description": "email_unconfirmend",
        "code": 6
      },
      "modules": [],
      "userData": {
        "firstName": "sampleuser",
        "lastName": "sampleuser",
        "lastLoggedinAt": null,
        "dateOfBirth": null,
        "tcNo": null,
        "address": null,
        "billingAddress": null,
        "companyName": null,
        "taxNo": null,
        "taxOffice": null,
        "phone": null,
        "identifier": null,
        "branch": null,
        "academicStaff": null,
        "pharmacyDiscountRate": null,
        "city": null,
        "district": null,
        "billingCity": null,
        "billingDistrict": null,
        "areaOfSpecialization": null,
        "occupation": {
          "id": 4,
          "name": "Diş Hekimi"
        },
        "licenseSchool": null,
        "specializationSchool": null,
        "specializationHospital": null
      },
      "emailConfirmationToken": "273770ab7ecda6fe8672d103792be460"
    }
  }
}
```

#### 3. Profile

##### Request :

```
{
  "email": "sampleuser@example.com.tr",
}
```

##### Response :

```
{
  "status": true,
  "data": {
    "user": {
      "id": 32517,
      "email": "sampleuser@example.com.tr",
      "accountStatus": {
        "status": false,
        "description": "email_unconfirmend",
        "code": 6
      },
      "modules": [],
      "userData": {
        "firstName": "sampleuser",
        "lastName": "sampleuser",
        "lastLoggedinAt": 1654523617,
        "dateOfBirth": null,
        "tcNo": null,
        "address": null,
        "billingAddress": null,
        "companyName": null,
        "taxNo": null,
        "taxOffice": null,
        "phone": null,
        "identifier": null,
        "branch": null,
        "academicStaff": null,
        "city": null,
        "district": null,
        "billingCity": null,
        "billingDistrict": null,
        "areaOfSpecialization": null,
        "occupation": {
          "id": 4,
          "name": "Diş Hekimi"
        },
        "licenseSchool": null,
        "specializationSchool": null,
        "specializationHospital": null
      },
      "emailConfirmationToken": "273770ab7ecda6fe8672d103792be460"
    }
  }
}
```

#### 4. Request Password Reset

##### Request :

```
{
  "email": "sampleuser@example.com.tr",
}
```

##### Response :

```
{
  "status": true,
  "data": {
    "hash": "havKshA70LFI55nOFiim4g-pDwKyiv-f_1654523778"
  }
}
```

#### 5. Reset Password

##### Request :

```
{
  "hash": "AOA3DbqTEVsnY77glrr87WUY2bgEkS4A_1654523885",
  "password": "samplepassword",
  "password2": "samplepassword"
}
```

##### Response :

```
{
  "status": true,
  "data": {
    "user": {
      "id": 32517,
      "email": "sampleuser@example.com.tr",
      "accountStatus": {
        "status": false,
        "description": "email_unconfirmend",
        "code": 6
      },
      "emailConfirmationToken": "273770ab7ecda6fe8672d103792be460"
    }
  }
}
```

#### 6. Confirm Email

##### Request :

```
{
  "token": "AOA3DbqTEVsnY77glrr87WUY2bgEkS4A_1654523885",
}
```

##### Response :

```
{
  "status": true,
  "data": {
    "user": {
      "id": 32518,
      "email": "sampleuser@example.com.tr",
      "accountStatus": {
        "status": true,
        "description": "email_confirmed",
        "code": 10
      }
    }
  }
}
```

#### 7. Create Email Confirmation Token

##### Request :

```
{
  "email": "sampleuser@example.com.tr",
}
```

##### Response :

```
{
  "status": true,
  "data": {
    "user": {
      "id": 32518,
      "email": "sampleuser@example.com.tr",
      "accountStatus": {
        "status": false,
        "description": "email_unconfirmend",
        "code": 6
      },
      "emailConfirmationToken": "6947f3f692e37de2ffb0e51b8d31eb38"
    }
  }
}
```
