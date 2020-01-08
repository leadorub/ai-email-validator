<?php


namespace AI\EmailValidator;

use AI\EmailValidator\Rules\Rule;
use AI\EmailValidator\Rules\SimpleRegexpRule;
use InvalidArgumentException;

/**
 * Class EmailValidator
 *
 * Предназначен для проверки email-ов на валидность без отправки письма-подтверждения.
 * Проверяет правилами, с которыми инициализирован.
 * Email считается валидным, если он успешно прошёл проверку по всем правилам.
 *
 * Все правила должны быть потомками от абстрактного класса
 * AI\EmailValidator\Rules\Rule и реализовывать метод check.
 * Метод check должен возвращать true, в случае прохождения проверки по правилу,
 * или false, если проверка не пройдена.
 *
 * Пользователь может опрелелять собственные правила,
 * для этого они должны удовлетворять вышеописанным условиям.
 *
 * В базовом пакете реализовано два правила:
 * Проверка простым регулярным выражением - AI\EmailValidator\Rules\SimpleRegexpRule
 * Проверка наличия DNS MX-записи у домена от email-а - AI\EmailValidator\Rules\MxRecordRule
 *
 * Чтобы правило применялось для проверки,
 * достаточно передать его в списке правил при создании объекта.
 *
 * @package AI\EmailValidator
 */
class EmailValidator
{
    /**
     * Правила для проверки.
     * Правила должны быть потомками от абстрактного класса Rules\Rule.
     *
     * @var array
     */
    private array $rules;

    /**
     * Информация о том, какое правило как отработало.
     * Массив содержит строки вида:
     * <RuleClassName> OK|FAIL
     *
     * @var array
     */
    private array $resultInfo;

    /**
     * EmailValidator constructor.
     *
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->rules = count($rules) ? $rules : [new SimpleRegexpRule()];
        $this->checkRules();
        $this->resultInfo = [];
    }

    /**
     * Проверяет $email по правилам, с которыми инициализирован объект.
     * $email считается валидным, если он успешно прошёл проверку по всем правилам.
     *
     * @param string $email
     *
     * @return bool
     */
    public function check(string $email): bool
    {
        $result = true;
        $this->resultInfo = [];

        /**
         * @var Rule $rule
         */
        foreach ($this->rules as $rule) {
            $result = $rule->isValid($email) && $result;
            $this->resultInfo[] = $rule->getLastCheckingStatus();
        }

        return $result;
    }

    /**
     * Возвращает информацю о том, какое правило как отработало.
     *
     * @return array
     */
    public function getResultInfo(): array
    {
        return $this->resultInfo;
    }

    /**
     * Проверяет, являются ли правила потомками от Rules\Rule.
     * Если какое-то из правил не удовлетворяет тебованиям, выдаёт исключение.
     *
     * @throws InvalidArgumentException
     */
    private function checkRules(): void
    {
        foreach ($this->rules as $rule) {
            if (!($rule instanceof Rule)) {
                throw new InvalidArgumentException(
                    "Элементы массива \$rules должны быть потомками класса " .
                    Rule::class
                );
            }
        }
    }
}
