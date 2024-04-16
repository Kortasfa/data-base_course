<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/lib/request.php';
require_once __DIR__ . '/../src/lib/response.php';
require_once __DIR__ . '/../src/lib/database.php';
require_once __DIR__ . '/../src/lib/views.php';

function handleShowEmployee(): void
{
    $employeeId = $_GET['employee_id'];
    $company_branch_id = $_GET['company_branch_id'];
    if (!is_numeric($employeeId))
    {
        writeErrorNotFound();
        exit();
    }

    $connection = connectDatabase();

    $employeeData = findEmployeeInDatabase($connection, (int)$employeeId);
    if (!$employeeData)
    {
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
        'company_branch_id' => $company_branch_id,
    ]);
}

try
{
    if (isRequestHttpMethod(HTTP_METHOD_GET))
    {
        handleShowEmployee();
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