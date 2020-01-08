# Проверка email на валидность без отправки письма-подтверждения.

## Как пользоваться

### 1. Проверка email на валидность 


```
    $email = 'test@test.com';

    // Список правил, по которым будем проверять email
    $rules = [
        new \AI\EmailValidator\Rules\SimpleRegexpRule(),
        new \AI\EmailValidator\Rules\MxRecordRule(),
    ];

    // Создаём класс для проверки на валидность
    $validator = new \AI\EmailValidator\EmailValidator($rules);

    // Проверяем
    $result = $validator->isCorrectEmail($email)

    if ($result) {
       // проверка пройдена успешно
    } else {     
        // проверка не пройдена
    }

    // Можно вывести отладочную информацию, какое правило и как отработало
    var_dump($validator->getResultInfo()); 
```

### 2. Создание своих правил


```
    namespace MyApp\CustomEmailValidatorRules;

    // Создаём класс наследующий от абстрактного класса правил
    class PhpFilterRule extends \AI\EmailValidator\Rules\Rule
    {
        /**
         * Реализация логики правила.
         *
         * Возвратить true, в случае успешного прохождения проверки по правилу,
         * или false, если проверка не пройдена.
         *
         * @param string $email
         *
         * @return bool
         */
        public function check(string $email): bool
        {
            return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
        }
    }
```

### 3. Добавление своих правил


```
    $rules = [
        new \AI\EmailValidator\Rules\SimpleRegexpRule(),
        new \AI\EmailValidator\Rules\MxRecordRule(),

        // Добавляем свои правила в список правил.
        new \MyApp\CustomEmailValidatorRules\PhpFilterRule(),
        // ...
    ];
```

Далее использование ничем не отличается от описанного в п. 1.