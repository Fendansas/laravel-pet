<?php

namespace App\Jobs;

use App\Exports\ItemsExport;
use App\Mail\ExportReadyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Queue\ShouldQueue;
use ZipArchive;

class ExportItemsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            \Log::info('Export job started');

            $password = rand(100000, 999999);

            $excelName = 'items_' . time() . '.xlsx';
            $zipName = 'items_' . time() . '.zip';

            Excel::store(new ItemsExport(), $excelName, 'local');

            $excelPath = Storage::disk('local')->path($excelName);

            if (!file_exists($excelPath)) {
                throw new \Exception("Excel file not found: " . $excelPath);
            }

            $zipPath = storage_path('app/' . $zipName);

            $zip = new ZipArchive();

            $zip->open($zipPath, ZipArchive::CREATE);

            $zip->setPassword($password);

            $zip->addFile($excelPath, basename($excelName));

            $zip->setEncryptionName(basename($excelName), \ZipArchive::EM_AES_256);

            $zip->close();

            unlink($excelPath);

            Mail::to($this->user->email)
                ->send(new ExportReadyMail($zipName, $password));
        } catch (\Throwable $e) {
            \Log::error('Export job failed: '.$e->getMessage());
            \Log::error($e->getTraceAsString());

            throw $e;
        }
    }
}
