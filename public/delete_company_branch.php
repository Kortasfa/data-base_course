<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/request.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';

function handleDeleteCompanyBranch(): void
{
    $id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : null;
    if (!$id) {
        http_response_code(HTTP_STATUS_400_BAD_REQUEST);
        return;
    }

    $connection = connectDatabase();

    deleteComnanyBranchInDatabase(
        $connection,
        $id,
    );

    writeRedirectSeeOther("index.php");
}

try {
    if (isRequestHttpMethod(HTTP_METHOD_POST)) {
        handleDeleteCompanyBranch();
    } else {
        writeRedirectSeeOther('/');
    }
} catch (Throwable $ex) {
    error_log((string) $ex);
    writeInternalError();
}