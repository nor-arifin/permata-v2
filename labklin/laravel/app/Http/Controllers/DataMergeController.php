<?php

// app/Http/Controllers/DataMergeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataMergeController extends Controller
{
    // MERGE DATA DARI LOCAL KE HOSTING
    public function mergeData()
    {
        $menu = 'database';
        $submenu = 'syncup';

        return view('pages.syncronize.syncup', compact('menu', 'submenu'));
    }
    public function syncup(Request $request)
    {
        // Validate Request
        $request->validate([
            'date' => 'required|date',
            'table' => 'required',
        ]);

        $date = $request->input('date');
        $table = $request->input('table');
        $thisdate = $date;
        // dd($date, $table);
        // Pengecekan koneksi ke database hosting
        try {
            DB::connection('mysql_hosting')->getPdo();
        } catch (\Exception $e) {
            Log::error('Database connection failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Database connection to hosting failed.'], 500);
        }
        //CEK TABLE NAME
        if ($table == 'visits')
        {
            // Ambil data dari database lokal
            try {
                $localData = DB::connection('mysql_local')->table($table)
                ->where('visit_date', $thisdate)->get();
            } catch (\Exception $e) {
                Log::error('Failed to fetch data from local database: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Failed to fetch data from local database.'], 500);
            }

            // Ambil nama-nama kolom dari tabel lokal
            $columns = DB::connection('mysql_local')->getSchemaBuilder()->getColumnListing($table);

            // Simpan data ke database hosting
            try {
                foreach ($localData as $data) {
                    // Siapkan array untuk menyimpan data
                    $dataToInsert = [];

                    foreach ($columns as $column) {
                        $dataToInsert[$column] = $data->$column;
                    }

                    DB::connection('mysql_hosting')->table($table)
                    // ->where('visit_date', $thisdate)
                    ->updateOrInsert(
                        ['visit_registration_id' => $data->visit_registration_id], // Ganti dengan kunci unik sesuai dengan struktur tabel Anda
                        $dataToInsert
                    );
                }
                return redirect()->route('merge.data')->with('success', 'Database '.$thisdate.' from local syncronized successfully');
            } catch (\Exception $e) {
                Log::error('Failed to merge data: ' . $e->getMessage());
                // return response()->json(['status' => 'error', 'message' => 'Failed to merge data.'], 500);
                return redirect()->route('merge.data')->with('error', 'Failed to syncronize '.$thisdate.' from local');
            }
        }elseif($table == 'services_detail')
        {
            // Ambil data dari database lokal
            try {
                $localData = DB::connection('mysql_local')->table($table)
                ->where('created_at', 'like', $thisdate.'%')->get();
            } catch (\Exception $e) {
                Log::error('Failed to fetch data from local database: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Failed to fetch data from local database.'], 500);
            }

            // Ambil nama-nama kolom dari tabel lokal
            $columns = DB::connection('mysql_local')->getSchemaBuilder()->getColumnListing($table);

            // Simpan data ke database hosting
            try {
                foreach ($localData as $data) {
                    // Siapkan array untuk menyimpan data
                    $dataToInsert = [];

                    foreach ($columns as $column) {
                        $dataToInsert[$column] = $data->$column;
                    }
                    // Delete existing row from hosting database
                    // DB::connection('mysql_hosting')->table($table)
                    // ->where('created_at', 'like', $thisdate.'%')
                    // ->delete();

                    DB::connection('mysql_hosting')->table($table)
                    ->where('created_at', 'like', $thisdate.'%')
                    // ->insert($dataToInsert);
                    ->updateOrInsert(
                        ['id' => $data->id],
                        // ['created_at' => $data->created_at], // Ganti dengan kunci unik sesuai dengan struktur tabel Anda
                        $dataToInsert
                    );
                }
                return redirect()->route('merge.data')->with('success', 'Database '.$thisdate.' from local syncronized successfully');
            } catch (\Exception $e) {
                Log::error('Failed to merge data: ' . $e->getMessage());
                // return response()->json(['status' => 'error', 'message' => 'Failed to merge data.'], 500);
                return redirect()->route('merge.data')->with('error', 'Failed to syncronize '.$thisdate.' from local');
            }
        }
    }
    //MERGE DATA DARI HOSTING KE LOCAL
    public function mergeBack()
    {
        $menu = 'database';
        $submenu = 'syncdown';

        return view('pages.syncronize.syncdown', compact('menu', 'submenu'));
    }
    public function syncdown(Request $request)
    {
        // Validate Request
        $request->validate([
            'date' => 'required|date',
            'table' => 'required',
        ]);

        $date = $request->input('date');
        $table = $request->input('table');
        $thisdate = $date;
        // dd($date, $table);
        // Pengecekan koneksi ke database hosting
        try {
            DB::connection('mysql_hosting')->getPdo();
        } catch (\Exception $e) {
            Log::error('Database connection failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Database connection to cloud failed.'], 500);
        }
        //CEK TABLE NAME
        if ($table == 'visits')
        {
            // Ambil data dari database cloud
            try {
                $cloudData = DB::connection('mysql_hosting')->table($table)
                ->where('visit_date', $thisdate)->get();
            } catch (\Exception $e) {
                Log::error('Failed to fetch data from cloud database: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Failed to fetch data from cloud database.'], 500);
            }

            // Ambil nama-nama kolom dari tabel cloud
            $columns = DB::connection('mysql_hosting')->getSchemaBuilder()->getColumnListing($table);

            // Simpan data ke database hosting
            try {
                foreach ($cloudData as $data) {
                    // Siapkan array untuk menyimpan data
                    $dataToInsert = [];

                    foreach ($columns as $column) {
                        $dataToInsert[$column] = $data->$column;
                    }

                    DB::connection('mysql_local')->table($table)
                    // ->where('visit_date', $thisdate)
                    ->updateOrInsert(
                        ['visit_registration_id' => $data->visit_registration_id], // Ganti dengan kunci unik sesuai dengan struktur tabel Anda
                        $dataToInsert
                    );
                }
                return redirect()->route('merge.back')->with('success', 'Database '.$thisdate.' from cloud syncronized successfully');
            } catch (\Exception $e) {
                Log::error('Failed to merge data: ' . $e->getMessage());
                // return response()->json(['status' => 'error', 'message' => 'Failed to merge data.'], 500);
                return redirect()->route('merge.back')->with('error', 'Failed to syncronize '.$thisdate.' from cloud');
            }
        }elseif($table == 'services_detail')
        {
            // Ambil data dari database cloud
            try {
                $cloudData = DB::connection('mysql_hosting')->table($table)
                ->where('service_time_result', 'like', $thisdate.'%')->get();
            } catch (\Exception $e) {
                Log::error('Failed to fetch data from cloud database: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Failed to fetch data from cloud database.'], 500);
            }

            // Ambil nama-nama kolom dari tabel cloud
            $columns = DB::connection('mysql_hosting')->getSchemaBuilder()->getColumnListing($table);

            // Simpan data ke database hosting
            try {
                foreach ($cloudData as $data) {
                    // Siapkan array untuk menyimpan data
                    $dataToInsert = [];

                    foreach ($columns as $column) {
                        $dataToInsert[$column] = $data->$column;
                    }
                    DB::connection('mysql_local')->table($table)
                    ->where('service_time_result', 'like', $thisdate.'%')
                    // ->insert($dataToInsert);
                    ->updateOrInsert(
                        ['id' => $data->id],
                        // ['created_at' => $data->created_at], // Ganti dengan kunci unik sesuai dengan struktur tabel Anda
                        $dataToInsert
                    );
                }
                return redirect()->route('merge.back')->with('success', 'Database '.$thisdate.' from cloud syncronized successfully');
            } catch (\Exception $e) {
                Log::error('Failed to merge data: ' . $e->getMessage());
                // return response()->json(['status' => 'error', 'message' => 'Failed to merge data.'], 500);
                return redirect()->route('merge.back')->with('error', 'Failed to syncronize '.$thisdate.' from cloud');
            }
        }
    }
    // CONTOH STORE DATA
    // public function storeData(Request $request)
    // {
    //     // Pengecekan koneksi terlebih dahulu
    //     $connectionCheck = $this->checkConnection();

    //     if ($connectionCheck->getData()->status === 'error') {
    //         return response()->json(['status' => 'error', 'message' => 'Database connection failed.'], 500);
    //     }
    //     // Jika koneksi berhasil, lanjutkan dengan menyimpan data
    //     DB::connection('mysql_hosting')->table('your_table')->insert([
    //         'column1' => $request->input('value1'),
    //         'column2' => $request->input('value2'),
    //         // tambahkan kolom lainnya sesuai kebutuhan
    //     ]);

    //     return response()->json(['status' => 'success', 'message' => 'Data stored successfully']);
    // }
}

