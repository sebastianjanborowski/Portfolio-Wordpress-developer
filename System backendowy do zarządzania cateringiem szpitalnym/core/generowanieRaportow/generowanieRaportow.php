<?php

function cateringGenerateRaport($who, $where, $what, $tableName, $pdo, $baza = []) {
    $nazwaTabeli = $tableName;

    $dopuszczaneTabele = [
        'raport_logowanie',
        'raport_diet',
        'raport_users',
        'raport_orders'
    ];

    if (!in_array($nazwaTabeli, $dopuszczaneTabele, true)) {
        return false;
    }

    $result = false;

    if ($nazwaTabeli === 'raport_logowanie') {
        $stmt = $pdo->prepare("
            INSERT INTO `$nazwaTabeli` (
                kto,
                rodzajOperacji,
                czas
            ) VALUES (
                :who,
                :what,
                NOW()
            )
        ");

        $result = $stmt->execute([
            ':who' => $who,
            ':what' => $what
        ]);

    } elseif ($nazwaTabeli === 'raport_diet') {
        $stmt = $pdo->prepare("
            INSERT INTO `$nazwaTabeli` (
                kto,
                rodzajOperacji,
                nazwaObiektu,
                czas,
                department_id,
                diet_name,
                diet_code,
                is_special_diet,
                diet_restrictions,
                diet_description,
                diet_notes,
                is_active
            ) VALUES (
                :who,
                :where,
                :what,
                NOW(),
                :department_id,
                :diet_name,
                :diet_code,
                :is_special_diet,
                :diet_restrictions,
                :diet_description,
                :diet_notes,
                :is_active
            )
        ");

        $result = $stmt->execute([
            ':who' => $who,
            ':where' => $where,
            ':what' => $what,
            ':department_id' => (int)($baza['department'] ?? 0),
            ':diet_name' => $baza['dietName'] ?? null,
            ':diet_code' => $baza['dietCode'] ?? null,
            ':is_special_diet' => (int)($baza['isSpecialDiet'] ?? 0),
            ':diet_restrictions' => $baza['dietRestrictions'] ?? null,
            ':diet_description' => $baza['dietDescription'] ?? null,
            ':diet_notes' => $baza['dietNotes'] ?? null,
            ':is_active' => (int)($baza['flaga'] ?? $baza['isActive'] ?? 0)
        ]);

    } elseif ($nazwaTabeli === 'raport_users') {
        $stmt = $pdo->prepare("
            INSERT INTO `$nazwaTabeli` (
                kto,
                rodzajOperacji,
                login,
                nazwaObiektu,
                imie,
                nazwisko,
                rola,
                email,
                is_active,
                created_at,
                updated_at
            ) VALUES (
                :who,
                :what,
                :userLogin,
                :objectName,
                :userName,
                :userSurname,
                :userRole,
                :userEmail,
                :is_active,
                :created_at,
                NOW()
            )
        ");

        $result = $stmt->execute([
            ':who' => $who,
            ':what' => $where,
            ':userLogin' => $baza['userLogin'] ?? null,
            ':objectName' => $what,
            ':userName' => $baza['userName'] ?? null,
            ':userSurname' => $baza['userSurname'] ?? null,
            ':userRole' => $baza['userRole'] ?? null,
            ':userEmail' => $baza['userEmail'] ?? null,
            ':is_active' => (int)($baza['is_active'] ?? 0),
            ':created_at' => $baza['userCreatedAt'] ?? date('Y-m-d H:i:s')
        ]);

    } elseif ($nazwaTabeli === 'raport_orders') {
        $departmentId = cateringDepartmentToId($baza['department'] ?? null);
        $isSpecial = cateringSpecialToInt($baza['special'] ?? null);
        $isActive = (int)($baza['isActive'] ?? 0);

        $stmt = $pdo->prepare("
            INSERT INTO `$nazwaTabeli` (
                `Who`,
                `Type_operation`,
                `Created_at`,
                `Name`,
                `Department_id`,
                `Order_name`,
                `Order_code`,
                `Is_special`,
                `Order_restrictions`,
                `Order_description`,
                `Is_active`
            ) VALUES (
                :who,
                :type_operation,
                NOW(),
                :name,
                :department_id,
                :diet_name,
                :diet_code,
                :is_special,
                :diet_restrictions,
                :diet_description,
                :is_active
            )
        ");

        $result = $stmt->execute([
            ':who' => $who,
            ':type_operation' => $where,
            ':name' => $what,
            ':department_id' => $departmentId,
            ':diet_name' => $baza['orderName'] ?? null,
            ':diet_code' => $baza['orderCode'] ?? null,
            ':is_special' => $isSpecial,
            ':diet_restrictions' => $baza['restrictions'] ?? null,
            ':diet_description' => $baza['description'] ?? null,
            ':is_active' => $isActive
        ]);
    } elseif ($nazwaTabeli === 'raport_orders') {
    $stmt = $pdo->prepare("
        INSERT INTO `$nazwaTabeli` (
            `Who`,
            `Type_operation`,
            `Created_at`,
            `Name`,
            `Department_id`,
            `Order_name`,
            `Order_code`,
            `Is_special`,
            `Order_restrictions`,
            `Order_description`,
            `Is_active`
        ) VALUES (
            :who,
            :type_operation,
            NOW(),
            :name,
            :department_id,
            :diet_name,
            :diet_code,
            :is_special,
            :diet_restrictions,
            :diet_description,
            :is_active
        )
    ");

    $departmentValue = $baza['department'] ?? null;

    if (is_numeric($departmentValue)) {
        $departmentId = (int)$departmentValue;
    } else {
        $departments = [
            'Chirurgia' => 1,
            'Oddział Chirurgiczny' => 1,
            'Interna' => 2,
            'Oddział Internistyczny' => 2,
            'Pediatria' => 3,
            'Oddział Pediatryczny' => 3,
            'Geriatria' => 4,
            'Oddział Geriatryczny' => 4,
            'Neurologia' => 5,
            'Oddział Neurologiczny' => 5,
            'Onkologia' => 6,
            'Oddział Onkologiczny' => 6
        ];

        $departmentId = $departments[$departmentValue] ?? 0;
    }

    $specialValue = $baza['special'] ?? 0;

    if ($specialValue === 'Tak' || $specialValue === '1' || $specialValue === 1) {
        $isSpecial = 1;
    } else {
        $isSpecial = 0;
    }

    $result = $stmt->execute([
        ':who' => $who,
        ':type_operation' => $where,
        ':name' => $what,
        ':department_id' => $departmentId,
        ':diet_name' => $baza['orderName'] ?? null,
        ':diet_code' => $baza['orderCode'] ?? null,
        ':is_special' => $isSpecial,
        ':diet_restrictions' => $baza['restrictions'] ?? null,
        ':diet_description' => $baza['description'] ?? null,
        ':is_active' => (int)($baza['isActive'] ?? 0)
    ]);
} elseif ($nazwaTabeli === 'raport_orders') {
    $stmt = $pdo->prepare("
        INSERT INTO `$nazwaTabeli` (
            `Who`,
            `Type_operation`,
            `Created_at`,
            `Name`,
            `Department_id`,
            `Diet_name`,
            `Diet_code`,
            `Is_special`,
            `Diet_restrictions`,
            `Diet_description`,
            `Is_active`
        ) VALUES (
            :who,
            :type_operation,
            NOW(),
            :name,
            :department_id,
            :diet_name,
            :diet_code,
            :is_special,
            :diet_restrictions,
            :diet_description,
            :is_active
        )
    ");

    $departmentValue = $baza['department'] ?? null;

    if (is_numeric($departmentValue)) {
        $departmentId = (int)$departmentValue;
    } else {
        $departments = [
            'Chirurgia' => 1,
            'Oddział Chirurgiczny' => 1,
            'Interna' => 2,
            'Oddział Internistyczny' => 2,
            'Pediatria' => 3,
            'Oddział Pediatryczny' => 3,
            'Geriatria' => 4,
            'Oddział Geriatryczny' => 4,
            'Neurologia' => 5,
            'Oddział Neurologiczny' => 5,
            'Onkologia' => 6,
            'Oddział Onkologiczny' => 6
        ];

        $departmentId = $departments[$departmentValue] ?? 0;
    }

    $specialValue = $baza['special'] ?? 0;

    if ($specialValue === 'Tak' || $specialValue === '1' || $specialValue === 1) {
        $isSpecial = 1;
    } else {
        $isSpecial = 0;
    }

    $result = $stmt->execute([
        ':who' => $who,
        ':type_operation' => $where,
        ':name' => $what,
        ':department_id' => $departmentId,
        ':diet_name' => $baza['orderName'] ?? null,
        ':diet_code' => $baza['orderCode'] ?? null,
        ':is_special' => $isSpecial,
        ':diet_restrictions' => $baza['restrictions'] ?? null,
        ':diet_description' => $baza['description'] ?? null,
        ':is_active' => (int)($baza['isActive'] ?? 0)
    ]);
}

    return $result;
}

function cateringDepartmentToId($department) {
    if ($department === null || $department === '') {
        return 0;
    }

    if (is_numeric($department)) {
        return (int)$department;
    }

    $department = trim($department);

    $departments = [
        'Chirurgia' => 1,
        'Interna' => 2,
        'Pediatria' => 3,
        'Geriatria' => 4,
        'Neurologia' => 5,
        'Onkologia' => 6,

        'Oddział Chirurgiczny' => 1,
        'Oddział Internistyczny' => 2,
        'Oddział Pediatryczny' => 3,
        'Oddział Geriatryczny' => 4,
        'Oddział Neurologiczny' => 5,
        'Oddział Onkologiczny' => 6
    ];

    return $departments[$department] ?? 0;
}

function cateringSpecialToInt($special) {
    if ($special === null || $special === '') {
        return 0;
    }

    $special = trim((string)$special);

    if ($special === '1') {
        return 1;
    }

    if ($special === '0') {
        return 0;
    }

    $specialLower = mb_strtolower($special);

    if ($specialLower === 'tak') {
        return 1;
    }

    if ($specialLower === 'nie') {
        return 0;
    }

    return 0;
}