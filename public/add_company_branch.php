<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/request.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';
require_once __DIR__ . '/../src/lib/uploads.php';
require_once __DIR__ . '/../src/lib/views.php';

const SHOW_POST_URL = '/show_post.php';
const POST_ID_PARAM = 'post_id';

function showAddPostForm(?string $errorMessage = null): void
{
    echo renderView('add_company_branch_form.php', [
        'errorMessage' => $errorMessage
    ]);
}

function handleAddPostForm(): void
{
    // Разбор параметров формы
    $city = $_POST['city'] ?? null;
    $companyAddress = $_POST['company_address'] ?? null;
    if (!$city || !$companyAddress)
    {
        showAddPostForm(errorMessage: 'Все поля обязательны для заполнения');
        http_response_code(HTTP_STATUS_400_BAD_REQUEST);
        return;
    }

    // Сохранение параметров изображения в базу данных
    $connection = connectDatabase();

    $postId = saveCompanyBranchToDatabase($connection, [
        'city' => $city,
        'company_address' => $companyAddress,
        'employee_amount' => 0
    ]);

    header('Location: '. 'public/index.php');
}

try
{
    if (isRequestHttpMethod(HTTP_METHOD_GET))
    {
        showAddPostForm();
    }
    elseif (isRequestHttpMethod(HTTP_METHOD_POST))
    {
        handleAddPostForm();
    }
    else
    {
        writeRedirectSeeOther('/');
    }
}
catch (Throwable $ex)
{
    error_log((string)$ex);
    writeInternalError();
}