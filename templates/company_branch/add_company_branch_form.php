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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        div.form-field {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-error {
            color: #ff0000;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
</head>

<body>
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