<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/database.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';
require_once __DIR__ . '/../src/lib/views.php';
require_once __DIR__ . '/../src/lib/request.php';

function showCompmanyBranches(): void 
{
    $connection = connectDatabase();

    $company_branches = getAllCompanyBranches($connection);

    echo renderView('company_branches.php', [
        'company_branches' => $company_branches
    ]);
}

try
{
    if (isRequestHttpMethod(HTTP_METHOD_GET))
    {
        showCompmanyBranches();
    }
    else
    {
        writeRedirectSeeOther($_SERVER['REQUEST_URI']);
    }
}
catch (Throwable $ex)
{
    error_log((string)$ex);
    writeInternalError();
}