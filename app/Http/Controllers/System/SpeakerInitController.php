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
                'image' => 'https://src.perki-jogja.com/assets/photo2/anggoro.budi.png',
            ],
            [
                'name'  => 'dr. Arditya Damarkusuma, M.Med(ClinEpi), Sp.JP',
                'slug'  => 'arditya.damarkusuma',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/arditya.damarkusuma.png',
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
                'image' => 'https://src.perki-jogja.com/assets/photo2/hariadi.hariawan.png',
            ],
            [
                'name'  => 'Prof. Dr. dr. Lucia Kris Dinarti, SpPD, SpJP(K)',
                'slug'  => 'lucia.kris',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/lucia.kris.png',
            ],
            [
                'name'  => 'Dr. dr. Nahar Taufiq, Sp.JP(K)',
                'slug'  => 'nahar.taufiq',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/nahar.taufiq.png',
            ],
            [
                'name'  => 'dr. Dyah Adhi Kusumastuti, Sp.JP',
                'slug'  => 'dyah.adhi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/dyah.adhi.png',
            ],
            [
                'name'  => 'dr. Dyah Samti Mayasari, PhD, Sp.JP',
                'slug'  => 'dyah.samti',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/dyah.samti.png',
            ],
            [
                'name'  => 'dr. Dyah Wulan Anggrahini, Ph.D, Sp.JP(K)',
                'slug'  => 'dyah.wulan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/dyah.wulan.png',
            ],
            [
                'name'  => 'dr. Erika Maharani, SpJP(K)',
                'slug'  => 'erika.maharani',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photow/erika.maharani.png',
            ],
            [
                'name'  => 'dr. Firandi Saputra, Sp.JP(K)',
                'slug'  => 'firandi.saputra',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/firandi.saputra.png',
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
                'image' => 'https://src.perki-jogja.com/assets/photo2/hasanah.mumpuni.png',
            ],
            [
                'name'      => 'dr. Hendry Purnasidha Bagaswoto Sp.JP(K)',
                'slug'      => 'hendry.purnasidha',
                'desc'      => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image'     => 'https://src.perki-jogja.com/assets/photo/hendry.purnasidha.png',
                'biography' => "Dr. Hendry Purnasidha Bagaswoto, Sp.JP(K), has a rich academic background in the field of cardiology and emergency care. He obtained his Medical Doctor degree from Universitas Gadjah Mada in 2008 and later specialized as a Cardiologist at the same university in 2015. Dr. Bagaswoto furthered his expertise by becoming a Consultant of Interventional Cardiology at Dr. Sardjito Hospital in Yogyakarta in 2018 and then joined the National Cardiovascular Center Harapan Kita in Jakarta as a Consultant of Acute, Intensive, and Cardiovascular Emergency in 2019.
                <br/>
                Currently, Dr. Bagaswoto serves as a Consultant of Acute, Intensive, and Cardiovascular Emergency Care, specializing in Cardiology Intervention. He is also actively engaged as a staff member at the Department of Cardiology and Vascular Medicine within the Faculty of Medicine, Public Health, and Nursing at Universitas Gadjah Mada, contributing significantly to research and patient care in these fields."
            ],
            [ // 21
                'name'  => 'dr. Irsad Andi Arso Sp.PD, Sp.JP(K)',
                'slug'  => 'irsad.andi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/irsad.andi.png',
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
                'name'  => 'dr. M.Ulil Aidie Jomansyah, Sp.JP',
                'slug'  => 'm.ulil',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/ulil.jpg',
            ],
            [ // 25
                'name'  => 'dr. Muhammad Gahan Satwiko, Sp.JP, Ph.D',
                'slug'  => 'gahan.satwiko',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://src.perki-jogja.com/assets/photo2/gahan.satwiko.png',
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
                'image' => 'https://src.perki-jogja.com/assets/photo2/taufik.ismail.png',
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
                'image' => 'https://src.perki-jogja.com/assets/photo2/real.kusumanjaya.png',
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
                'image' => 'https://src.perki-jogja.com/assets/photo/rm.arjono.jpeg',
            ],
            [ // 34
                'name'  => 'dr. Royhan Rozqie, PhD, Sp.JP',
                'slug'  => 'royhan.rozqie',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo2/royhan.rozqie.png',
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
                'image' => 'https://src.perki-jogja.com/assets/photo2/putrika.prastuti.png',
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
                'image' => 'https://src.perki-jogja.com/assets/photo2/budi.yuli.png',
            ],
            [ // 43
                'name'  => "dr. Aninditha Muthmainah, Sp.JP",
                'slug'  => "aninditha.muthmainah",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/',
            ],
            [ // 46
                'name'  => "Prof. Salvatore Di Somma, MD, Ph.D",
                'slug'  => "salvatore.disomma",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/salvatore.disomma.jpg',
            ],
            [ // 52
                'name'  => "dr. Muhammad Munawar, Sp.JP(K)",
                'slug'  => "muhammad.munawar",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/muhammad.munawar.jpg',
            ],
            [ // 58
                'name'  => "Prof. Indah Kartika Murni, MD, Ph.D",
                'slug'  => "indah.kartika",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/indah.kartika.png',
            ],
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
            [
                'name'  => "Dr. dr. Probosuseno, SpPD-KGER, SE, MM",
                'slug'  => "probosuseno",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/probosuseno.png',
            ],
            [
                'name'  => "Thomas Weiler, MD ",
                'slug'  => "thomas.weiler",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/thomas.weiler.jpeg',
            ],
            [
                'name'  => "dr. Pipin Ardhianto, SpJP(K)",
                'slug'  => "pipin.ardhianto",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/pipin.ardhianto.jpeg',
            ],
            [
                'name'  => "Dr. dr. Habibie Arifianto, M.Kes, Sp.JP(K)",
                'slug'  => "habibie.arifianto",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/habibie.arifianto.jpeg',
            ],
            [
                'name'  => "dr. Bambang Widyantoro, Ph.D, Sp.JP(K)",
                'slug'  => "bambang.widyantoro",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/bambang.widyantoro.jpg',
            ],
            [
                'name'  => "dr. R. Heru Prasanto, Sp.PD-KGH",
                'slug'  => "heru.prasanto",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/heru.prasanto.jpg',
            ],
            [
                'name'  => "Prof. Ganesan Karthikeyan, MD, Ph.D",
                'slug'  => "ganesan.karthikeyan",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/ganesan.karthikeyan.jpeg',
            ],
            [
                'name'  => "dr. Raden Bowo Pramono, Sp.PD-KEMD",
                'slug'  => "raden.bowo",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/raden.bowo.jpeg',
            ],
            [
                'name'  => "Assoc. Prof. Konlawij Trongtakul, MD",
                'slug'  => "konlawij.trongtrakul",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/konlawij.trongtrakul.jpeg',
            ],
            [
                'name'  => "dr.RR.Hari Hendriarti Satoto, Sp. JP(K)",
                'slug'  => "hari.hendriarti",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/hari.hendriarti.jpeg',
            ],
            [
                'name'  => "Prof. Noriaki Emoto, MD, Ph.D",
                'slug'  => "noriaki.emoto",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/noriaki.emoto.jpeg',
            ],
            [
                'name'  => "dr. Noor Asyiqah Sofia, Sp.PD-KPsi",
                'slug'  => "noor.asyiqah",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/noor.asyiqah.jpeg',
            ],
            [
                'name'  => "Prof. Hyuk Jae Chang",
                'slug'  => "hyuk.jae",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/hyuk.jae.jpeg',
            ],
            [
                'name'  => "Prof. Dr. dr. Amiliana Mardiani Soesanto, Sp.JP(K)",
                'slug'  => "amiliana.soesanto",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/amiliana.soesanto.jpg',
            ],
            [
                'name'  => "dr. Monika Putri Adiningsih, Sp.JP",
                'slug'  => "monika.putri",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Billy Aditya Pratama, Sp.JP",
                'slug'  => "billy.aditya",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Faisol Siddiq, Sp.JP",
                'slug'  => "faisol Siddiq",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Erdiansyah Zulyadaini, Sp.JP",
                'slug'  => "erdiansyah.zulyadaini",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Anindhita Muthmaina, Sp.Jp",
                'slug'  => "anindhita.muthmaina",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Angga Dwi Prasetyo, Sp.JP",
                'slug'  => "angga.dwi",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Inggita Hanung Sulistya, Sp.JP",
                'slug'  => "inggita.hanung",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/inggita.hanung.png',
            ],
            [
                'name'  => "dr. Indah Paranita, Sp.JP",
                'slug'  => "indah.paranita",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/indah.paranita.jpg',
            ],
            [
                'name'  => "dr. I Nyoman Wiryawan, Sp.JP(K). FAPCS",
                'slug'  => "nyoman.wiryawan",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/nyoman.wiryawan.jpeg',
            ],
        ];

        foreach ($data as $datum) {
            $user = User::whereSlug($datum['slug'])
                ->first();

            $datum['is_speaker'] = 1;
            $datum['type'] = 'speaker';
            if ($user) {
                $user->update([
                    'name'  => $datum['name'],
                    'slug'  => $datum['slug'],
                    'desc'  => $datum['desc'],
                    'image' => $datum['image'],
                ]);
            } else {
                User::create($datum);
            }
        }
    }
}
