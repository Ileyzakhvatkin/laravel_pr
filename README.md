# Проект SkillBox Laravel
### Как развернуть проект
1. Скачать Git репозиторий на ваш сервер (локальный сервер вашего ПК) 
2. Установить зависимости composer
```composer install```
3. Установить NPM зависимости
```npm i```
4. Создать файл .env из .env.example и подставив в него следующие параметры
``` DB_HOST= , DB_PORT= , DB_DATABASE= , DB_USERNAME= , DB_PASSWORD= , APP_URL= , MAIL_FROM_ADDRESS= ```
5. Установить Voyager, который создаст все таблицы из миграций
```php artisan voyager:install```
6. Создать администратора системы, который создается как администратор панели Voyager
```php artisan voyager:admin admin@admin.ru --create```
7. Загрузить данные справочников
```php artisan db:seed --class=InitialDataSeeder```
8. Загрузить, по желанию, случайные данные для демонстрации проекта (процесс не быстрый!)
```php artisan db:seed --class=FakeDataSeeder```
9. Запустить сборку скриптов
```npm run dev```

***FrontEnd готов к демонстрации!!!***

### Как настроить панель администратора
Так как база проекта создается при его инсталляции, для настройки работы панели (URI /admin) нужно будет:
1. В разделе Инструменты/BREAD активизировать списки
- Hotels со связью многие ко многим - Facilities 
- Rooms со связью многие ко многим - Facilities, связью многие к одному - Hotel
- Bookings со связями многие к одному с Rooms, Users и Bookings
- Reviews со связями многие к одному с Bookings и Users
2. Там же настроить типы полей в этих списках где нужно image, number, rich big text для редактирования текста с HTML.
3. Для Отелей задать типы в поле type select
```
{
    "options": {
        "hostel": "хостел",
        "apartment": "апартаменты",
        "star1": "одна звезда",
        "star2": "две звезды",
        "star3": "три звезды",
        "star4": "четыре звезды",
        "star5": "пять звезд",
    }
}
```
4. Для комнат задать типы в поле type select
```
{
    "options": {
        "room1": "Одноместный",
        "room2": "Двухместный",
        "room3": "Трехместный",
        "family": "Семейный",
        "married": "Для молодоженов"
   }
}
```
***BackEnd готов к демонстрации!!!***
