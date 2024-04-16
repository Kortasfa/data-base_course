<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Employee Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .info-item {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
        }

        .info-value {
            margin-left: 10px;
        }

        img {
            vertical-align: middle;
            height: 20px;
            width: auto;
        }
    </style>
</head>

<body>
    <?php
    $links = array(
        "Вернуться" => "show_branch_company_card.php?company_branch_id=$company_branch_id"
    );
    require (__DIR__ . '/../navigation_bar.php') ?>
    <div class="container">
        <div class="info-item">
            <span class="info-label">Имя:</span>
            <span class="info-value"><?= htmlentities($employee['name']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Должность:</span>
            <span class="info-value"><?= htmlentities($employee['job']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Электронная почта:</span>
            <span class="info-value"><?= htmlentities($employee['email']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Пол:</span>
            <span class="info-value"><?= ($employee['gender']) ? 'male' : 'femal' ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Дата рождения:</span>
            <span class="info-value"><?= htmlentities($employee['birth_date']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Дата найма:</span>
            <span class="info-value"><?= htmlentities($employee['hire_date']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Комментарий:</span>
            <span class="info-value"><?= htmlentities($employee['admin_comment']) ?></span>
        </div>
    </div>
</body>

</html>