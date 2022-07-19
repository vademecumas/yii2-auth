<?php

namespace vademecumas\auth\models;

interface AuthApiInterface
{

    public function login($email, $password);

    public function signup($userData);

    public function updateProfile($userData);

    public function getProfile();

    public function confirmEmail($token);

    public function createConfirmationToken($email);

    public function accountStatus();

    public function activateUser($key);

    public function createOrder($packageId, $amount, $appIds, $guestFirstName, $guestLastName, $guestEmail, $guestPhone, $checkoutMode, $profileHash);

    public function getOrder($orderHash);

    public function generateMassKey($packageId, $amount);

    public function updatePassword($userData);

    public function requestPasswordReset($userData);

    public function resetPassword($userData);

    public function getFormDropdowns();

}