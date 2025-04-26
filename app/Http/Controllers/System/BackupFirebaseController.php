<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackupFirebaseController extends Controller
{
    public function iterateModel(Request $request)
    {
        $karyawans = Karyawan::where('karyawan_foto', 'like', 'karyawan/%')
            ->where('sync_at', null)
            ->limit($request->limit ?? 50)
            ->get();

        $success = [];
        $failed = [];
        foreach ($karyawans as $karyawan) {
            if (strpos($karyawan->karyawan_foto, 'https://') === false) {
                $data['file'] = storage_path('app/public/' . $karyawan->karyawan_foto);
                if (!file_exists($data['file'])) {
                    $failed[] = [
                        'id' => $karyawan->karyawan_id,
                        'note'  => $data['file'],
                    ];
                    $karyawan->update([
                        'sync_at' => now()
                    ]);
                } else {
                    $data['name'] = $karyawan->karyawan_foto;
                    $data['type'] = 'image/jpeg';
                    $new_firebase_path = $this->uploadFile($data['file'], date('Ym', strtotime($karyawan->created_at)) . "/" . $data['name'], $data['type']);

                    $karyawan->update([
                        'karyawan_foto' => $new_firebase_path,
                        'sync_at' => now()
                    ]);
                }
            }
        }

        return [
            'success' => $success,
            'failed' => $failed,
        ];
    }
}
