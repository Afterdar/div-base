# Проект "Laravel 10 base"

Приложение с базовыми настройками для админки laravel на основе filament-3

<hr>

1. ## Зависимости

    - **[PHP v8.1](https://www.php.net/releases/8.1/ru.php)**
    - MySQL v8.0
    - **[Laravel v^10](https://laravel.com/docs/10.x/)**
    - **[barryvdh/laravel-debugbar v^3.9](https://github.com/barryvdh/laravel-debugbar)** - дебаг бар для разработки
    - **[Laravel-Lang/lang v^13.2](https://github.com/Laravel-Lang/lang)** - библиотека для создания lang файлов, в
      частности перевода на русский язык
    - **[reliese/laravel v^1.2](https://github.com/reliese/laravel)** - генератор моделей
    - **[filament/filament v^3.2](https://filamentphp.com/docs/3.x/)** - основная админка
    - **[bezhansalleh/filament-shield v^3.0](https://filamentphp.com/plugins/bezhansalleh-shield)** - ролевая система
      для
      доступов к филамент\ресурсам
    - **[darkaonline/l5-swagger v^8.5](https://github.com/DarkaOnLine/L5-Swagger)** - разработка документации к api
    - **[awcodes/filament-curator](https://github.com/awcodes/filament-curator)** - менеджер файлов
    - **[awcodes/filament-sticky-header](https://github.com/awcodes/filament-sticky-header)** - позволяет закрепить
      заголовок филаментовских ресурсов\страниц к верхней части браузера
    - **[filipfonal/filament-log-manager](https://github.com/filipfonal/filament-log-manager)** - доступ к логам laravel
      через интерфейс филамента
    - **[pxlrbt/filament-environment-indicator](https://github.com/pxlrbt/filament-environment-indicator)** -
      визуализатор
      окружения в админке
    - **[rickdbcn/filament-email](https://github.com/RickDBCN/filament-email)** - система логирования писем
    - **[shuvroroy/filament-spatie-laravel-backup](https://github.com/shuvroroy/filament-spatie-laravel-backup)** -
      создание
      и выгрузка бэкапов БД
    - **[shuvroroy/filament-spatie-laravel-health](https://github.com/shuvroroy/filament-spatie-laravel-health)** -
      чекер
      работоспособности приложения

1. ## Инициализация через makefile
   Команда поможет быстрее инициализировать приложение при его развёртке. Для ознакомления можно открыть ``makefile``
    ```bash 
    make install
    ```

1. ## Настройки
    1. ### Файл .env
       В файле <code>.env</code> надо установить параметры:
        ```
        APP_NAME=
        APP_URL=
        DB_DATABASE=
        FILESYSTEM_DISK=public
        ```
    1. ### Настройка хранения файлов в публичном доступе
        ```bash 
        php artisan storage:link
        ```
    1. ### Настройка админки Filament3
       Надо создать пользователя - администратора
        ```bash 
        php artisan make:filament-user
        ```
    1. ### Настройка ролей
       Указываем кто является администратором
        ```bash 
        php artisan shield:super-admin --user=1
        ```
       Генерируем permission'ы
        ```bash 
        php artisan shield:generate --all --option=permissions
        ```

1. ## Крон команды
   Приложение может автоматически создавать бэкапы. Надо запустить laravel scheduler

1. ## Разработка
    1. ### Создание модели
       Создаётся модель по таблице в БД
        ```bash 
        php artisan code:models --table=name
        ```
    1. ### Создание filament-resource'а
       Создание филамент-ресурсов по модели элокентовской
        ```bash 
        php artisan make:filament-resource ModelName --generate
        ```
