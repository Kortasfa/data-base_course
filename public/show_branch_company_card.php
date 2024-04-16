<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/request.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';
require_once __DIR__ . '/../src/lib/views.php';

function handleShowCompanyBranch(): void
{
    $companyBranchId = $_GET['company_branch_id'];
    if (!is_numeric($companyBranchId))
    {
        writeErrorNotFound();
        exit();
    }

    $connection = connectDatabase();
    $branchData = findComnanyBranchInDatabase($connection, (int)$companyBranchId);

    $employeeData = findAllEmployeesFromCompanyBranch($connection, (int)$companyBranchId);
    if (!$branchData)
    {
        writeErrorNotFound();
        exit();
    }

    echo renderView('company_branch/company_branch_page.php', [
        'company_branch' => [
            'company_branch_id' => $companyBranchId,
            'city' => $branchData['city'],
            'company_address' => $branchData['company_address'],
            'employee_amount' => $branchData['employee_amount'],
        ],
        'employee_data' => $employeeData,
    ]);
}

try
{
    if (isRequestHttpMethod(HTTP_METHOD_GET))
    {
        handleShowCompanyBranch();
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