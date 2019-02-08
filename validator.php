<?php

require ('Request.php');

$request = new Request;
$errors = [];

if ($request->isPost()) {
    $request->required('title');
    $request->maxSymbols('title', 255)
        ->minSymbols('title', 3);

    $request->maxSymbols('annotation', 500);

    $request->maxSymbols('content', 30000);

    $request->required('email')
        ->correctEmail('email');

    $request->isNumber('views')
        ->isNotNegativeNumber('views')
        ->maxValueNumber('views', 4294967294);

    $request->correctPublishDate('date');

    $request->radiobuttonIsNotEmpty('publish_in_index');

    $request->selectIsNotEmptyValues('category')
        ->inValues('category', 1, 2, 3);

    $isValid = $request->isValid();
    $errors = $request->getErrors();
    echo json_encode([
        'status' => $isValid,
        'errors' => $errors,
    ]);
}
