<?php

namespace AI\EmailValidator\Rules;


/**
 * Class Rule
 * @package AI\EmailValidator\Rules
 */
abstract class Rule
{
    /**
     * Информация о результате последней проверке по правилу.
     *
     * @var string
     */
    private string $lastCheckingStatus;

    public function __construct()
    {
        $this->lastCheckingStatus = '';
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    public function isValid(string $email): bool
    {
        $result = $this->check($email);
        $this->setLastCheckingStatus($result);

        return $result;
    }

    /**
     * @return string
     */
    public function getLastCheckingStatus(): string
    {
        return $this->lastCheckingStatus;
    }

    /**
     * @param bool $validationResult
     */
    private function setLastCheckingStatus(bool $validationResult): void
    {
        $this->lastCheckingStatus = static::class . ($validationResult ? ' OK' : ' FAIL');
    }

    /**
     * Реализация логики правила.
     *
     * Возвращает true, в случае прохождения проверки по правилу,
     * или false, если проверка не пройдена.
     *
     * @param string $email
     *
     * @return bool
     */
    abstract protected function check(string $email): bool;
}
