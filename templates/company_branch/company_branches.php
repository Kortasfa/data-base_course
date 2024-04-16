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
    <title>Company Branches</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/../public/css/main.css">
</head>

<body>
    <?php
    $links = array(
        "Добавить ветку" => "add_company_branch.php"
    );
    require (__DIR__ . '/../navigation_bar.php') 
    ?>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Employee Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($company_branches as $branch): ?>
                    <tr>
                        <td>
                            <a href="<?= getBranchCompanyCard($branch['id']) ?>">
                                <?= htmlentities($branch['id']) ?>
                            </a>
                        </td>
                        <td><?= htmlentities($branch['city']) ?></td>
                        <td><?= htmlentities($branch['company_address']) ?></td>
                        <td><?= htmlentities($branch['employee_amount']) ?></td>
                        <td><img class='delete' src='img/delete.png' data-id="<?= $branch['id'] ?>" /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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