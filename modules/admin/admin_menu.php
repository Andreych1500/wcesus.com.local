<?php
// Custom menu

// Menu
$admin_menu = array(
    'ua' => array(
        0 => array(
            'name'     => 'WCES',
            'icon'     => 'content',
            'sections' => array(
                'Profiles' => array(
                    'Inventory'           => '/admin/apply/',
                    'Educational History' => '/admin/apply/educational-history/',
                    'Applicant copy'      => '/admin/apply/copy-agency/',
                    'Cab applicant copy'  => '/admin/apply/cab-copy/'
                ),
                'For-students' => array(
                    'Country' => '/admin/for-students/'
                )
            )
        ),
        1 => array(
            'name'     => 'Настройки',
            'icon'     => 'settings',
            'sections' => array(
                'Модулі'              => array(
                    'Головний модуль' => '/admin/setting/main-module/',
                    'Модулі'          => '/admin/setting/modules-pages/',
                ),
                'Користувачі'         => array(
                    'Список'          => '/admin/setting/users-list/',
                    'Створити нового' => '/admin/setting/users-list/?add=ok',
                ),
                'Почтові події'       => array(
                    'Тип шаблону'      => '/admin/setting/type-mails/',
                    'Настройка листів' => '/admin/setting/setting-mails/',
                ),
                'Резервне копіювання' => array(
                    'Запуск Backup'       => '/admin/setting/backup/',
                    'Налаштування Backup' => '/admin/setting/backup-setting/',
                ),
                'Кеш файлів'          => array(
                    'Поновлення кешу' => '/admin/setting/update-files/',
                ),
                'Інтерфейс'           => array(
                    'Персональні настройки' => '/admin/setting/personal-interface/',
                ),
                'Переклад сайту'      => array(
                    'Переклад слів' => '/admin/setting/lang-words/',
                ),
                'Таблиці баз даних'   => array(
                    'Експорт' => '/admin/setting/export-db/',
                    'Імпорт'  => '/admin/setting/import-db/',
                ),
                'Контроль PHP'        => array(
                    'PhpInfo' => '/admin/setting/php-info/',
                ),
            )
        ),
    ),
    'ru' => array(
        0 => array(
            'name'     => 'WCES',
            'icon'     => 'content',
            'sections' => array(
                'Profiles' => array(
                    'Inventory'           => '/admin/apply/',
                    'Educational History' => '/admin/apply/educational-history/',
                    'Applicant copy'      => '/admin/apply/copy-agency/',
                    'Cab applicant copy'  => '/admin/apply/cab-copy/'
                ),
                'For-students' => array(
                    'Country' => '/admin/for-students/'
                )
            )
        ),
        1 => array(
            'name'     => 'Настройки',
            'icon'     => 'settings',
            'sections' => array(
                'Модули'                => array(
                    'Главный модуль' => '/admin/setting/main-module/',
                    'Модули'         => '/admin/setting/modules-pages/',
                ),
                'Пользователи'          => array(
                    'Список'         => '/admin/setting/users-list/',
                    'Создать нового' => '/admin/setting/users-list/?add=ok',
                ),
                'Почтовые события'      => array(
                    'Тип шаблона'     => '/admin/setting/type-mails/',
                    'Настройка писем' => '/admin/setting/setting-mails/',
                ),
                'Резервное копирование' => array(
                    'Запуск Backup'    => '/admin/setting/backup/',
                    'Настройка Backup' => '/admin/setting/backup-setting/',
                ),
                'Кэш файлов'            => array(
                    'Обновления кэша' => '/admin/setting/update-files/',
                ),
                'Интерфейс'             => array(
                    'Персональные настройки' => '/admin/setting/personal-interface/',
                ),
                'Перевод сайта'         => array(
                    'Перевод слов' => '/admin/setting/lang-words/',
                ),
                'Таблицы баз данных'    => array(
                    'Экспорт' => '/admin/setting/export-db/',
                    'Импорт'  => '/admin/setting/import-db/',
                ),
                'Контроль PHP'          => array(
                    'PhpInfo' => '/admin/setting/php-info/',
                ),
            )
        ),
    ),
    'en' => array(
        0 => array(
            'name'     => 'WCES',
            'icon'     => 'content',
            'sections' => array(
                'Profiles' => array(
                    'Inventory'           => '/admin/apply/',
                    'Educational History' => '/admin/apply/educational-history/',
                    'Applicant copy'      => '/admin/apply/copy-agency/',
                    'Cab applicant copy'  => '/admin/apply/cab-copy/'
                ),
                'For-students' => array(
                    'Country' => '/admin/for-students/'
                )
            )
        ),
        1 => array(
            'name'     => 'Settings',
            'icon'     => 'settings',
            'sections' => array(
                'Modules'          => array(
                    'Main module' => '/admin/setting/main-module/',
                    'Modules'     => '/admin/setting/modules-pages/',
                ),
                'Users'            => array(
                    'List'            => '/admin/setting/users-list/',
                    'Create new user' => '/admin/setting/users-list/?add=ok',
                ),
                'Post events'      => array(
                    'Template type' => '/admin/setting/type-mails/',
                    'Mail setting'  => '/admin/setting/setting-mails/',
                ),
                'Backup'           => array(
                    'Start Backup'   => '/admin/setting/backup/',
                    'Setting Backup' => '/admin/setting/backup-setting/',
                ),
                'File cache'       => array(
                    'Cache updates' => '/admin/setting/update-files/',
                ),
                'Interface'        => array(
                    'Personal settings' => '/admin/setting/personal-interface/',
                ),
                'Translation site' => array(
                    'Words translation' => '/admin/setting/lang-words/',
                ),
                'Database Tables'  => array(
                    'Export' => '/admin/setting/export-db/',
                    'Import' => '/admin/setting/import-db/',
                ),
                'Control PHP'      => array(
                    'PhpInfo' => '/admin/setting/php-info/',
                ),
            )
        ),
    ),
);