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
                'user_name'  => 'Prof. Dr. dr. Budi Yuli Setianto, Sp.PD.KKV, Sp.JP(K)',
                'user_email' => 'budi.yuli@ugm.ac.id',
                'user_image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/02/6B73282C-BE28-4549-8770-6D4006A2AAE5_1_201_a-560x376.jpeg',
            ],
            [
                'user_name'  => 'Prof. Dr. dr. Bambang Irawan, Sp.PD(K), Sp.JP',
                'user_email' => 'bambang.irawan@ugm.ac.id',
                'user_image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/D56218B7-ADFD-45FE-9BA7-3D71EB244FF2_1_201_a-560x376.jpeg',
            ],
            [
                'user_name'  => 'Dr. Hasanah Mumpuni, SpPD, SpJP(K)',
                'user_email' => 'hasanah.mumpuni@ugm.ac.id',
                'user_image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/9196FD50-1F28-4783-A1B4-24B9DA047FFE_1_201_a-560x376.jpeg',
            ],
            [
                'user_name'  => 'Dr. dr. Lucia Kris Dinarti, SpPD, SpJP(K)',
                'user_email' => 'lucia.kris@ugm.ac.id',
                'user_image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/5BC4A2EB-99CC-4357-95E0-3F36F7CE06E5_1_201_a-560x376.jpeg',
            ],
            [
                'user_name'  => 'Dr. dr. Hariadi Hariawan, Sp.PD(K), Sp.JP(K)',
                'user_email' => 'hariadi.hariawan@ugm.ac.id',
                'user_image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/1E03551F-FABD-436D-AB3B-E7163CB409B4_1_201_a-560x376.jpeg',
            ],
            [
                'user_name'  => 'dr. Irsad Andi Arso Sp.PD, Sp.JP(K)',
                'user_email' => 'irsad.andi@ugm.ac.id',
                'user_image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/4A004B24-89AB-4B63-A7E7-5BBE489426C7_1_201_a-560x376.jpeg',
            ],
            [
                'user_name'  => 'Dr. dr. Nahar Taufiq, Sp.JP(K)',
                'user_email' => 'nahar.taufiq@ugm.ac.id',
                'user_image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/CD3CDC73-2131-4C1D-8071-4C51D6F48653_1_201_a-560x376.jpeg',
            ],
            [
                'user_name'  => 'Dr. Erika Maharani, SpJP(K)',
                'user_email' => 'erika.maharani@ugm.ac.id',
                'user_image' => 'https://kardiologi.fk.ugm.ac.id/wp-content/uploads/sites/434/2023/03/003EB0B7-A194-405A-9A6C-4F40907A5043_1_105_c-560x376.jpeg',
            ],
        ];

        foreach ($data as $datum){
            $user = User::whereUserEmail($datum['user_email'])
                ->first();

            $datum['user_is_speaker'] = 1;
            if($user){
                $user->update($datum);
            } else {
                User::create($datum);
            }
        }
    }
}
