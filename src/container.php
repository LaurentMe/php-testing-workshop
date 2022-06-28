<?php

declare(strict_types=1);

use Brammm\TestingWorkshop\Clock\ActualClock;
use Brammm\TestingWorkshop\Clock\Clock;
use Brammm\TestingWorkshop\Discount\Calculator;
use Brammm\TestingWorkshop\Discount\MoreThanFiftyDiscount;
use Brammm\TestingWorkshop\Discount\TrustedCustomerDiscount;
use Brammm\TestingWorkshop\Provider\CustomerProvider;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\MoneyFormatter;

return [
    Connection::class => fn () => DriverManager::getConnection([
        'dbname' => 'testing-workshop',
        'user' => 'root',
        'password' => 'root',
        'host' => 'php-testing-workshop-mysql',
        'driver' => 'pdo_mysql',
    ]),

    MoneyFormatter::class => fn () => new IntlMoneyFormatter(
        new NumberFormatter('nl_BE', NumberFormatter::CURRENCY),
        new ISOCurrencies()
    ),

    Clock::class => fn () => new ActualClock(),

    Calculator::class => fn (CustomerProvider $customerProvider, Clock $clock) => new Calculator(
        new MoreThanFiftyDiscount(),
        new TrustedCustomerDiscount(
            $customerProvider,
            $clock
        ),
    ),
];
