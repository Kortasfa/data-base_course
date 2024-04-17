<?php
declare(strict_types=1);

require_once __DIR__ . '/paths.php';

const DATABASE_CONFIG_NAME = 'database.db.ini';

/**
 * Создаёт объект класса PDO, представляющий подключение к MySQL.
 */
function connectDatabase(): PDO
{
    $configPath = getConfigPath(DATABASE_CONFIG_NAME);
    if (!file_exists($configPath))
    {
        throw new RuntimeException("Could not find database configuration at '$configPath'");
    }
    $config = parse_ini_file($configPath);
    if (!$config)
    {
        throw new RuntimeException("Failed to parse database configuration from '$configPath'");
    }

    // Проверяем наличие всех ключей конфигурации.
    $expectedKeys = ['dsn', 'user', 'password'];
    $missingKeys = array_diff($expectedKeys, array_keys($config));
    if ($missingKeys)
    {
        throw new RuntimeException('Wrong database configuration: missing options ' . implode(' ', $missingKeys));
    }

    return new PDO($config['dsn'], $config['user'], $config['password']);
}

/**
 * @param PDO $connection
 * @param array{
 *     city:string,
 *     company_address:string,
 *     employee_amount:int,
 * } $companyBranchData
 * @return int
 */
function saveCompanyBranchToDatabase(PDO $connection, array $companyBranchData): int
{
    $query = <<<SQL
        INSERT INTO company_branch
          (city, company_address, employee_amount)
        VALUES
          (:city, :company_address, :employee_amount)
        SQL;
    $statement = $connection->prepare($query);
    $statement->execute([
        ':city' => $companyBranchData['city'],
        ':company_address' => $companyBranchData['company_address'],
        ':employee_amount' => $companyBranchData['employee_amount'],
    ]);

    return (int)$connection->lastInsertId();
}

/**
 * @param PDO $connection
 * @param array{
 *     id:int, 
 *     city:string,
 *     company_address:string,
 * } $companyBranchData
 * @return int
 */
function editCompanyBranchToDatabase(PDO $connection, array $companyBranchData): int
{
    $query = <<<SQL
        UPDATE company_branch 
        SET city = :city, 
            company_address = :company_address
        WHERE id = :id
        SQL;
    $statement = $connection->prepare($query);
    $statement->execute([
        ':id' => $companyBranchData['id'],
        ':city' => $companyBranchData['city'],
        ':company_address' => $companyBranchData['company_address'],
    ]);

    return $statement->rowCount();
}

/**
 * Извлекает из БД данные поста с указанным ID.
 * Возвращает null, если пост не найден
 *
 * @param PDO $connection
 * @param int $id
 * @return array{
 *     id:int,
 *     city:string,
 *     company_address:string,
 *     employee_amount:int,
 * }|null
 */
