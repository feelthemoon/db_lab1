<?php
// Блок инициализации
try {
    $pdoSet = new PDO('mysql:host=localhost', 'root', '');
    $pdoSet->query('SET NAMES utf8;');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}




// Код для "неубиваемой" базы данных
$sqlTM = "CREATE DATABASE IF NOT EXISTS bank;";
$stmt = $pdoSet->query($sqlTM);
$sqlTM = "USE bank;";
$stmt = $pdoSet->query($sqlTM);

// Создание таблиц
$sqlTM = "
    CREATE TABLE IF NOT EXISTS private_individuals (
        id INT NOT NULL AUTO_INCREMENT,
        first_name VARCHAR(45) NULL,
        second_name VARCHAR(45) NULL,
        sername VARCHAR(45) NULL,
        passport VARCHAR(45) NULL,
        inn VARCHAR(45) NULL,
        snils VARCHAR(45) NULL,
        license VARCHAR(45) NULL,
        docs VARCHAR(255) NULL,
        notes VARCHAR(255) NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB;
";
$stmt = $pdoSet->query($sqlTM);

$sqlTM = "
    CREATE TABLE IF NOT EXISTS borrowers (
        id INT NOT NULL,
        inn VARCHAR(45) NULL,
        borrower_type TINYINT NULL,
        address VARCHAR(255) NULL,
        amount DECIMAL(15,2) NULL,
        conditions VARCHAR(255) NULL,
        juridical_notes VARCHAR(255) NULL,
        contracts_list VARCHAR(255) NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB;
";
$stmt = $pdoSet->query($sqlTM);

$sqlTM = "
    CREATE TABLE IF NOT EXISTS borrowed_funds (
        id INT NOT NULL,
        indvidual_id INT NULL,
        amount DECIMAL(15,2) NULL,
        interest_rate DECIMAL(5,2) NULL,
        bid DECIMAL(5,2) NULL,
        borrow_date DATETIME NULL,
        conditions VARCHAR(255) NULL,
        notes VARCHAR(45) NULL,
        borrower_id INT NULL,
        PRIMARY KEY (id),
        INDEX indvidual_id_idx (indvidual_id ASC),
        INDEX borrower_id_idx (borrower_id ASC),
        CONSTRAINT indvidual_id
            FOREIGN KEY (indvidual_id) REFERENCES private_individuals (id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
        CONSTRAINT borrower_id
            FOREIGN KEY (borrower_id) REFERENCES borrowers (id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
    ) ENGINE=InnoDB;
";
$stmt = $pdoSet->query($sqlTM);

$sqlTM = "
    CREATE TABLE IF NOT EXISTS organization_loans (
        id INT NOT NULL,
        ogranization_id INT NULL,
        individual_id INT NULL,
        amount DECIMAL(15,2) NULL,
        loan_date DATETIME NULL,
        interest_rate DECIMAL(5,2) NULL,
        conditions VARCHAR(255) NULL,
        notes VARCHAR(255) NULL,
        PRIMARY KEY (id),
        INDEX individual_id_idx (individual_id ASC),
        CONSTRAINT individual_id
            FOREIGN KEY (individual_id) REFERENCES private_individuals (id)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
    ) ENGINE=InnoDB;
";
$stmt = $pdoSet->query($sqlTM);

// // Заполнение таблицы `private_individuals`
// for ($i = 1; $i <= 10; $i++) {
//     $sqlTM = "
//         INSERT INTO private_individuals (first_name, second_name, sername, passport, inn, snils, license, docs, notes) 
//         VALUES (
//             'FirstName$i',
//             'SecondName$i',
//             'Surname$i',
//             'Passport$i',
//             'INN$i',
//             'SNILS$i',
//             'License$i',
//             'Docs$i',
//             'Notes for individual $i'
//         );
//     ";
//     $pdoSet->query($sqlTM);
// }

// // Заполнение таблицы `borrowers`
// for ($i = 1; $i <= 10; $i++) {
//     $sqlTM = "
//         INSERT INTO borrowers (id, inn, borrower_type, address, amount, conditions, juridical_notes, contracts_list) 
//         VALUES (
//             $i,
//             'INN$i',
//             1, 
//             'Address $i',
//             1000.00 + $i,
//             'Condition $i',
//             'Notes $i',
//             'ContractList $i'
//         );
//     ";
//     $pdoSet->query($sqlTM);
// }

// // Заполнение таблицы `borrowed_funds`
// for ($i = 1; $i <= 10; $i++) {
//     $sqlTM = "
//         INSERT INTO borrowed_funds (id, indvidual_id, amount, interest_rate, bid, borrow_date, conditions, notes, borrower_id) 
//         VALUES (
//             $i,
//             $i,
//             500.00 + $i,
//             5.00,
//             1.50,
//             NOW(),
//             'Conditions for borrowed funds $i',
//             'Notes $i',
//             $i
//         );
//     ";
//     $pdoSet->query($sqlTM);
// }

// // Заполнение таблицы `organization_loans`
// for ($i = 1; $i <= 10; $i++) {
//     $sqlTM = "
//         INSERT INTO organization_loans (id, ogranization_id, individual_id, amount, loan_date, interest_rate, conditions, notes) 
//         VALUES (
//             $i,
//             $i,
//             $i,
//             2000.00 + $i,
//             NOW(),
//             6.50,
//             'Conditions for loan $i',
//             'Notes for loan $i'
//         );
//     ";
//     $pdoSet->query($sqlTM);
// }
// Вставка данных в таблицу `private_individuals`
if (isset($_GET['bt1'])) {
    // Получаем все столбцы таблицы
    $sql = "SHOW COLUMNS FROM private_individuals";
    $stmt = $pdoSet->query($sql);
    $resultMF = $stmt->fetchAll();

    $sqlTM = "INSERT INTO private_individuals (";
    for ($iR = 1; $iR < count($resultMF); ++$iR) {
        $sqlTM .= $resultMF[$iR]["Field"];
        if ($iR < count($resultMF) - 1) {
            $sqlTM .= ', ';
        } else {
            $sqlTM .= ") VALUES (";
        }
    }

    for ($iR = 1; $iR < count($resultMF); ++$iR) {
        $sqlTM .= "'".$_GET[$resultMF[$iR]["Field"]]."'";
        if ($iR < count($resultMF) - 1) {
            $sqlTM .= ', ';
        } else {
            $sqlTM .= ")";
        }
    }

    $stmt = $pdoSet->query($sqlTM);
}

// Обновление записи в таблице `private_individuals`
if (isset($_GET['textId'])) {
    $sql = "SHOW COLUMNS FROM private_individuals";
    $stmt = $pdoSet->query($sql);
    $resultMF = $stmt->fetchAll();

    $sqlTM = "UPDATE private_individuals SET ";
    for ($iR = 1; isset($_GET["textEd" . $iR]); ++$iR) {
        $sqlTM .= $resultMF[$iR]["Field"] . "='" . $_GET["textEd" . $iR] . "'";
        if (isset($_GET["textEd" . ($iR + 1)])) {
            $sqlTM .= ', ';
        } else {
            $sqlTM .= " WHERE id = " . $_GET["textId"];
        }
    }

    $stmt = $pdoSet->query($sqlTM);
}

// Удаление записи в таблице `private_individuals`
if (isset($_GET['delid'])) {
    $sqlTM = "DELETE FROM organization_loans WHERE individual_id = " . $_GET["delid"];
    $stmt = $pdoSet->query($sqlTM);
    $sqlTM = "DELETE FROM private_individuals WHERE id = " . $_GET["delid"];
    $stmt = $pdoSet->query($sqlTM);
}

// Добавление столбца в таблицу `private_individuals`
if (isset($_GET['addrow'])) {
    $sqlTM = "ALTER TABLE private_individuals ADD ".$_GET['addrow']."1 TEXT NOT NULL AFTER ".$_GET['addrow'];
    $stmt = $pdoSet->query($sqlTM);
}

// Удаление столбца из таблицы `private_individuals`
if (isset($_GET['delrow'])) {
    $sqlTM = "ALTER TABLE private_individuals DROP ".$_GET['delrow'];
    $stmt = $pdoSet->query($sqlTM);
}

// Основной запрос для выгрузки данных
if (isset($_GET['order'])) {
    $sql = "SELECT * FROM private_individuals ORDER BY ".$_GET['order']." ASC";
} else {
    $sql = "SELECT * FROM private_individuals ORDER BY id ASC";
}

$stmt = $pdoSet->query($sql);
$resultMF = $stmt->fetchAll(PDO::FETCH_NUM); // Получаем результаты в виде числовых индексов
?>
