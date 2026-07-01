<?php

// app/Http/Controllers/DatabaseController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function checkConnection()
    {
        try {
            DB::connection('mysql_hosting')->getPdo();
            return response()->json(['status' => 'success', 'message' => 'Connection successful']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

    public function storeData(Request $request)
    {
        // Pengecekan koneksi terlebih dahulu
        $connectionCheck = $this->checkConnection();

        if ($connectionCheck->getData()->status === 'error') {
            return response()->json(['status' => 'error', 'message' => 'Database connection failed.'], 500);
        }
        // Jika koneksi berhasil, lanjutkan dengan menyimpan data
        DB::connection('mysql_hosting')->table('your_table')->insert([
            'column1' => $request->input('value1'),
            'column2' => $request->input('value2'),
            // tambahkan kolom lainnya sesuai kebutuhan
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data stored successfully']);
    }
    public function checkVisits()
    {
        // Pengecekan koneksi terlebih dahulu
        $connectionCheck = $this->checkConnection();

        if ($connectionCheck->getData()->status === 'error') {
            return response()->json(['status' => 'error', 'message' => 'Database connection failed.'], 500);
        }
        $load = DB::connection('mysql_hosting')->table('visits')->get();
        dd($load);
    }
    public function sync()
    {
        // Connect to live database
        $live_database = DB::connection('mysql_hosting');
        // Get table data from production
        foreach($live_database->table('table_name')->get() as $data){
           // Save data to staging database - default db connection
        DB::table('table_name')->insert((array) $data);
        // This query can do only one time for multiple time we have to do
        DB::table('table_name')->insertOrUpdate((array) $data);
        // This query also update column only, if you do some changes in
        //previous data it will not sync for that i dont know this query is
        //correct or not but it worked.
        DB::table('table_name')->delete((array) $data);
        DB::table('table_name')->insertOrIgnore((array) $data);
        }
    }
}
