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
    <title>Company Branch Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/../public/css/main.css">
</head>

<body>
    <?php
    $links = array(
        "Вернуться" => "index.php",
        "Добавить сотрудника" => "add_employee.php?company_branch_id={$company_branch['company_branch_id']}",
    );
    require (__DIR__ . '/../navigation_bar.php') ?>
    <div class="container">
        <div class="info-item">
            <span class="info-label">Город:</span>
            <span class="info-value"><?= htmlentities($company_branch['city']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Адрес:</span>
            <span class="info-value"><?= htmlentities($company_branch['company_address']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Количество сотрудников:</span>
            <span class="info-value"><?= htmlentities($company_branch['employee_amount']) ?></span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Идентификатор</th>
                    <th>Имя</th>
                    <th>Должность</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employee_data as $employee): ?>
                    <tr>
                        <td>
                            <a href="<?= getEmployeeCard($employee['id'], $company_branch['company_branch_id']) ?>">
                                <?= htmlentities($employee['id']) ?>
                            </a>
                        </td>
                        <td><?= htmlentities($employee['name']) ?></td>
                        <td><?= htmlentities($employee['job']) ?></td>
                        <td><img class='delete' src='img/delete.png' data-id="<?= $employee['id'] ?>" /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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