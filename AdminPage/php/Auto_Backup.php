<?php
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password for the root user
$database = "uscfms";

// Backup destination
$backupFile = 'C:\\xampp\\htdocs\\database_backup\\' . 'backup_' . date("Y-m-d-H-i-s") . '.sql';

// Log file
$logFile = 'C:\xampp\htdocs\database_backup\backup_log.txt';

// Full path to mysqldump executable
$mysqldumpPath = '"C:\xampp\mysql\bin\mysqldump.exe"'; // Change this to the actual path on your system

// Example backup command
$command = "{$mysqldumpPath} --user={$username} --password={$password} --host={$servername} {$database} > {$backupFile}";

// Execute the command
exec($command, $output, $resultCode);

// Log the backup details
$logMessage = date("Y-m-d H:i:s") . " - ";
if ($resultCode === 0) {
    $logMessage .= "Backup successful. File: {$backupFile}";
} else {
    $logMessage .= "Backup failed. Check error details: " . implode("\n", $output);
}

file_put_contents($logFile, $logMessage . "\n", FILE_APPEND);

// Output to the browser (optional)
echo $logMessage;
?>
