<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Navigation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        div.navigation {
            background-color: #333;
            padding: 10px 0;
            text-align: center;
        }

        div.navigation a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        div.navigation a:hover {
            background-color: #555;
        }

        div.navigation a span {
            display: inline-block;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="navigation">
        <?php foreach ($links as $title => $url) {
            echo '<a href="' . $url . '"><span>' . $title . '</span></a>';
        }
        ?>
    </div>
</body>

</html>