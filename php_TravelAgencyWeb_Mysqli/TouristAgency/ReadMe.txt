Необходимо добавить в базу данных две роли: admin и customer.
Одного из пользователей необходимо сделать администратором, добавив его в роль admin.

INSERT INTO roles (role) VALUES ('admin'), ('customer');

запускаем index, регистрируем пользователей и делее: SELECT id FROM roles WHERE role = 'admin';
как покажет запрос  :  id роли admin равен 1

UPDATE users SET roleid = (SELECT id FROM roles WHERE role = 'admin') WHERE id = 1;
или, так как нам известно, что id роли admin равен 1, то:
UPDATE users SET roleid = 1 WHERE id = 1;
или же руками в таблице пользователя меняем цифру столбца роли с 2 на 1 , и далее apply