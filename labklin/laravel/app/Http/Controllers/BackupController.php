<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    //Index
    public function index()
    {
        $menu = 'database';
        $submenu = 'backup';
        return view('pages.backup.index', compact('menu', 'submenu'));
    }
    //Action php artisan backup:run
    public function backupDatabase()
    {
        \Log::info('Backup process started.');
        Artisan::call('backupmanager:create --only="db"');
        \Log::info('Backup process ended.');
        return response()->json(['message' => 'Database backup completed.']);
    }
    public function backupmanager()
    {
        $menu = 'database';
        $submenu = 'backup';
        return view('pages.backup.manager', compact('menu', 'submenu'));
    }
}
