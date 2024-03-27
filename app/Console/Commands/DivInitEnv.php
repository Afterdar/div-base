<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DivInitEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'div:init-env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Происходит присвоение значений переменным в .env файле';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->setKeyInEnvironmentFile('APP_NAME', env('APP_NAME', 'laravel'));
        $this->setKeyInEnvironmentFile('APP_ENV', env('APP_ENV', 'prod'));
        $this->setKeyInEnvironmentFile('APP_URL', env('APP_URL', 'http://localhost'));
        $this->setKeyInEnvironmentFile('APP_DEBUG', env('APP_DEBUG', 'false'));

        $this->setKeyInEnvironmentFile('DB_CONNECTION', env('DB_CONNECTION', 'mysql'));
        $this->setKeyInEnvironmentFile('DB_HOST', env('DB_HOST', '127.0.0.1'));
        $this->setKeyInEnvironmentFile('DB_PORT', env('DB_PORT', '3306'));
        $this->setKeyInEnvironmentFile('DB_DATABASE', env('DB_DATABASE', 'laravel'));
        $this->setKeyInEnvironmentFile('DB_USERNAME', env('DB_USERNAME', 'root'));
        $this->setKeyInEnvironmentFile('DB_PASSWORD', env('DB_PASSWORD', ''));

        $this->setKeyInEnvironmentFile('BACKUP_ARCHIVE_PASSWORD', Str::random(64));
    }


    protected function setKeyInEnvironmentFile($key, $default): bool
    {
        $value = $this->ask("Введите желаемое значение для переменной $key:", $default);

        if (! $this->writeNewEnvironmentFileWith($key, $value)) {
            return false;
        }

        return true;
    }

    protected function writeNewEnvironmentFileWith($key, $value): bool
    {
        $replaced = preg_replace(
            "/^$key=[^\n]*/m",
            "$key=$value",
            $input = file_get_contents($this->laravel->environmentFilePath())
        );

        if ($replaced === null) {
            $this->error("Unable to set application $value. No $key variable was found in the .env file.");

            return false;
        }

        file_put_contents($this->laravel->environmentFilePath(), $replaced);

        return true;
    }
}
