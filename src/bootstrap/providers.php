<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Foundation / Infrastructure ядра
    |--------------------------------------------------------------------------
    |
    | Базовая инфраструктура: подключение к БД, логирование, время, UnitOfWork.
    | Должны регистрироваться первыми — их используют все остальные.
    |
    */

    Foundation\Doctrine\DoctrineConnector::class,
    App\Shared\Infrastructure\Logging\LoggingConfigurator::class,
    App\Shared\Infrastructure\Clock\ClockRegistrar::class,
    App\Shared\Infrastructure\Persistence\UnitOfWorkProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Шины (Command / Query)
    |--------------------------------------------------------------------------
    |
    | Шины зависят от Dispatcher, LoggingMiddleware, TransactionMiddleware,
    | а те — от UnitOfWork и ExceptionLogger. Регистрируются после
    | инфраструктуры ядра, но до регистраторов карт.
    |
    */

    App\Shared\Infrastructure\Bus\Command\CommandBusProvider::class,
    App\Shared\Infrastructure\Bus\Query\QueryBusProvider::class,
    App\Shared\Infrastructure\Bus\Notification\NotificationBusProvider::class,
    App\Shared\Infrastructure\Bus\Event\EventBusProvider::class,
    App\Shared\Infrastructure\Bus\Process\ProcessBusProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Аутентификация / токены
    |--------------------------------------------------------------------------
    |
    | Sanctum и его обвязка. Не зависят от шин, но зависят от БД и
    | инфраструктуры ядра.
    |
    */

    Laravel\Sanctum\SanctumServiceProvider::class,
    Foundation\Auth\Sanctum\SanctumConnector::class,

    /*
    |--------------------------------------------------------------------------
    | Account: инфраструктура контекста
    |--------------------------------------------------------------------------
    |
    | Композиция домена, диспетчеры событий, порты identity,
    | реализации TokenExpirationInterface, DeviceResolverInterface.
    |
    */

    App\Account\Infrastructure\Persistence\AccountRepositoryBinder::class,
    App\Account\Infrastructure\Dispatching\AccountCommandDispatcher::class,
    App\Account\Infrastructure\Identity\Device\DeviceServiceProvider::class,
    App\Account\Infrastructure\Identity\Token\TokenServiceProvider::class,
    App\Account\Infrastructure\Identity\IdentityEventsMapping::class,

    /*
    |--------------------------------------------------------------------------
    | Инструменты разработки
    |--------------------------------------------------------------------------
    |
    | Telescope — последним, он наблюдает за всем остальным.
    |
    */

    Telescope\TelescopeServiceProvider::class,

];
