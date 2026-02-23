<?php

declare(strict_types=1);

// Simple test/demo script - extend as you like!
require_once __DIR__ . '/../vendor/autoload.php';

use App\AdminUser;
use App\CustomerUser;
use App\UserBase;

// Helper function to print a list of users
function printUsers(array $users): void
{
    foreach ($users as $user) {
        // Print the user as a string (calls __toString()) followed by a newline
        echo $user . PHP_EOL;
    }
}

function runDemo(): void
{
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

    // Create users from POST data using a closure and associative arrays
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

    // Create admin to reset password
    $admin = $users[0];

    // Reset password
    $admin->resetPassword();

    // Check if password was set and print it
    $tempPassword = $admin->getPassword();
    if ($tempPassword !== null) {
        echo "Temporary password for {$admin->getEmail()}: {$tempPassword}\n";
    } else {
        echo "Password reset failed.\n";
    }

    // Demonstrate exception handling with invalid email
    try {
        $invalidUser = new CustomerUser('Invalid', 'not-an-email');
    } catch (InvalidArgumentException $e) {
        echo "Caught invalid email: {$e->getMessage()}\n";
    }

    // Demonstrate switch control structure on roles
    foreach ($allUsers as $user) {
        switch ($user->getRole()) {
            case UserBase::ROLE_ADMIN:
                echo "Found admin: {$user->getName()}\n";
                break;
            case UserBase::ROLE_CUSTOMER:
                echo "Found customer: {$user->getName()}\n";
                break;
            default:
                echo "Unknown role for {$user->getName()}\n";
        }
    }

    // Simple while loop example (just to demonstrate syntax)
    $index = 0;
    while ($index < count($allUsers)) {
        $index++;
    }

    // Logical operator example (&&)
    if ($tempPassword !== null && $admin->login()) {
        echo "Admin can log in with the new password.\n";
    }

    // Lightweight test with basic assertion
    assert($tempPassword !== null);

    // Use helper function
    printUsers($allUsers);

    // Assertions (simple unit test style)
    assert(count($admins) === 1);
    assert(UserBase::getUserCount() === count($allUsers));

    echo "All tests passed.\n";

}

runDemo();
