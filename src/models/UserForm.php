<?php

namespace vademecumas\auth\models;

use Yii;
use yii\base\Model;


/**
 * User form
 */
class UserForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;
    public $rememberMe;
    public $password;
    public $password2;
    public $currentPassword;
    public $occupation;
    public $phone;
    public $tcNo;
    public $address;
    public $city;
    public $district;
    public $companyName;
    public $taxOffice;
    public $taxNo;
    public $billingCity;
    public $billingDistrict;
    public $billingAddress;
    public $areaofspecialization;
    public $healthStaff;
    public $userAgreement;
    public $districtist;
    public $avatar;
    public $step;

    const SCENARIO_SIGNUP = 'signup';
    const SCENARIO_SIGNUP_WITH_PHONE = 'signup-with-phone';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_ACCOUNT_INFO = 'accountInfo';
    const SCENARIO_CHANGE_PASSWORD = 'changePassword';
    const SCENARIO_RESET_PASSWORD = 'resetPassword';
    const SCENARIO_REQUEST_RESET_PASSWORD = 'requestResetPassword';
    const SCENARIO_RESEND_VERIFICATION_EMAIL = 'resendVerificationEmail';

    const STEP_REGISTER = 1;
    const STEP_SUBSCRIBE = 2;


    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_LOGIN] = ['email', 'password', 'rememberMe'];

        $scenarios[self::SCENARIO_SIGNUP] = ['firstName', 'lastName', 'email', 'birthday', 'password', 'password2', 'occupation',
            'userAgreement', 'healthStaff', 'areaofspecialization'];

        $scenarios[self::SCENARIO_SIGNUP_WITH_PHONE] = ['firstName', 'lastName', 'email', 'phone', 'password', 'step'];

        $scenarios[self::SCENARIO_CHANGE_PASSWORD] = ['password', 'password2', "currentPassword"];

        $scenarios[self::SCENARIO_RESET_PASSWORD] = ['password', 'password2'];

        $scenarios[self::SCENARIO_ACCOUNT_INFO] = ['firstName', 'lastName', 'occupation',
            'phone', 'address', 'city', 'district', 'tcNo', 'birthday', 'avatar'];

        $scenarios[self::SCENARIO_REQUEST_RESET_PASSWORD] = ['email'];

        $scenarios[self::SCENARIO_RESEND_VERIFICATION_EMAIL] = ['email'];


        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [

            ['firstName', 'string', 'min' => 3, 'max' => 125, 'tooShort' => 'İsim 3 karakterden kısa olamaz!', 'tooLong' => 'İsim 125 karakterden uzun olamaz!'],
            ['lastName', 'string', 'min' => 2, 'max' => 125, 'tooShort' => 'Soyad 2 karakterden kısa olamaz!', 'tooLong' => 'Soyad 125 karakterden uzun olamaz!'],
            [['firstName', 'lastName'], 'match', 'pattern' => '/^[a-zA-ZÇŞĞÜÖİçşğüöı ]+$/'],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['password', 'string', 'length' => [6, 255]],
            ['password2', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false],

            ['step', 'integer'],
            ['avatar', 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 512000, 'tooBig' => 'Profil fotoğrafı 500KB den büyük olamaz!'],

            [['firstName', 'lastName', 'email', 'password2', 'password', 'currentPassword', 'occupation', 'phone', 'healthStaff', 'userAgreement', 'billingCity', 'billingDistrict', 'billingAddress', 'companyName', 'taxNo', 'taxOffice', 'districtist'], 'required'],
            [['firstName', 'lastName', 'email', 'phone'], 'trim'],
            [['city', 'district', 'step', 'tcNo'], 'safe']

        ];

        return $rules;
    }


    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {

            if ($this->avatar) {
                $fileName = md5(microtime()) . '.' . $this->avatar->extension;
                $this->avatar->saveAs('images/user/' . $fileName);
                $update = User::findOne(Yii::$app->user->id);
                $update->avatar = $fileName;
                $update->save();

                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'firstName' => 'Ad',
            'lastName' => 'Soyad',
            'email' => 'E-Posta',
            'password' => 'Şifre',
            'password2' => 'Şifre Tekrar',
            'occupation' => 'Meslek',
            'address' => 'Adres',
            'phone' => 'Telefon',
            'city' => 'İşyeri İl',
            'district' => 'İşyeri İlçe',
            'areaofspecialization' => 'Uzmanlık Alanı',

        ];
    }
}
