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

        td:last-child {
            border: none
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
                <th>City</th>
                <th>Address</th>
                <th>Employee Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($company_branches as $branch): ?>
                <tr>
                    <td><?= htmlentities($branch['city']) ?></td>
                    <td><?= htmlentities($branch['company_address']) ?></td>
                    <td><?= htmlentities($branch['employee_amount']) ?></td>
                    <td><img class='delete' src='img/delete.png' data-id="<?= $branch['id'] ?>" /></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button>
        <a href="add_company_branch.php">Add New Branch</a>
    </button>
    <script>
        var deleteButtons = document.querySelectorAll('.delete');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var branchId = this.getAttribute('data-id');

                var xhr = new XMLHttpRequest();
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