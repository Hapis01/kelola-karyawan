<?php

$file = 'app/Http/Controllers/Api/AuthController.php';
$content = file_get_contents($file);

// Remove nik dari register validation
$content = str_replace(
    "'name' => 'required|string|max:255',\n            'nik' => 'required|string|unique:users,nik|max:20',\n            'email' => 'required|string|email|unique:users,email',",
    "'name' => 'required|string|max:255',\n            'email' => 'required|string|email|unique:users,email',",
    $content
);

file_put_contents($file, $content);
echo "Register validation updated!";
?>
