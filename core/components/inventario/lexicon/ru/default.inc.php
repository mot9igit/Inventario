<?php
include_once 'setting.inc.php';

$_lang['inventario'] = 'Inventario';
$_lang['inventario_menu_desc'] = 'Компонент для инвентаризации.';
$_lang['inventario_intro_msg'] = 'Вы можете выделять сразу несколько предметов при помощи Shift или Ctrl.';

$_lang['inventario_items'] = 'Объекты';
$_lang['inventario_groups'] = 'Группы объектов';
$_lang['inventario_groups_intro_msg'] = 'Также здесь можно настроить доступ группам пользователей';
$_lang['inventario_clients'] = 'Список клиентов';
$_lang['inventario_clients_intro_msg'] = 'Управление клиентской базой';
$_lang['inventario_acc'] = 'Настройка доступа';
$_lang['inventario_acc_intro_msg'] = 'Настройте соответствие группы пользовтеля группе инвентаря.';
$_lang['inventario_id'] = 'ID';
$_lang['inventario_name'] = 'Название';
$_lang['inventario_client_name'] = 'Ф. И. О.';
$_lang['inventario_photo'] = 'Фото';
$_lang['inventario_count'] = 'Кол-во';
$_lang['inventario_user_group'] = 'Группа пользователей';
$_lang['inventario_group'] = 'Группа';
$_lang['inventario_contact'] = 'Контактное лицо';
$_lang['inventario_email'] = 'Email';
$_lang['inventario_phone'] = 'Телефон';
$_lang['inventario_birthday'] = 'Дата рождения';
$_lang['inventario_number'] = 'Инвентаризационный номер';
$_lang['inventario_description'] = 'Описание';
$_lang['inventario_properties'] = 'Свойства';
$_lang['inventario_createdon'] = 'Создано';
$_lang['inventario_editedon'] = 'Обновлено';
$_lang['inventario_active'] = 'Активно';
$_lang['inventario_actions'] = 'Действия';

$_lang['inventario_item_create'] = 'Создать объект';
$_lang['inventario_item_update'] = 'Изменить объект';
$_lang['inventario_item_enable'] = 'Включить объект';
$_lang['inventario_items_enable'] = 'Включить объекты';
$_lang['inventario_item_disable'] = 'Отключить объект';
$_lang['inventario_items_disable'] = 'Отключить объекты';
$_lang['inventario_item_remove'] = 'Удалить объект';
$_lang['inventario_items_remove'] = 'Удалить объекты';
$_lang['inventario_item_remove_confirm'] = 'Вы уверены, что хотите удалить этот объект?';
$_lang['inventario_items_remove_confirm'] = 'Вы уверены, что хотите удалить эти объекты?';

$_lang['inventario_group_create'] = 'Создать группу';
$_lang['inventario_group_update'] = 'Изменить группу';
$_lang['inventario_group_enable'] = 'Включить группу';
$_lang['inventario_groups_enable'] = 'Включить группы';
$_lang['inventario_group_disable'] = 'Отключить группу';
$_lang['inventario_groups_disable'] = 'Отключить группы';
$_lang['inventario_group_remove'] = 'Удалить группу';
$_lang['inventario_groups_remove'] = 'Удалить группы';
$_lang['inventario_group_remove_confirm'] = 'Вы уверены, что хотите удалить эту группу?';
$_lang['inventario_groups_remove_confirm'] = 'Вы уверены, что хотите удалить эти группы?';

$_lang['inventario_client_create'] = 'Создать клиента';
$_lang['inventario_client_update'] = 'Изменить клиента';
$_lang['inventario_client_enable'] = 'Включить клиента';
$_lang['inventario_clients_enable'] = 'Включить клиента';
$_lang['inventario_client_disable'] = 'Отключить клиента';
$_lang['inventario_clients_disable'] = 'Отключить клиентов';
$_lang['inventario_client_remove'] = 'Удалить клиента';
$_lang['inventario_clients_remove'] = 'Удалить клиентов';
$_lang['inventario_client_remove_confirm'] = 'Вы уверены, что хотите удалить этого клиента?';
$_lang['inventario_clients_remove_confirm'] = 'Вы уверены, что хотите удалить этих клиентов?';

$_lang['inventario_acc_create'] = 'Создать объект';
$_lang['inventario_acc_update'] = 'Изменить объект';
$_lang['inventario_acc_remove'] = 'Удалить объект';
$_lang['inventario_accs_remove'] = 'Удалить объекты';
$_lang['inventario_acc_remove_confirm'] = 'Вы уверены, что хотите удалить этот объект?';
$_lang['inventario_accs_remove_confirm'] = 'Вы уверены, что хотите удалить эти объекты?';

$_lang['inventario_active'] = 'Включено';

$_lang['inventario_item_err_name'] = 'Вы должны указать имя объекта.';
$_lang['inventario_item_err_ae'] = 'Объект с таким именем уже существует.';
$_lang['inventario_item_err_nf'] = 'Объект не найден.';
$_lang['inventario_item_err_ns'] = 'Объект не указан.';
$_lang['inventario_item_err_remove'] = 'Ошибка при удалении объекта.';
$_lang['inventario_item_err_save'] = 'Ошибка при сохранении объекта.';

$_lang['inventario_group_err_name'] = 'Вы должны указать имя группы.';
$_lang['inventario_group_err_ae'] = 'Группа с таким именем уже существует.';
$_lang['inventario_group_err_nf'] = 'Группа не найден.';
$_lang['inventario_group_err_ns'] = 'Группа не указан.';
$_lang['inventario_group_err_remove'] = 'Ошибка при удалении группы.';
$_lang['inventario_group_err_save'] = 'Ошибка при сохранении группы.';

$_lang['inventario_client_err_name'] = 'Вы должны указать имя клиента.';
$_lang['inventario_client_err_ae'] = 'Клиент с таким именем уже существует.';
$_lang['inventario_client_err_nf'] = 'Клиент не найден.';
$_lang['inventario_client_err_ns'] = 'Клиент не указан.';
$_lang['inventario_client_err_remove'] = 'Ошибка при удалении клиента.';
$_lang['inventario_client_err_save'] = 'Ошибка при сохранении клиента.';

$_lang['inventario_acc_err_name'] = 'Вы должны указать группу объекта.';
$_lang['inventario_acc_err_ae'] = 'Объект уже существует.';
$_lang['inventario_acc_err_nf'] = 'Объект не найден.';
$_lang['inventario_acc_err_ns'] = 'Объект не указан.';
$_lang['inventario_acc_err_remove'] = 'Ошибка при удалении объекта.';
$_lang['inventario_acc_err_save'] = 'Ошибка при сохранении объекта.';

$_lang['inventario_grid_search'] = 'Поиск';
$_lang['inventario_grid_actions'] = 'Действия';