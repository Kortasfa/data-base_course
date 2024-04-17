<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/request.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';
require_once __DIR__ . '/../src/lib/uploads.php';
require_once __DIR__ . '/../src/lib/views.php';

function showAddEmployeeForm(?string $errorMessage = null): void
{
    $company_branch_id = $_GET['company_branch_id'];
    if (!is_numeric($company_branch_id)) {
        writeErrorNotFound();
        exit();
    }
    $connection = connectDatabase();
    $branchData = findComnanyBranchInDatabase($connection, (int) $company_branch_id);

    echo renderView('employee/add_employee_form.php', [
        'errorMessage' => $errorMessage,
        'company_branch' => [
            'company_branch_id' => $company_branch_id,
            'city' => $branchData['city'],
            'company_address' => $branchData['company_address']
        ]
    ]);
}

function handleAddEmployeeForm(): void
{
    $company_branch_id = $_GET['company_branch_id'];
    
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $job = $_POST['job'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $birthDate = $_POST['birth_date'] ?? null;
    $hireDate = $_POST['hire_date'] ?? null;
    $adminComment = $_POST['admin_comment'] ?? null;
    if (!$name || !$email || !$job || !$gender || !$birthDate || !$hireDate || !$company_branch_id) {
        showAddEmployeeForm(errorMessage: 'Все поля обязательны для заполнения');
        http_response_code(HTTP_STATUS_400_BAD_REQUEST);
        return;
    }

    $connection = connectDatabase();

    saveEmployeeToDatabase($connection, [
        'company_branch_id' => $company_branch_id,
        'name' => $name,
        'email' => $email,
        'job' => $job,
        'gender'=> $gender,
        'birth_date' => $birthDate,
        'hire_date'=> $hireDate,
        'admin_comment' => $adminComment ? $adminComment : null,
    ]);

    writeRedirectSeeOther("show_branch_company_card.php?company_branch_id=$company_branch_id");
}

try
{
    if (isRequestHttpMethod(HTTP_METHOD_GET))
    {
        showAddEmployeeForm();
    }
    elseif (isRequestHttpMethod(HTTP_METHOD_POST))
    {
        handleAddEmployeeForm();
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