<?php
/**
 * @param int $id
 * @return string
 */
function getEmployeeCard(int $employeeId, int $companyBranchId): string
{
    return "/public/show_employee.php?employee_id=$employeeId&company_branch_id=$companyBranchId";
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Информация о филиале</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/../public/css/main.css">
</head>

<body>
    <?php
    $links = array(
        "Филиалы" => "index.php",
        "{$company_branch['city']}, {$company_branch['company_address']}" => "",
    );
    require (__DIR__ . '/../navigation_bar.php') ?>
    <div class="container">
        <form method="post">
            <div>
                <label for="city">Город</label>
                <input type="text" name="city" value="<?= htmlentities($company_branch['city']) ?>" id="city" required
                    maxlength="100" />
            </div>
            <div>
                <label for="Address">Адрес</label>
                <input type="text" name="company_address"
                    value="<?= htmlentities($company_branch['company_address']) ?>" id="address" required
                    maxlength="100" />
            </div>
            <div class="info-item">
                <span class="info-label">Количество сотрудников:</span>
                <span class="info-value"><?= htmlentities($company_branch['employee_amount']) ?></span>
            </div>
            <?php if ($errorMessage): ?>
                <div>
                    <p class="form-error"><?= $errorMessage ?></p>
                </div>
            <?php endif; ?>
            <div>
                <button type="submit">Редактировать</button>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Должность</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employee_data as $employee): ?>
                    <tr>
                        <td
                            onclick="window.location='<?= getEmployeeCard($employee['id'], $company_branch['company_branch_id']) ?>'">
                            <?= htmlentities($employee['name']) ?></td>
                        <td
                            onclick="window.location='<?= getEmployeeCard($employee['id'], $company_branch['company_branch_id']) ?>'">
                            <?= htmlentities($employee['job']) ?></td>
                        <td><img class='delete' src='img/delete.png' data-id="<?= $employee['id'] ?>" /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button>
            <a href="add_employee.php?company_branch_id=<?= $company_branch['company_branch_id'] ?>">Добавить
                сотрудника</a>
        </button>

    </div>
    <script>
        const deleteButtons = document.querySelectorAll('.delete');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const employeeId = this.getAttribute('data-id');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_employee.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        console.error('Ошибка удаления работника');
                    }
                };
                xhr.send('employee_id=' + encodeURIComponent(employeeId));
            });
        });
    </script>
</body>

</html>