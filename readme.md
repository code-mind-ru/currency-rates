# currency-rates

## Установка
* Клонируем репозиторий, корнем сайта является папка public
* Запускаем **composer install**
* Обновляем настройки в .env файле
* Запускаем php artisan migrate
* Обновляем справочник валют и курсов
```bash
php artisan command:importCurrencies
php artisan command:updateCurrencyRatio --currency=all --date='2019-01-01' --dateTo='2019-03-03'
```

Для создания справочника валют необходимо запустить 
```bash
php artisan command:importCurrencies
```
Для массового обновления курсов необходимо запустить
```bash
php artisan command:updateCurrencyRatio --currency=all --date='2019-01-01' --dateTo='2019-03-03'
```

