**Описание**

Для разработки был использован фреймворк Laravel.
Данный фреймворк был выбран по следующим причинам:
* Содержит функционал для запуска тестов
* Имеет четкую структуру папок
* Позволяет использовать сторонние библиотеки

**Разворачивание**

1. Запустите команды:

``git clone current_repo`` - Склонируйте репозиторий

``cd cloned_repo``

``curl -sS https://getcomposer.org/installer | php``

``php composer.phar install``

``cp .env.example .env``

2. Создайте новую бд.

3. Произвести замену значений основных констант в .env и там же настроить почту:

DB_HOST=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

3. Запустите команды:

``chmod -R 777 storage app``

``php artisan key:generate``

``php artisan migrate``

``php artisan db:seed --class=UsersSeeder``

``php artisan config:cache``

**API**

``api/login`` - POST запрос на получение токена

``api/register`` - POST запрос для регистрации пользователя. Параметры для передачи: email, name, password, c_password

``api/send_message`` - POST запрос отправки сообщения. В заголовке необходимо передавать токен пользователя вида: Authorization: Bearer ``token``. Параметры для передачи: from, to, message