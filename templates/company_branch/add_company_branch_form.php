<?php
/**
 * @var string|null $errorMessage
 */
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Add Company Branch</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/../public/css/main.css">
</head>

<body>
<?php
    $links = array(
        "Вернуться" => "index.php",
    );
    require (__DIR__ . '/../navigation_bar.php') 
    ?>
    <form method="post">
        <div>
            <label for="city">City</label>
            <input type="text" name="city" id="city" required maxlength="100" />
        </div>
        <div>
            <label for="Address">Address</label>
            <input type="text" name="company_address" id="address" required maxlength="100" />
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