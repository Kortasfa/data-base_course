<?php
/**
 * @var string|null $errorMessage
 */
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Добавить сотрудника</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/../public/css/main.css">
</head>

<body>
    <?php
    $links = array(
        "Вернуться" => "show_branch_company_card.php?company_branch_id=$company_branch_id"
    );
    require (__DIR__ . '/../navigation_bar.php') ?>
    <form class="form" method="post">
        <div>
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" required maxlength="100" />
        </div>
        <div>
            <label for="job">Должность</label>
            <input type="text" name="job" id="job" required maxlength="100" />
        </div>
        <div>
            <label for="gender">Пол</label>
            <select id="gender" name="gender">
                <option value="1">Male</option>
                <option value="0">Female</option>
            </select>
        </div>
        <div>
            <label for="email">Электронная почта</label>
            <input type="text" name="email" id="email" required maxlength="100" />
        </div>
        <div>
            <label for="birth_date">Дата рождения</label>
            <input type="date" name="birth_date" id="birth_date" required maxlength="100" />
        </div>
        <div>
            <label for="hire_date">Дата найма</label>
            <input type="date" name="hire_date" id="hire_date" required maxlength="100" />
        </div>
        <div>
            <label for="admin_comment">Комментарий</label>
            <textarea id="admin_comment" name="admin_comment" required maxlength="100"></textarea>
        </div>
        <?php if ($errorMessage): ?>
            <div>
                <p class="form-error"><?= $errorMessage ?></p>
            </div>
        <?php endif; ?>
        <div>
            <button type="submit">Отправить</button>
        </div>
    </form>
</body>