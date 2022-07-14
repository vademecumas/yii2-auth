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

    public function updatePassword($userData);

    public function requestPasswordReset($userData);

    public function resetPassword($userData);

    public function getFormDropdowns();

}