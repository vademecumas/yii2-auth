<?php

namespace vademecumas\auth\models;

interface AgreementApiInterface
{

    public function agreements();

    public function userAgreements($userId);

    public function activeAgreement();

    public function approve($agreementId, $userId, $ip, $status);

    public function latestAccepted($userId);

    public function agreementDetails($id);

}