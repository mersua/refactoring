# Refactoring

Version:

    PHP 7.4
    Composer 1.10

To set up project envs:

    copy .env.sample to .env
    change EXCHANGE_RATES_ACCESS_KEY to actual value (please, take it from https://exchangeratesapi.io/)
    rest envs vars have already defined

To run CLI app:

    composer install --no-dev
    php app.php input.txt

To run CLI tests:

    composer install
    ./vendor/bin/phpunit tests/