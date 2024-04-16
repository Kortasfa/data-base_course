<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/request.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';

function handleDeleteEmployee(): void
{
    $id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : null;
    if (!$id) {
        http_response_code(HTTP_STATUS_400_BAD_REQUEST);
        return;
    }

    $connection = connectDatabase();

    deleteEmployeeInDatabase(
        $connection,
        $id,
    );
}

try {
    if (isRequestHttpMethod(HTTP_METHOD_POST)) {
        handleDeleteEmployee();
    } else {
        writeRedirectSeeOther('/');
    }
} catch (Throwable $ex) {
    error_log((string) $ex);
    writeInternalError();
}