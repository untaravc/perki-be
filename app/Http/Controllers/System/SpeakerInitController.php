<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SpeakerInitController extends Controller
{
    public function init_speaker()
    {
        $this->speakers();
    }

    private function speakers()
    {
        $data = [
            [
                'name'  => 'Prof. Dr. dr. Budi Yuli Setianto, Sp.PD.KKV, Sp.JP(K)',
                'slug'  => 'budi.yuli',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/02/6B73282C-BE28-4549-8770-6D4006A2AAE5_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'Prof. Dr. dr. Bambang Irawan, Sp.PD(K), Sp.JP',
                'slug'  => 'bambang.irawan',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/D56218B7-ADFD-45FE-9BA7-3D71EB244FF2_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'Dr. Hasanah Mumpuni, SpPD, SpJP(K)',
                'slug'  => 'hasanah.mumpuni',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/9196FD50-1F28-4783-A1B4-24B9DA047FFE_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'Dr. dr. Lucia Kris Dinarti, SpPD, SpJP(K)',
                'slug'  => 'lucia.kris',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/5BC4A2EB-99CC-4357-95E0-3F36F7CE06E5_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'Dr. dr. Hariadi Hariawan, Sp.PD(K), Sp.JP(K)',
                'slug'  => 'hariadi.hariawan',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/1E03551F-FABD-436D-AB3B-E7163CB409B4_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Irsad Andi Arso Sp.PD, Sp.JP(K)',
                'slug'  => 'irsad.andi',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/4A004B24-89AB-4B63-A7E7-5BBE489426C7_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'Dr. dr. Nahar Taufiq, Sp.JP(K)',
                'slug'  => 'nahar.taufiq',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/CD3CDC73-2131-4C1D-8071-4C51D6F48653_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'Dr. Erika Maharani, SpJP(K)',
                'slug'  => 'erika.maharani',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/003EB0B7-A194-405A-9A6C-4F40907A5043_1_105_c-560x376.jpeg',
            ],
            [
                'name'  => 'Dr.Med dr. Putrika Prastuti Ratna Gharini Sp.JP (K)',
                'slug'  => 'putrika.prastuti',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/7ABBFADF-EEC7-46D8-844D-567E5035C658_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Dyah Wulan Anggrahini, Ph.D, Sp.JP(K)',
                'slug'  => 'dyah.wulan',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/3C9F223E-E9BB-478B-AADE-5E7A271827FF_1_105_c-560x376.jpeg',
            ],
            [
                'name'  => 'Dr. dr. Anggoro Budi Hartopo.,Ph.D, Sp.PD, Sp.JP',
                'slug'  => 'anggoro.budi',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/DC3C87B6-227A-4CAE-B9BB-4F05FCEC770F_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Hendry Purnasidha Bagaswoto Sp.JP(K)',
                'slug'  => 'hendry.purnasidha',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/DC3C87B6-227A-4CAE-B9BB-4F05FCEC770F_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Real Kusumanjaya Marsam, Sp.JP(K)',
                'slug'  => 'real.jusumanjaya',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/5CB8582E-B0CB-44C7-A42A-B7C5C0AF2DC8_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Muhammad Taufik Ismail, Sp.JP(K)',
                'slug'  => 'taufik.ismail',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/F3F87898-B248-49C6-ACB2-C1E3E843917A_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Vita Yanti Anggraeni, Sp.PD, Sp.JP, Ph.D',
                'slug'  => 'vita.yanti',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/3AF5C064-B57F-4F20-A6C7-A16BD6C93137_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Fera Hidayati, Sp.JP',
                'slug'  => 'fera.hidayati',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/248FF0D2-7023-4029-B837-9129E9D9A6A9_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Muhammad Gahan Satwiko, Sp.JP, Ph.D',
                'slug'  => 'gahan.satwiko',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/F127BC7B-172D-4B37-BE63-CF8A0BC82405_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Firandi Saputra, Sp.JP',
                'slug'  => 'gahan.satwiko',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/10715CCB-B136-451C-9456-ADFBB1BFE1F4_1_201_a-560x376.jpeg',
            ],
            [
                'name'  => 'dr. Dyah Adhi Kusumastuti, Sp.JP',
                'slug'  => 'dyah.adhi',
                'desc'  => "Departemen Kardiologi & Ked. Vaskular, FKKMK, UGM",
                'image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/14271A69-7FC8-435F-8BC5-2B26D1AB3C26_1_201_a-560x376.jpeg',
            ],
        ];

        foreach ($data as $datum) {
            $user = User::whereSlug($datum['slug'])
                ->first();

            $datum['is_speaker'] = 1;
            if ($user) {
                $user->update($datum);
            } else {
                User::create($datum);
            }
        }
    }
}
