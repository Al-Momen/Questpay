<?php

namespace App\Constants;

class Status{

    const ENABLE  = 1;
    const DISABLE = 0;

    const YES = 1;
    const NO  = 0;

    const SURVEY_ENABLE  = 1;
    const SURVEY_DISABLE = 0;

    const PLAN_ENABLE  = 1;
    const PLAN_DISABLE = 0;

    const VERIFIED   = 1;
    const UNVERIFIED = 0;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS  = 1;
    const PAYMENT_PENDING  = 2;
    const PAYMENT_REJECT   = 3;

    CONST TICKET_OPEN   = 0;
    CONST TICKET_ANSWER = 1;
    CONST TICKET_REPLY  = 2;
    CONST TICKET_CLOSE  = 3;

    CONST PRIORITY_LOW    = 1;
    CONST PRIORITY_MEDIUM = 2;
    CONST PRIORITY_HIGH   = 3;

    const USER_ACTIVE = 1;
    const USER_BAN    = 0;

    const KYC_UNVERIFIED = 0;
    const KYC_VERIFIED   = 1;
    const KYC_PENDING    = 2;

    const ROLE_TYPE_ADMIN = 1;
    const ROLE_TYPE_USER  = 2;

    const REG_COMPLETED = 1;
    const REG_PENDING   = 0;

    CONST SYSTEM_LINK   = 1;
    CONST EXTERNAL_LINK = 2;
    CONST PAGE_LINK     = 3;

}