function findComnanyBranchInDatabase(PDO $connection, int $id): ?array
{
    $query = <<<SQL
        SELECT
            id,
            city,
            company_address,
            employee_amount
        FROM company_branch
        WHERE id = $id
        SQL;

    $statement = $connection->query($query);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

/**
 * Извлекает из БД данные поста с указанным ID.
 * Возвращает null, если пост не найден
 *
 * @param PDO $connection
 * @param int $id
 * @return array{
 *     id:int,
 *     city:string,
 *     company_address:string,
 *     employee_amount:int,
 * }|null
 */
function deleteComnanyBranchInDatabase(PDO $connection, int $id): ?array
{
    $query = <<<SQL
        DELETE
        FROM company_branch
        WHERE id = $id
        SQL;

    $statement = $connection->query($query);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

/**
 * Получает все существующие филиалы компании из базы данных.
 *
 * @param PDO $connection
 *
 * @return array
 */
function getAllCompanyBranches(PDO $connection): array
{
    $query = "SELECT * FROM company_branch";
    $statement = $connection->query($query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Сохраняет сотрудника в таблицу employee и возвращает ID сотрудника.
 *
 * @param PDO $connection
 * @param array{
 *     company_branch_id:int,
 *     name:string,
 *     job:string,
 *     gender:bool,
 *     email:string,
 *     x:string,
 *     hire_date:string,
 *     admin_comment:?string
 * } $employeeData
 *
 * @return int
 */
function saveEmployeeToDatabase(PDO $connection, array $employeeData): int
{
    $query = <<<SQL
        INSERT INTO employee (company_branch_id, name, job, gender, email, birth_date, hire_date, admin_comment)
        VALUES (:company_branch_id, :name, :job, :gender, :email, :birth_date, :hire_date, :admin_comment)
        SQL;

    $statement = $connection->prepare($query);
    $statement->execute([
        ':company_branch_id' => $employeeData['company_branch_id'],
        ':name' => $employeeData['name'],
        ':job' => $employeeData['job'],
        ':gender' => $employeeData['gender'],
        ':email' => $employeeData['email'],
        ':birth_date' => $employeeData['birth_date'],
        ':hire_date' => $employeeData['hire_date'],
        ':admin_comment' => $employeeData['admin_comment'] ?? null,
    ]);

    return (int)$connection->lastInsertId();
}

/**
 * Сохраняет сотрудника в таблицу employee и возвращает ID сотрудника.
 *
 * @param PDO $connection
 * @param array{
 *     id:int,
 *     name:string,
 *     job:string,
 *     gender:bool,
 *     email:string,
 *     x:string,
 *     hire_date:string,
 *     admin_comment:?string
 * } $employeeData
 *
 * @return int
 */
function editEmployeeToDatabase(PDO $connection, array $employeeData): int
{
    $query = <<<SQL
        UPDATE employee 
        SET name = :name, 
            job = :job, 
            gender = :gender, 
            email = :email, 
            birth_date = :birth_date, 
            hire_date = :hire_date, 
            admin_comment = :admin_comment
        WHERE id = :id
        SQL;

    $statement = $connection->prepare($query);
    $statement->execute([
        ':id' => $employeeData['id'],
        ':name' => $employeeData['name'],
        ':job' => $employeeData['job'],
        ':gender' => $employeeData['gender'],
        ':email' => $employeeData['email'],
        ':birth_date' => $employeeData['birth_date'],
        ':hire_date' => $employeeData['hire_date'],
        ':admin_comment' => $employeeData['admin_comment'] ?? null,
    ]);

    return $statement->rowCount();
}


/**
 * Извлекает из БД параметры изображения с указанным ID.
 * Возвращает null, если параметры изображения не найдены
 *
 * @param PDO $connection
 * @param int $id
 * @return array{
 *     id: int,
 *     company_branch_id:int,
 *     name:string,
 *     job:string,
 *     gender:bool,
 *     email:string,
 *     birth_date:string,
 *     hire_date:string,
 *     admin_comment:?string
 * }|null
 */
function findEmployeeInDatabase(PDO $connection, int $id): ?array
{
    $query = <<<SQL
        SELECT
            id,
            company_branch_id,
            name,
            job,
            gender,
            email,
            birth_date,
            hire_date,
            admin_comment
        FROM employee
        WHERE id = $id
        SQL;

    $statement = $connection->query($query);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}


/**
 * Удаляет сотрудника филиала компании из базы данных.
 *
 * @param PDO $connection
 * @param int $id
 * @return void
 */
function deleteEmployeeInDatabase(PDO $connection, int $id): void
{
    $query = <<<SQL
        DELETE
        FROM employee
        WHERE id = $id
        SQL;

    $statement = $connection->query($query);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Получает всех сотрудников филиала компании из базы данных.
 *
 * @param PDO $connection
 * @param int $id
 * @return array
 */
function findAllEmployeesFromCompanyBranch(PDO $connection, int $id): ?array
{
    $query = <<<SQL
    SELECT *
    FROM employee
    WHERE company_branch_id = :id
    SQL;
    $statement = $connection->prepare($query);
    $statement->execute([':id' => $id]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Считает всех сотрудников филиала компании из базы данных.
 *
 * @param PDO $connection
 * @param int $id
 * @return int
 */
function countAllEmployeesFromCompanyBranch(PDO $connection, int $id): int
{
    $query = <<<SQL
    SELECT COUNT(id) AS employee_count
    FROM employee
    WHERE company_branch_id = :id
    SQL;
    $statement = $connection->prepare($query);
    $statement->execute([':id' => $id]);

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['employee_count'];
}

/**
 * Получает все существующие филиалы компании из базы данных.
 *
 * @param PDO $connection
 *
 * @return array
 */
function countStudentAmount(PDO $connection): array
{
    $query = <<<SQL
    SELECT company_branch_id, COUNT(id) AS employee_count
    FROM employee
    GROUP BY company_branch_id
    SQL;
    $statement = $connection->query($query);
    $result = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $result[$row['company_branch_id']] = $row['employee_count'];
    }
    return $result;
}