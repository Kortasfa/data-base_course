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
 * @param int $branchId
 * @return string
 */
function getPostPageUrl(int $branchId): string
{
    return "/show_post.php?post_id=$branchId";
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Company Branches</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
        }

        img {
            vertical-align: middle;
            height: 20px;
            width: auto;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>City</th>
                <th>Address</th>
                <th>Employee Amount</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($company_branches as $branch): ?>
                <tr>
                    <td><a href="<?= getPostPageUrl($branch['id']) ?>"><?= $branch['id'] ?></a></td>
                    <td><?= htmlentities($branch['city']) ?></td>
                    <td><?= htmlentities($branch['company_address']) ?></td>
                    <td><?= htmlentities($branch['employee_amount']) ?></td>
                    <td><img src='img/delete.png' /></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button>
        <a href="add_company_branch.php">Add New Branch</a>
    </button>
</body>

</html>