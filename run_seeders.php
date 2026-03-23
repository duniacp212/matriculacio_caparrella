<?php
$output = shell_exec("php spark db:seed DatabaseSeeder 2>&1");
file_put_contents('seed_errors.txt', $output);
