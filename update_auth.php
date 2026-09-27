<?php

$file = 'app/Http/Controllers/Api/AuthController.php';
$content = file_get_contents($file);

// Replace login validation dan query
$content = str_replace(
    "'nik' => 'required|string',",
    "'email' => 'required|string|email',",
    $content
);

$content = str_replace(
    "User::where('nik', \$request->nik)->first();",
    "User::where('email', \$request->email)->first();",
    $content
);

$content = str_replace(
    "'nik' => ['NIK atau Password salah'],",
    "'email' => ['Email atau Password salah'],",
    $content
);

// Remove nik from register validation dan create
$content = str_replace(
    "'nik' => 'required|string|unique:users,nik|max:20',\n            ",
    "",
    $content
);

$content = str_replace(
    "'nik' => \$request->nik,",
    "",
    $content
);

file_put_contents($file, $content);
echo "AuthController updated successfully!";
?>
