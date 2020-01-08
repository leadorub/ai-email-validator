<?php


namespace AI\EmailValidator\Rules;


/**
 * Class SimpleRegexpRule
 *
 * Реализует правило для пакета AI\EmailValidator.
 * Проверяет переданный email по регулярному выражению.
 *
 * @package AI\EmailValidator
 */
class SimpleRegexpRule extends Rule
{
    /**
     * @param string $email
     *
     * @return bool
     */
    public function check(string $email): bool
    {
        return (bool) preg_match('/^[^@ ]+@([^@. ]+\.)+[^@. ]+$/', $email);
    }
}
