<?php
/**
 * @var array{
 *   id: int,
 *   city: string,
 *   company_address: string,
 *   employee_amount: int,
 * }[] $company_branches
 */

/**
 * @param int $id
 * @return string
 */
function getBranchCompanyCard(int $id): string
{
    return "/public/show_branch_company_card.php?company_branch_id=$id";
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Филиалы компании</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/../public/css/main.css">
</head>

<body>
    <?php
    $links = array(
        "Филиалы" => ""
    );
    require (__DIR__ . '/../navigation_bar.php')
        ?>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Город</th>
                    <th>Адрес</th>
                    <th>Количество сотрудников</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($company_branches as $branch): ?>
                    <tr>
                        <td onclick="window.location='<?= getBranchCompanyCard($branch['id']) ?>'">
                            <?= htmlentities($branch['city']) ?></td>
                        <td onclick="window.location='<?= getBranchCompanyCard($branch['id']) ?>'">
                            <?= htmlentities($branch['company_address']) ?></td>
                        <td onclick="window.location='<?= getBranchCompanyCard($branch['id']) ?>'">
                            <?= htmlentities($employee_amount[$branch['id']]) ?></td>
                        <td><img class='delete' src='img/delete.png' data-id="<?= $branch['id'] ?>" /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button>
            <a href="add_company_branch.php">Добавить филиал </a>
        </button>
    </div>
    <script>
        const deleteButtons = document.querySelectorAll('.delete');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const branchId = this.getAttribute('data-id');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_company_branch.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        console.error('Ошибка удаления филиала');
                    }
                };
                xhr.send('branch_id=' + encodeURIComponent(branchId));
            });
        });
    </script>
</body>

</html>