<?php declare(strict_types=1);

// Simple test/demo script - extend as you like!
require_once __DIR__ . '/../vendor/autoload.php';

use App\AdminUser;
use App\CustomerUser;
use App\UserBase;

echo "PHP Basics Coding Challenge Demo\n";

// Simulate POST data
$_POST['users'] = [
    ['name' => 'Alice', 'email' => 'alice@example.com'],
    ['name' => 'Bob', 'email' => 'bob@example.com'],
];

// Numeric array for ordered list of users
$users = [
    new AdminUser('Admin', 'admin@example.com'),
    new CustomerUser('Customer', 'customer@example.com')
];

// Associative array for structured input data
$usersFromPost = array_map(
    fn ($u) => new CustomerUser($u['name'], $u['email']),
    $_POST['users']
);

// Merge arrays
$allUsers = array_merge($users, $usersFromPost);

// Filter admins
$admins = array_filter(
    $allUsers,
    fn (UserBase $user) => $user->getRole() === UserBase::ROLE_ADMIN
);

$admin = new AdminUser('Alice', 'alice@example.com');

// Reset password
$admin->resetPassword();

// Check if password was set and print it
$tempPassword = $admin->getPassword();
if ($tempPassword !== null) {
    echo "Temporary password for {$admin->getEmail()}: {$tempPassword}\n";
} else {
    echo "Password reset failed.\n";
}

// Lightweight test
assert($tempPassword !== null);

// Output
foreach ($allUsers as $user) {
    echo $user . PHP_EOL;
}

// Assertions (simple unit test style)
assert(count($admins) === 1);
assert(UserBase::getUserCount() === count($allUsers));

echo "All tests passed.\n";