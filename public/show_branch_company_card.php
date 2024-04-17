<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/request.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';
require_once __DIR__ . '/../src/lib/views.php';

function showCompanyBranchForm(?string $errorMessage = null): void
{
    $companyBranchId = $_GET['company_branch_id'];
    if (!is_numeric($companyBranchId)) {
        writeErrorNotFound();
        exit();
    }

    $connection = connectDatabase();
    $branchData = findComnanyBranchInDatabase($connection, (int) $companyBranchId);
    $employeeAmount = countAllEmployeesFromCompanyBranch($connection, (int) $companyBranchId);

    $employeeData = findAllEmployeesFromCompanyBranch($connection, (int) $companyBranchId);
    if (!$branchData) {
        writeErrorNotFound();
        exit();
    }

    echo renderView('company_branch/company_branch_page.php', [
        'company_branch' => [
            'company_branch_id' => $companyBranchId,
            'city' => $branchData['city'],
            'company_address' => $branchData['company_address'],
            'employee_amount' => $employeeAmount,
        ],
        'employee_data' => $employeeData,
    ]);
}

function handleShowCompanyBranch(): void
{
    $companyBranchId = $_GET['company_branch_id'];
    $city = $_POST['city'];
    $company_address = $_POST['company_address'] ?? null;
    if (!is_numeric($companyBranchId)) {
        writeErrorNotFound();
        exit();
    }
    if (!$city || !$company_address) {
        showCompanyBranchForm(errorMessage: 'Все поля обязательны для заполнения');
        http_response_code(HTTP_STATUS_400_BAD_REQUEST);
        return;
    }

    $connection = connectDatabase();
    editCompanyBranchToDatabase($connection, [
        'id' => (int) $companyBranchId,
        'city' => $city,
        'company_address' => $company_address
    ]);
    writeRedirectSeeOther("show_branch_company_card.php?company_branch_id=$companyBranchId");
}

try {
    if (isRequestHttpMethod(HTTP_METHOD_GET)) {
        showCompanyBranchForm();
    } elseif (isRequestHttpMethod(HTTP_METHOD_POST)) {
        handleShowCompanyBranch();
    } else {
        writeRedirectSeeOther($_SERVER['REQUEST_URI']);
    }
} catch (Throwable $ex) {
    error_log((string) $ex);
    writeInternalError();
}