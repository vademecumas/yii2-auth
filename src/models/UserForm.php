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
    public $eduemail;
    public $eduemailsdomian;
    public $password;
    public $password2;
    public $currentPassword;
    public $occupation;
    public $phone;
    public $tcNo;
    public $address;
    public $city;
    public $district;
    public $pharmacydiscountrate;
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
    public $gln;
    public $warehouse;
    public $warehouse_branch;
    public $birthday;
    public $avatar;
    public $discount_rate;

    public $healthStaffErr;
    public $firstNameErr;
    public $tcNoErr;
    public $userAgreementErr;
    public $lastNameErr;
    public $emailErr1;
    public $emailErr2;
    public $passwordErr;
    public $passwordErr2;

    const SCENARIO_SIGNUP = 'signup';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_CGM = 'cgm';
    const SCENARIO_ACCOUNT_INFO = 'accountInfo';
    const SCENARIO_CHANGE_PASSWORD = 'changePassword';
    const SCENARIO_RESET_PASSWORD = 'resetPassword';
    const SCENARIO_REQUEST_RESET_PASSWORD = 'requestResetPassword';
    const SCENARIO_RESEND_VERIFICATION_EMAIL = 'resendVerificationEmail';
    const SCENARIO_EDU = 'edu';
    const SCENARIO_TP = 'tp';
    const SCENARIO_SELCUK = 'selcuk';
    const SCENARIO_AKSEL = 'aksel';
    const SCENARIO_AS = 'as';

    public function init()
    {

        if (\Yii::$app->language == 'tr') {
            $this->healthStaffErr = 'Sadece sağlık personelleri içindir';
            $this->userAgreementErr = 'Lütfen kullanıcı sözleşmesini ve gizlillik politikasını kabul edin';
            $this->tcNoErr = 'Lütfen, TC kimlik numaranızı yazın';
            $this->firstNameErr = 'Lütfen adınızı yazın';
            $this->lastNameErr = 'Lütfen soyadınızı yazın';
            $this->emailErr1 = 'Lütfen geçerli bir e-posta adresi yazın';
            $this->emailErr2 = 'Lütfen geçerli bir e-posta adresi yazın!';
            $this->passwordErr = 'Lütfen 6 karakter ya da daha uzun bir şifre yazın';
            $this->passwordErr2 = 'Lütfen şifre tekrar alanını doldurun';
        } else {
            $this->healthStaffErr = 'For health professionals.';
            $this->userAgreementErr = '';
            $this->tcNoErr = '';
            $this->firstNameErr = '';
            $this->lastNameErr = '';
            $this->emailErr1 = '';
            $this->emailErr2 = '';
            $this->passwordErr = '';
            $this->passwordErr2 = '';
        }

    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_LOGIN] = ['email', 'password', 'rememberMe'];

        $scenarios[self::SCENARIO_SIGNUP] = ['firstName', 'lastName', 'email', 'birthday', 'password', 'password2', 'occupation',
            'userAgreement', 'healthStaff', 'areaofspecialization'];

        $scenarios[self::SCENARIO_CHANGE_PASSWORD] = ['password', 'password2', "currentPassword"];

        $scenarios[self::SCENARIO_RESET_PASSWORD] = ['password', 'password2'];

        $scenarios[self::SCENARIO_ACCOUNT_INFO] = ['firstName', 'lastName', 'occupation',
            'phone', 'address', 'city', 'district', 'tcNo', 'birthday', 'avatar', 'discount_rate'];

        $scenarios[self::SCENARIO_CGM] = ['firstName', 'lastName', 'occupation',
            'phone', 'companyName', 'taxOffice', 'taxNo', 'billingCity', 'billingDistrict',
            'billingAddress', 'address', 'city', 'district'];

        $scenarios[self::SCENARIO_REQUEST_RESET_PASSWORD] = ['email'];

        $scenarios[self::SCENARIO_RESEND_VERIFICATION_EMAIL] = ['email'];

        $scenarios[self::SCENARIO_EDU] = ['firstName', 'lastName', 'eduemail', 'eduemailsdomian', 'password', 'password2', 'occupation',
            'userAgreement', 'healthStaff'];

        $scenarios[self::SCENARIO_TP] = ['firstName', 'lastName', 'email', 'password', 'password2', 'occupation',
            'userAgreement', 'healthStaff'];

        $scenarios[self::SCENARIO_SELCUK] = ['email', 'firstName', 'lastName', 'eduemail', 'eduemailsdomian', 'password', 'password2', 'occupation',
            'userAgreement', 'healthStaff', 'districtist', 'city', 'district', 'gln', 'warehouse', 'warehouse_branch'];

        $scenarios[self::SCENARIO_AKSEL] = ['email', 'firstName', 'lastName', 'eduemail', 'eduemailsdomian', 'password', 'password2', 'occupation',
            'userAgreement', 'healthStaff', 'districtist', 'city', 'district', 'gln', 'warehouse', 'warehouse_branch'];

        $scenarios[self::SCENARIO_AS] = ['email', 'firstName', 'lastName', 'eduemail', 'eduemailsdomian', 'password', 'password2', 'occupation',
            'userAgreement', 'healthStaff', 'city', 'district', 'gln'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [

            ['firstName', 'string', 'min' => 3, 'max' => 125, 'tooShort' => 'İsim 3 karakterden kısa olamaz!', 'tooLong' => 'İsim 125 karakterden uzun olamaz!'],
            ['firstName', 'trim'],
            ['firstName', 'required', 'message' => $this->firstNameErr],
            ['firstName', 'match', 'pattern' => '/^[a-zA-ZÇŞĞÜÖİçşğüöı0-9 _-]+$/', 'message' => 'Sadece karakter ve boşluk'],

            ['lastName', 'string', 'min' => 2, 'max' => 125, 'tooShort' => 'Soyad 2 karakterden kısa olamaz!', 'tooLong' => 'Soyad 125 karakterden uzun olamaz!'],
            ['lastName', 'trim'],
            ['lastName', 'required', 'message' => $this->lastNameErr],
            ['lastName', 'match', 'pattern' => '/^[a-zA-ZÇŞĞÜÖİçşğüöı0-9 _-]+$/', 'message' => 'Sadece karakter ve boşluk'],

            ['email', 'trim'],
            ['email', 'required', 'message' => $this->emailErr1],
            ['email', 'email', 'message' => $this->emailErr2],
            ['email', 'string', 'max' => 255],

            ['eduemailsdomian', 'trim'],
            ['eduemailsdomian', 'required', 'message' => 'Lütfen geçerli bir e-posta adresi yazın'],
            ['eduemailsdomian', 'string', 'min' => 3, 'max' => 255, 'tooShort' => 'İsim 3 karakterden kısa olamaz!', 'tooLong' => 'İsim 125 karakterden uzun olamaz!'],

            ['eduemail', 'trim'],
            ['eduemail', 'required', 'message' => 'Lütfen geçerli bir e-posta adresi yazın'],
            ['eduemail', 'string', 'min' => 3, 'max' => 255, 'tooShort' => 'İsim 3 karakterden kısa olamaz!', 'tooLong' => 'İsim 125 karakterden uzun olamaz!'],


            ['password', 'required', 'message' => $this->passwordErr],
            ['password2', 'required', 'message' => $this->passwordErr2],
            ['password', 'string', 'min' => 6, 'max' => 256, 'tooShort' => 'Şifre 6 karakterden kısa olamaz!', 'tooLong' => 'Şifre 256 karakterden uzun olamaz!'],
            ['password2', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "Şifre uyumlu değil"],

            ['currentPassword', 'required', 'message' => 'Lütfen mevcut şifrenizi yazın'],

            ['occupation', 'required', 'message' => ''],

            ['tcNo', 'safe', 'message' => $this->tcNoErr],

            ['gln', 'integer'],
            ['gln', 'required', 'message' => 'Lütfen GLN numaranızı yazın!'],
            ['gln', 'string', 'min' => 13, 'max' => 13, 'tooShort' => 'GLN 13 karakterden kısa olamaz!', 'tooLong' => 'GLN 13 karakterden uzun olamaz!'],

            ['birthday', 'safe'],

            ['billingCity', 'required', 'message' => ''],
            ['billingDistrict', 'required', 'message' => ''],
            ['billingAddress', 'required', 'message' => ''],
            ['companyName', 'required', 'message' => ''],
            ['taxNo', 'required', 'message' => ''],
            ['taxOffice', 'required', 'message' => ''],
            ['districtist', 'required', 'message' => ''],
            ['city', 'safe', 'message' => 'Şehir Seçin'],
            ['district', 'safe', 'message' => 'İlçe Seçin'],

            ['warehouse', 'required', 'message' => 'Ecza Deposu Seçin'],
            ['warehouse_branch', 'required', 'message' => 'Bölge Seçin'],

//            ['healthStaff', 'required', 'message' => $this->healthStaffErr],
            ['userAgreement', 'required', 'message' => $this->userAgreementErr],

            ['avatar', 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 512000, 'tooBig' => 'Profil fotoğrafı 500KB den büyük olamaz!'],

            ['discount_rate', 'number']

        ];

        if ($this->scenario == self::SCENARIO_SIGNUP) {
            $rules[] = ['email', 'unique', 'targetAttribute' => 'vdmcid_user_email', 'targetClass' => '\vademecumas\auth\models\User', 'message' => 'Bu e-posta adresi sistemde kayıtlı değil'];
        }

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
            'eduemail' => 'E-Posta',
            'birthday' => 'Doğum Tarihi',
            'eduemailsdomian' => 'E-Posta',
            'password' => 'Şifre',
            'password2' => 'Şifre Tekrar',
            'occupation' => 'Meslek',
            'address' => 'Adres',
            'phone' => 'Telefon',
            'city' => 'İşyeri İl',
            'district' => 'İşyeri İlçe',
            'pharmacydiscountrate' => 'Eczacı İskonto Oranı',
            'areaofspecialization' => 'Uzmanlık Alanı',

        ];
    }
}
