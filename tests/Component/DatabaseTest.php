<?php
declare(strict_types=1);

namespace App\Tests\Component;

use App\Tests\Common\AbstractDatabaseTestCase;

class DatabaseTest extends AbstractDatabaseTestCase
{
    public function testSaveCompanyBranchToDatabase(): void
    {
        $connection = \connectDatabase();      
        $expectedBranchData = [
            'city' => 'Комарово',
            'company_address' => 'Советская 17'
        ];

        $branchId = saveCompanyBranchToDatabase($connection, $expectedBranchData);
        $branchData = findComnanyBranchInDatabase($connection, $branchId);
        $this->assertEquals($expectedBranchData, $branchData);
    }
}