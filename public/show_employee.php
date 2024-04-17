<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/request.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';
require_once __DIR__ . '/../src/lib/views.php';

function showEmployeePostForm(?string $errorMessage = null): void
{
    $employeeId = $_GET['employee_id'];
    $company_branch_id = $_GET['company_branch_id'];
    if (!is_numeric($employeeId)) {
        writeErrorNotFound();
        exit();
    }

    $connection = connectDatabase();
    $branchData = findComnanyBranchInDatabase($connection, (int) $company_branch_id);

    $employeeData = findEmployeeInDatabase($connection, (int) $employeeId);
    if (!$employeeData) {
        writeErrorNotFound();
        exit();
    }

    echo renderView('employee/show_employee_page.php', [
        'employee' => [
            'name' => $employeeData['name'],
            'job' => $employeeData['job'],
            'gender' => $employeeData['gender'],
            'email' => $employeeData['email'],
            'birth_date' => $employeeData['birth_date'],
            'hire_date' => $employeeData['hire_date'],
            'admin_comment' => $employeeData['admin_comment'],
        ],
        'company_branch' => [
            'company_branch_id' => $company_branch_id,
            'city' => $branchData['city'],
            'company_address' => $branchData['company_address']
        ]
    ]);
}

function handleShowEmployee(): void
{
    $company_branch_id = $_GET['company_branch_id'];
    $employee_id = $_GET['employee_id'];
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $job = $_POST['job'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $birthDate = $_POST['birth_date'] ?? null;
    $hireDate = $_POST['hire_date'] ?? null;
    $adminComment = $_POST['admin_comment'] ?? null;
    if (!$name || !$email || !$job || !$gender || !$birthDate || !$hireDate || !$employee_id) {
        showEmployeePostForm(errorMessage: 'Все поля обязательны для заполнения');
        http_response_code(HTTP_STATUS_400_BAD_REQUEST);
        return;
    }
    $connection = connectDatabase();
    editEmployeeToDatabase($connection, [
        'id' => $employee_id,
        'name' => $name,
        'email' => $email,
        'job' => $job,
        'gender' => $gender,
        'birth_date' => $birthDate,
        'hire_date' => $hireDate,
        'admin_comment' => $adminComment ? $adminComment : null,
    ]);
    writeRedirectSeeOther("show_branch_company_card.php?company_branch_id=$company_branch_id");
}

try {
    if (isRequestHttpMethod(HTTP_METHOD_GET)) {
        showEmployeePostForm();
    } elseif (isRequestHttpMethod(HTTP_METHOD_POST)) {
        handleShowEmployee();
    } else {
        writeRedirectSeeOther($_SERVER['REQUEST_URI']);
    }
} catch (Throwable $ex) {
    error_log((string) $ex);
    writeInternalError();
}