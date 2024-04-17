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
        "Филиалы" => "index.php",
        "{$company_branch['city']}, {$company_branch['company_address']}" => "show_branch_company_card.php?company_branch_id={$company_branch['company_branch_id']}",
        "Добавление сотрудника" => "",
    );
    require (__DIR__ . '/../navigation_bar.php') ?>
    <form class="form" method="post" enctype="multipart/form-data">
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
        <div>
            <label for="image">Фото сотрудника</label>
            <input name="image" type="file" id="image" required accept="image/webp,image/jpeg"
                onchange="previewImage(event)" />
            <img id="imagePreview" src="#" alt="Preview" class="image-profile" />
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
    <script>
        function previewImage(event) {
            var input = event.target;
            var preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = "#";
                preview.style.display = 'none';
            }
        }
    </script>
</body>