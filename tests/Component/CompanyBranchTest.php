<?php
declare(strict_types=1);

namespace App\Tests\Component;

use App\Tests\Common\AbstractDatabaseTestCase;

class CompanyBranchTest extends AbstractDatabaseTestCase
{
    public function testSaveCompanyBranchToDatabase(): void
    {
        $connection = \connectDatabase();
        $expectedBranchData = [
            'city' => 'Комарово',
            'company_address' => 'Советская 17',
        ];

        $branchId = saveCompanyBranchToDatabase($connection, $expectedBranchData);
        $branchData = findCompanyBranchInDatabase($connection, $branchId);
        $this->assertEquals($expectedBranchData['city'], $branchData['city']);
        $this->assertEquals($expectedBranchData['company_address'], $branchData['company_address']);
    }

    public function testSaveCompanyBranchWithInvalidData(): void
    {
        $connection = \connectDatabase();
        $invalidBranchData = [
            'city' => 'Комарово',
            'company_address' => str_repeat('a', 256),
        ];

        $this->expectException(\PDOException::class);
        $this->expectExceptionMessage("SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column 'company_address' at row 1");

        saveCompanyBranchToDatabase($connection, $invalidBranchData);
    }


    public function testDeleteCompanyBranchToDatabase(): void
    {
        $connection = \connectDatabase();
        $savedBranchData = [
            'city' => 'Комарово',
            'company_address' => 'Советская 17',
        ];

        $branchId = saveCompanyBranchToDatabase($connection, $savedBranchData);
        $data = deleteComnanyBranchInDatabase($connection, $branchId);
        $this->assertEquals($data, null);
    }
    public function testEditCompanyBranchToDatabase(): void
    {
        $connection = \connectDatabase();
        $savedBranchData = [
            'city' => 'Комарово',
            'company_address' => 'Советская 17',
        ];

        $branchId = saveCompanyBranchToDatabase($connection, $savedBranchData);
        $editedBranchData = [
            'id' => $branchId,
            'city' => 'Комарово',
            'company_address' => 'Советская 19',
        ];
        editCompanyBranchToDatabase($connection, $editedBranchData);
        $data = findCompanyBranchInDatabase($connection, $branchId);

        $this->assertEquals($editedBranchData['city'], $data['city']);
        $this->assertEquals($editedBranchData['company_address'], $data['company_address']);
    }

    public function testCannotDeleteCompanyBranchWithEmployees(): void
    {
        $connection = \connectDatabase();
        $branchData = [
            'city' => 'Комарово',
            'company_address' => 'Советская 17',
        ];

        $branchId = saveCompanyBranchToDatabase($connection, $branchData);

        $employeeData = [
            'company_branch_id' => $branchId,
            'image_id' => '1',
            'name' => 'Александр',
            'gender' => true,
            'job' => 'инженер',
            'email' => 'alexandr@gmail.com',
            'birth_date' => '20.03.2002',
            'hire_date' => '11.11.2023',
            'admin_comment' => 'александр...'
        ];

        saveEmployeeToDatabase($connection, $employeeData);

        $this->expectException(\PDOException::class);
        $this->expectExceptionMessage('SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails');

        deleteComnanyBranchInDatabase($connection, $branchId);
    }

}