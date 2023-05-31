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
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/budi.yuli.jpg',
            ],
            [
                'name'  => 'Prof. Dr. dr. Bambang Irawan, Sp.PD(K), Sp.JP',
                'slug'  => 'bambang.irawan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/bambang.irawan.jpeg',
            ],
            [
                'name'  => 'dr. Hasanah Mumpuni, SpPD, SpJP(K)',
                'slug'  => 'hasanah.mumpuni',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/hasanah.mumpuni.jpg',
            ],
            [
                'name'  => 'Dr. dr. Lucia Kris Dinarti, SpPD, SpJP(K)',
                'slug'  => 'lucia.kris',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/lucia.kris.jpg',
            ],
            [
                'name'  => 'Dr. dr. Hariadi Hariawan, Sp.PD(K), Sp.JP(K)',
                'slug'  => 'hariadi.hariawan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/hariadi.hariawan.jpg',
            ],
            [
                'name'  => 'dr. Irsad Andi Arso Sp.PD, Sp.JP(K)',
                'slug'  => 'irsad.andi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/irsad.andi.jpg',
            ],
            [
                'name'  => 'Dr. dr. Nahar Taufiq, Sp.JP(K)',
                'slug'  => 'nahar.taufiq',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/nahar.taufiq.jpg',
            ],
            [
                'name'  => 'dr. Erika Maharani, SpJP(K)',
                'slug'  => 'erika.maharani',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/erika.maharani.jpeg',
            ],
            [
                'name'  => 'Dr.Med dr. Putrika Prastuti Ratna Gharini Sp.JP (K)',
                'slug'  => 'putrika.prastuti',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/putrika.prastuti.jpg',
            ],
            [
                'name'  => 'dr. Dyah Wulan Anggrahini, Ph.D, Sp.JP(K)',
                'slug'  => 'dyah.wulan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/dyah.wulan.jpg',
            ],
            [
                'name'  => 'Dr. dr. Anggoro Budi Hartopo.,Ph.D, Sp.PD, Sp.JP',
                'slug'  => 'anggoro.budi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/anggoro.budi.jpg',
            ],
            [
                'name'  => 'dr. Hendry Purnasidha Bagaswoto Sp.JP(K)',
                'slug'  => 'hendry.purnasidha',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/hendry.purnasidha.jpeg',
            ],
            [
                'name'  => 'dr. Real Kusumanjaya Marsam, Sp.JP(K)',
                'slug'  => 'real.kusumanjaya',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/real.kusumanjaya.jpg',
            ],
            [
                'name'  => 'dr. Muhammad Taufik Ismail, Sp.JP(K)',
                'slug'  => 'taufik.ismail',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/taufik.ismail.jpeg',
            ],
            [
                'name'  => 'dr. Vita Yanti Anggraeni, Sp.PD, Sp.JP, Ph.D',
                'slug'  => 'vita.yanti',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/vita.yanti.jpeg',
            ],
            [
                'name'  => 'dr. Fera Hidayati, Sp.JP',
                'slug'  => 'fera.hidayati',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/fera.hidayati.jpeg',
            ],
            [
                'name'  => 'dr. Muhammad Gahan Satwiko, Sp.JP, Ph.D',
                'slug'  => 'gahan.satwiko',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/gahan.satwiko.jpg',
            ],
            [
                'name'  => 'dr. Firandi Saputra, Sp.JP',
                'slug'  => 'firandi.saputra',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/firandi.saputra.jpg',
            ],
            [
                'name'  => 'dr. Dyah Adhi Kusumastuti, Sp.JP',
                'slug'  => 'dyah.adhi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/dyah.adhi.jpg',
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
