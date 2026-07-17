<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        $backupName = config('backup.backup.name');
        
        $files = $disk->files($backupName);
        $backups = [];
        
        foreach ($files as $file) {
            if (substr($file, -4) === '.zip') {
                $backups[] = [
                    'file_path' => $file,
                    'file_name' => str_replace($backupName . '/', '', $file),
                    'file_size' => $this->humanFilesize($disk->size($file)),
                    'last_modified' => Carbon::createFromTimestamp($disk->lastModified($file)),
                ];
            }
        }
        
        // Reverse array to show newest first
        $backups = array_reverse($backups);

        return view('admin.backups.index', compact('backups'));
    }

    public function create()
    {
        try {
            // Run the backup command in the background or asynchronously if possible
            // For now we will run it synchronously but only for the database to make it fast
            Artisan::call('backup:run', ['--only-db' => true]);
            
            return redirect()->route('admin.backups.index')->with('success', 'Sauvegarde créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')->with('error', 'Erreur lors de la création de la sauvegarde: ' . $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        $file = $request->get('file_name');
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        $backupName = config('backup.backup.name');
        
        $fullPath = $backupName . '/' . $file;

        if ($disk->exists($fullPath)) {
            return $disk->download($fullPath);
        }

        return redirect()->route('admin.backups.index')->with('error', 'Fichier introuvable.');
    }

    public function destroy(Request $request)
    {
        $file = $request->get('file_name');
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        $backupName = config('backup.backup.name');
        
        $fullPath = $backupName . '/' . $file;

        if ($disk->exists($fullPath)) {
            $disk->delete($fullPath);
            return redirect()->route('admin.backups.index')->with('success', 'Sauvegarde supprimée avec succès.');
        }

        return redirect()->route('admin.backups.index')->with('error', 'Fichier introuvable.');
    }

    private function humanFilesize($bytes, $decimals = 2)
    {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
