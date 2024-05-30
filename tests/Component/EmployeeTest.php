<?php
declare(strict_types=1);

namespace App\Tests\Component;

use App\Tests\Common\AbstractDatabaseTestCase;

class EmployeeTest extends AbstractDatabaseTestCase
{
    private $connection;
    private $branchId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->connection = \connectDatabase();
        $savedBranchData = [
            'city' => 'Комарово',
            'company_address' => 'Советская 17',
        ];

        $this->branchId = saveCompanyBranchToDatabase($this->connection, $savedBranchData);
    }

    public function testSaveEmployeeToDatabase(): void
    {
        $expectedEmployeeData = [
            'company_branch_id' => $this->branchId,
            'image_id' => '1',
            'name' => 'Александр',
            'gender' => true,
            'job' => 'инженер',
            'email' => 'alexandr@gmail.com',
            'birth_date' => '20.03.2002',
            'hire_date' => '11.11.2023',
            'admin_comment' => 'александр...'
        ];

        $employeeId = saveEmployeeToDatabase($this->connection, $expectedEmployeeData);
        $employeeData = findEmployeeInDatabase($this->connection, $employeeId);
        $this->assertEquals($employeeData['name'], $expectedEmployeeData['name']);
        $this->assertEquals($employeeData['admin_comment'], $expectedEmployeeData['admin_comment']);
    }

    public function testDeleteEmployeeFromDatabase(): void
    {
        $expectedEmployeeData = [
            'company_branch_id' => $this->branchId,
            'image_id' => '1',
            'name' => 'Александр',
            'gender' => true,
            'job' => 'инженер',
            'email' => 'alexandr@gmail.com',
            'birth_date' => '20.03.2002',
            'hire_date' => '11.11.2023',
            'admin_comment' => 'александр...'
        ];

        $employeeId = saveEmployeeToDatabase($this->connection, $expectedEmployeeData);
        deleteEmployeeInDatabase($this->connection, $employeeId);
        $employeeData = findEmployeeInDatabase($this->connection, $employeeId);
        $this->assertEquals($employeeData, null);
    }

    public function testEditEmployeeToDatabase(): void
    {
        $expectedEmployeeData = [
            'company_branch_id' => $this->branchId,
            'image_id' => '1',
            'name' => 'Александр',
            'gender' => true,
            'job' => 'инженер',
            'email' => 'alexandr@gmail.com',
            'birth_date' => '20.03.2002',
            'hire_date' => '11.11.2023',
            'admin_comment' => 'александр...'
        ];

        $employeeId = saveEmployeeToDatabase($this->connection, $expectedEmployeeData);
        $editedEmployeeData = [
            'id' => $employeeId,
            'company_branch_id' => $this->branchId,
            'image_id' => '1',
            'name' => 'Александр',
            'gender' => true,
            'job' => 'электрик',
            'email' => 'alexandr@gmail.com',
            'birth_date' => '20.03.2002',
            'hire_date' => '11.11.2023',
            'admin_comment' => 'александр...'
        ];
        editEmployeeToDatabase($this->connection, $editedEmployeeData);
        $data = findEmployeeInDatabase($this->connection, $employeeId);

        $this->assertEquals($editedEmployeeData['job'], $data['job']);
    }
}
