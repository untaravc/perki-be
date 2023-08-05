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
                'name'  => 'dr. Anggia Endah S, Sp.JP(K)',
                'slug'  => 'anggia.endah',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/anggia.endah.jpg',
            ],
            [
                'name'  => 'Dr. dr. Anggoro Budi Hartopo.,Ph.D, Sp.PD, Sp.JP',
                'slug'  => 'anggoro.budi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/anggoro.budi.hartopo.png',
            ],
            [
                'name'  => 'dr. Arditya Damarkusuma, M.Med(ClinEpi), Sp.JP',
                'slug'  => 'arditya.damarkusuma',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/arditya.damarkusuma.png',
            ],
            [
                'name'  => 'dr. Bagus Andi Pramono, Sp.JP',
                'slug'  => 'bagus.andi',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/bagus.andi.jpg',
            ],
            [
                'name'  => 'dr. Dini Paramita, Sp.JP',
                'slug'  => 'dini.paramita',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/dini.paramita.jpg',
            ],
            [
                'name'  => 'Dr. dr. Hariadi Hariawan, Sp.PD(K), Sp.JP(K)',
                'slug'  => 'hariadi.hariawan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/hariadi.hariawan.jpg',
            ],
            [
                'name'  => 'Dr. dr. Lucia Kris Dinarti, SpPD, SpJP(K)',
                'slug'  => 'lucia.kris',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/lucia.kris.dinarti.png',
            ],
            [
                'name'  => 'Dr. dr. Nahar Taufiq, Sp.JP(K)',
                'slug'  => 'nahar.taufiq',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/nahar.taufiq.jpg',
            ],
            [
                'name'  => 'dr. Dyah Adhi Kusumastuti, Sp.JP',
                'slug'  => 'dyah.adhi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/dyah.adhi.jpg',
            ],
            [
                'name'  => 'dr. Dyah Samti Mayasari, PhD, Sp.JP',
                'slug'  => 'dyah.samti',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/dyah.samti.jpg',
            ],
            [
                'name'  => 'dr. Dyah Wulan Anggrahini, Ph.D, Sp.JP(K)',
                'slug'  => 'dyah.wulan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/dyah.wulan.anggrahini.png',
            ],
            [
                'name'  => 'dr. Erika Maharani, SpJP(K)',
                'slug'  => 'erika.maharani',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/erika.maharani.png',
            ],
            [
                'name'  => 'dr. Firandi Saputra, Sp.JP',
                'slug'  => 'firandi.saputra',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/firandi.saputra.jpg',
            ],
            [
                'name'  => 'dr. Firman Fauzan, Sp.JP',
                'slug'  => 'firman.fauzan',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/firman.fauzan.png',
            ],
            [
                'name'  => 'dr. Gagah Buana Putra, Sp.JP',
                'slug'  => 'gagah.buana',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/gagah.buana.jpg',
            ],
            [
                'name'  => 'dr. Galuh Retno, Sp.JP',
                'slug'  => 'galuh.retno',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/galuh.retno.webp',
            ],
            [
                'name'  => 'dr. Hari Yusti Laksono, Sp.JP(K)',
                'slug'  => 'hari.yusti',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/hari.yusti.laksono.png',
            ],
            [ // 19
                'name'  => 'dr. Hasanah Mumpuni, SpPD, SpJP(K)',
                'slug'  => 'hasanah.mumpuni',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/hasanah.mumpuni.png',
            ],
            [
                'name'  => 'dr. Hendry Purnasidha Bagaswoto Sp.JP(K)',
                'slug'  => 'hendry.purnasidha',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/hendry.purnasidha.png',
            ],
            [ // 21
                'name'  => 'dr. Irsad Andi Arso Sp.PD, Sp.JP(K)',
                'slug'  => 'irsad.andi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/irsad.andi.arso.png',
            ],
            [ // 22
                'name'  => 'dr. Lidwina Tarigan, Sp.JP(K)',
                'slug'  => 'lidwina.tarigan',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/lidwina.tarigan.jpg',
            ],
            [ // 23
                'name'  => 'dr. Lima Peni, Sp.JP',
                'slug'  => 'lima.peni',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/lima.peni.jpg',
            ],
            [ // 24
                'name'  => 'dr. M Ulil, SpJP',
                'slug'  => 'm.ulil',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/ulil.jpg',
            ],
            [ // 25
                'name'  => 'dr. Muhammad Gahan Satwiko, Sp.JP, Ph.D',
                'slug'  => 'gahan.satwiko',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/muhammad.gahan.satwiko.png',
            ],
            [ // 26
                'name'  => 'dr. M. Yulianto Sismoyo, Sp.JP',
                'slug'  => 'yulianto.sismoyo',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/yulianto.sismoyo.jpg',
            ],
            [ // 27
                'name'  => 'dr. Margono Gatot, Sp.JP(K)',
                'slug'  => 'margono.gatot',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/margono.gatot.png',
            ],
            [ // 28
                'name'  => 'dr. Muhammad Taufik Ismail, Sp.JP(K)',
                'slug'  => 'taufik.ismail',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/taufik.ismail.jpeg',
            ],
            [ // 29
                'name'  => 'dr. Pamrayogi Hutomo, SpJP',
                'slug'  => 'pamrayogi.hutomo',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/pamrayogi.hutomo.jpg',
            ],
            [ // 30
                'name'  => 'dr. Real Kusumanjaya Marsam, Sp.JP(K)',
                'slug'  => 'real.kusumanjaya',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/real.kusumanjaya.marsam.png',
            ],
            [ // 31
                'name'  => 'dr. Rendi Asmara, Sp.JP(K)',
                'slug'  => 'rendi.asmara',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/rendi.asmara.jpg',
            ],
            [ // 32
                'name'  => 'dr. Rizki Amalia, Sp.JP',
                'slug'  => 'riski.amalia',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/riski.amalia.jpeg.jpg',
            ],
            [ // 33
                'name'  => 'dr. RM Arjono, SP.JP(K)',
                'slug'  => 'rm.arjono',
                'desc'  => "",
                'image' => '',
            ],
            [ // 34
                'name'  => 'dr. Royhan Rozqie, PhD, Sp.JP',
                'slug'  => 'royhan.rozqie',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/royhan.rozqie.jpeg',
            ],
            [ // 35
                'name'  => 'dr. Suryo Prabowo, Sp.JP',
                'slug'  => 'suryo.prabowo',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/suryo.prabowo.jpeg',
            ],
            [ // 36
                'name'  => 'dr. Vita Yanti Anggraeni, Sp.PD, Sp.JP, Ph.D',
                'slug'  => 'vita.yanti',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/vita.yanti.jpeg',
            ],
            [ // 37
                'name'  => 'dr. Wahyu Himawan, Sp.JP',
                'slug'  => 'wahyu.himawan',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/wahyu.himawan.jpeg',
            ],
            [ // 38
                'name'  => 'dr. Yuli Astuti, Sp.PD, Sp.JP',
                'slug'  => 'yuli.astuti',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/yuli.astuti.jpg',
            ],
            [ // 39
                'name'  => 'dr. Fera Hidayati,Sp.JP(K)',
                'slug'  => 'fera.hidayati',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/fera.hidayati.png',
            ],
            [ // 40
                'name'  => 'Dr.Med dr. Putrika Prastuti Ratna Gharini Sp.JP (K)',
                'slug'  => 'putrika.prastuti',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/putrika.prastuti.jpg',
            ],
            [ // 41
                'name'  => 'Prof. Dr. dr. Bambang Irawan, Sp.PD(K), Sp.JP',
                'slug'  => 'bambang.irawan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/bambang.irawan.jpeg',
            ],
            [ //42
                'name'  => 'Prof. Dr. dr. Budi Yuli Setianto, Sp.PD.KKV, Sp.JP(K)',
                'slug'  => 'budi.yuli',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo/budi.yuli.jpg',
            ],
