<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup the database and send it via email';

    public function handle()
    {
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $dbHost = env('DB_HOST');
        $backupPath = storage_path('app/backups');

        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        $fileName = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupPath . '/' . $fileName;

        // Dump database
        $command = "mysqldump --user={$dbUser} --password={$dbPassword} --host={$dbHost} {$dbName} > {$filePath}";
        $process = Process::fromShellCommandline($command);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Database backup failed: ' . $process->getErrorOutput());
            return;
        }

        $this->info('Database backup completed: ' . $fileName);

    //     // Send email with backup
    //    $status= Mail::raw('Attached is the latest database backup.', function ($message) use ($filePath, $fileName) {
    //         $message->to('rokonuddin450@gmail.com') // Change this to your recipient email
    //                 ->subject('Database Backup: ' . Carbon::now()->format('Y-m-d H:i'))
    //                 ->attach($filePath);
    //     });
        
    //     $this->info('Backup email sent successfully.');
    }


    // public function handle()
    // {
    //     $dbHost = env('DB_HOST');
    //     $dbUser = env('DB_USERNAME');
    //     $dbPassword = env('DB_PASSWORD');
    //     $dbName = env('DB_DATABASE');

    //     $backupPath = storage_path('app/backups');
    //     if (!file_exists($backupPath)) {
    //         mkdir($backupPath, 0777, true);
    //     }

    //     $fileName = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
    //     $localFilePath = $backupPath . '/' . $fileName;
    //     $remoteServer = 'your-remote-server-ip';
    //     $remoteUser = 'your-remote-user';
    //     $remotePath = '/path/to/backup-folder/'; // Example: /home/user/backups/

    //     // Backup Command
    //     $command = "mysqldump --host={$dbHost} --user={$dbUser} --password={$dbPassword} {$dbName} > \"{$localFilePath}\"";

    //     $process = Process::fromShellCommandline($command);
    //     $process->setTimeout(600);
    //     $process->run();

    //     if ($process->isSuccessful()) {
    //         $this->info('Database backup completed: ' . $fileName);

    //         // Transfer the backup to the remote server using SCP
    //         $scpCommand = "scp \"{$localFilePath}\" {$remoteUser}@{$remoteServer}:{$remotePath}";
    //         $scpProcess = Process::fromShellCommandline($scpCommand);
    //         $scpProcess->run();

    //         if ($scpProcess->isSuccessful()) {
    //             $this->info("Backup successfully transferred to: {$remoteServer}:{$remotePath}");
    //         } else {
    //             $this->error('Backup transfer failed: ' . $scpProcess->getErrorOutput());
    //         }
    //     } else {
    //         $this->error('Database backup failed: ' . $process->getErrorOutput());
    //     }
    // }
}
