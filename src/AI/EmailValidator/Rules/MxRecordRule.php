<?php

namespace AI\EmailValidator\Rules;


/**
 * Class MxRecordRule
 *
 * Реализует правило для пакета AI\EmailValidator.
 * Проверяет наличие DNS MX-записи у домена от переданного email-а.
 *
 * @package AI\EmailValidator
 */
class MxRecordRule extends Rule
{
    /**
     * @param string $email
     *
     * @return bool
     */
    protected function check(string $email): bool
    {
        $arEmail = explode('@', $email);
        $host = array_pop($arEmail);

        if ($host == '') {
            return false;
        }

        return checkdnsrr($host,'MX');
    }
}