//            [ // 43
//                'name'  => "dr. Aninditha Muthmainah, Sp.JP",
//                'slug'  => "aninditha.muthmainah",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 44
//                'name'  => "dr. Erdiansyah, Sp.JP",
//                'slug'  => "erdiansyah",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 45
//                'name'  => "dr. Evita Devi Noor Rahmawati, Sp.JP",
//                'slug'  => "evita.devi",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
            [ // 46
                'name'  => "Prof. Salvatore Di Somma, MD, Ph.D",
                'slug'  => "salvatore.disomma",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/salfatore.disomma.jpg',
            ],
//            [ // 47
//                'name'  => "Amin Al-ahmad, MD",
//                'slug'  => "amin.alahmad",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 48
//                'name'  => "Sofian Johar, MD",
//                'slug'  => "sofian.johar",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 49
//                'name'  => "Azlan Husain, MD",
//                'slug'  => "sofian.johar",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 50
//                'name'  => "Prof. Dr. Hamed Oemar, Ph.D, Sp.JP(K)",
//                'slug'  => "hamed.oemar",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 51
//                'name'  => "Prof. Yoga Yuniadi",
//                'slug'  => "yoga.tuniadi",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
            [ // 52
                'name'  => "dr. Muhammad Munawar, Sp.JP(K)",
                'slug'  => "muhammad.munawar",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/muhammad.munawar.jpg',
            ],
//            [ // 53
//                'name'  => "dr. Ismail, Sp.S(K)",
//                'slug'  => "ismail",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/muhammad.munawar.jpg',
//            ],
//            [ // 54
//                'name'  => "dr. Rano, Sp.JP",
//                'slug'  => "rano",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 55
//                'name'  => "dr. Johan Kurnianda, Sp.PD-KHOM",
//                'slug'  => "johan.kurnianda",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 56
//                'name'  => "dr. Siska Suridanda, Sp.JP(K)",
//                'slug'  => "siska.suridanda",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 57
//                'name'  => "dr. Hanif, Sp.KN",
//                'slug'  => "siska.suridanda",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 58
//                'name'  => "dr. Indah, Sp.JP",
//                'slug'  => "indah",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 59
//                'name'  => "dr. Bowo, Sp.PD-KEMD",
//                'slug'  => "bowo",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
//            [ // 60
//                'name'  => "dr. hemi Sinorita, Sp.PD-KEMD",
//                'slug'  => "hemi.sinorita",
//                'desc'  => "",
//                'image' => 'https://src.perki-jogja.com/assets/photo/',
//            ],
            [
                'name'  => "dr. Dewi Suprobo, Sp.JP(K)",
                'slug'  => "dewi.suprobo",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/dewi.hapsari.jpeg',
            ],
            [
                'name'  => "dr. Ade Meidian Ambari, Sp.JP(K)",
                'slug'  => "ade.meidian",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/ade.meidian.jpeg',
            ],
        ];

        foreach ($data as $datum) {
            $user = User::whereSlug($datum['slug'])
                ->first();

            $datum['is_speaker'] = 1;
            $datum['type'] = 'speaker';
            if ($user) {
                $user->update($datum);
            } else {
                User::create($datum);
            }
        }
    }
}
