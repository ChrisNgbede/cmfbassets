<?php
define('BASEPATH', 'fixed');
$path = '/Applications/XAMPP/xamppfiles/htdocs/cmfbassets/uploads/';
echo "Path: " . $path . "\n";
echo "Exists: " . (is_dir($path) ? 'Yes' : 'No') . "\n";
echo "Writable: " . (is_writable($path) ? 'Yes' : 'No') . "\n";
echo "FCPATH constant (if it were in CI): " . realpath(dirname(__FILE__)) . "/\n";
