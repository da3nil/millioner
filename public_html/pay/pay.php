<?php
session_start();
require('../web/mlm/php-includes/connect.php');

// Отклоняем запросы с IP-адресов, которые не принадлежат Payeer
if (!in_array($_SERVER['REMOTE_AD DR'], array('185.71.65.92', '185.71.65.189',
    '149.202.17.210'))) return;
if (isset($_POST['m_operation_id']) && isset($_POST['m_sign']))
{
    $m_key = 'IC7PNDaOEjVL03b6';
    // Формируем массив для генерации подписи
    $arHash = array(
        $_POST['m_operation_id'],
        $_POST['m_operation_ps'],
        $_POST['m_operation_date'],
        $_POST['m_operation_pay_date'],
        $_POST['m_shop'],
        $_POST['m_orderid'],
        $_POST['m_amount'],
        $_POST['m_curr'],
        $_POST['m_desc'],
        $_POST['m_status']
    );
    // Если были переданы дополнительные параметры, то добавляем их в

    if (isset($_POST['m_params'])) { $arHash[] = $_POST['m_params']; }
    // Добавляем в массив секретный ключ
    $arHash[] = $m_key;
    // Формируем подпись
    $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));
    // Если подписи совпадают и статус платежа “Выполнен”
    if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
    {
        // Здесь можно пометить счет как оплаченный или зачислить
        // Возвращаем, что платеж был успешно обработан

        $email = $_SESSION['userid'];
        $query = mysqli_query($con,"UPDATE users SET account=1 WHERE email='$email'"); //UPDATE `users` SET account=1 WHERE email='a@s.ru'
        $date_active = date("Y-m-d");
        $query = mysqli_query($con, "UPDATE users SET date_active='$date_active' WHERE email='$email'");
        exit($_POST['m_orderid'].'|success');
    }
    // В противном случае возвращаем ошибку
    exit($_POST['m_orderid'].'|error');
}
