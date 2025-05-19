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

        return 'Success';
    }

    private function speakers()
    {
        $data = [
            [
                'name'  => 'dr. Anggia Endah Satuti, Sp.JP(K)',
                'slug'  => 'anggia.endah',
                'desc'  => "",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv1%2Fanggia.endah.jpg?alt=media&token=e99e06fc-f0fa-4fc2-8575-7be66e3ceba3',
            ],
            [
                'name'  => 'Prof. Dr. dr. Anggoro Budi Hartopo.,Ph.D, Sp.PD, Sp.JP',
                'slug'  => 'anggoro.budi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fanggoro.budi.png?alt=media&token=3da8f5c9-5a3f-401c-823f-0913279f9a42',
            ],
            [
                'name'  => 'dr. Arditya Damarkusuma, M.Med(ClinEpi), Sp.JP(K)',
                'slug'  => 'arditya.damarkusuma',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Farditya.damarkusuma.png?alt=media&token=954dbc7d-71c0-4ac9-b02a-75573637bf72',
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
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fhariadi.hariawan.png?alt=media&token=2d8955a2-fb15-4a46-97ce-3dd2ffc3c85c',
            ],
            [
                'name'  => 'Prof. Dr. dr. Lucia Kris Dinarti, SpPD, Sp.JP(K)',
                'slug'  => 'lucia.kris',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Flucia.kris.png?alt=media&token=cbabf2ec-b445-4723-9933-ef3f24f60b44',
            ],
            [
                'name'  => 'Dr. dr. Nahar Taufiq, Sp.JP(K)',
                'slug'  => 'nahar.taufiq',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fnahar.taufiq.png?alt=media&token=321b775e-844f-4659-b697-dc79bcee0c74',
            ],
            [
                'name'  => 'dr. Dyah Adhi Kusumastuti, Sp.JP(K)',
                'slug'  => 'dyah.adhi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fdyah.adhi.png?alt=media&token=8f2f8c15-7a64-4f4d-a6c8-635a9fd213b5',
            ],
            [
                'name'  => 'dr. Dyah Samti Mayasari, Ph.D, Sp.JP(K)',
                'slug'  => 'dyah.samti',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fdyah.samti.png?alt=media&token=5034aacd-eb19-415c-aead-bef50e284c54',
            ],
            [
                'name'  => 'dr. Dyah Wulan Anggrahini, Ph.D, Sp.JP(K)',
                'slug'  => 'dyah.wulan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fdyah.wulan.png?alt=media&token=c154917e-3b59-467a-a318-8376d4fc8be5',
            ],
            [
                'name'  => 'dr. Erika Maharani, Sp.JP(K)',
                'slug'  => 'erika.maharani',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Ferika.maharani.png?alt=media&token=3d70be1b-c8a9-46a4-ae82-f34923d97c81',
            ],
            [
                'name'  => 'dr. Firandi Saputra, Sp.JP(K)',
                'slug'  => 'firandi.saputra',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Ffirandi.saputra.png?alt=media&token=0443f747-8bd5-4b9a-bf4b-05e03cfda498',
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
            [
                'name'  => 'dr. Hasanah Mumpuni, SpPD, Sp.JP(K)',
                'slug'  => 'hasanah.mumpuni',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fhasanah.mumpuni.png?alt=media&token=2dda8887-d9da-46b1-92cb-897d4cd5d4e7',
            ],
            [
                'name'      => 'dr. Hendry Purnasidha Bagaswoto Sp.JP(K)',
                'slug'      => 'hendry.purnasidha',
                'desc'      => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image'     => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fhendry.punasidha.png?alt=media&token=2add2e52-78c9-49e1-9285-2ef8471c794e',
                'biography' => "Dr. Hendry Purnasidha Bagaswoto, Sp.JP(K), has a rich academic background in the field of cardiology and emergency care. He obtained his Medical Doctor degree from Universitas Gadjah Mada in 2008 and later specialized as a Cardiologist at the same university in 2015. Dr. Bagaswoto furthered his expertise by becoming a Consultant of Interventional Cardiology at Dr. Sardjito Hospital in Yogyakarta in 2018 and then joined the National Cardiovascular Center Harapan Kita in Jakarta as a Consultant of Acute, Intensive, and Cardiovascular Emergency in 2019.
                <br/>
                Currently, Dr. Bagaswoto serves as a Consultant of Acute, Intensive, and Cardiovascular Emergency Care, specializing in Cardiology Intervention. He is also actively engaged as a staff member at the Department of Cardiology and Vascular Medicine within the Faculty of Medicine, Public Health, and Nursing at Universitas Gadjah Mada, contributing significantly to research and patient care in these fields."
            ],
            [
                'name'  => 'dr. Irsad Andi Arso Sp.PD, Sp.JP(K)',
                'slug'  => 'irsad.andi',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Firsad.andi.png?alt=media&token=8766eec3-7516-4677-84e5-20358ab6aa0d',
            ],
            [
                'name'  => 'dr. Lidwina Tarigan, Sp.JP(K)',
                'slug'  => 'lidwina.tarigan',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/lidwina.tarigan.jpg',
            ],
            [ // 23
                'name'  => 'dr. Lima Peni, Sp.JP(K)',
                'slug'  => 'lima.peni',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/lima.peni.jpg',
            ],
            [ // 24
                'name'  => 'dr. Muhammad Ulil Aidie Jomansyah, Sp.JP',
                'slug'  => 'm.ulil',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/ulil.jpg',
            ],
            [ // 25
                'name'  => 'dr. Muhammad Gahan Satwiko, Sp.JP, Ph.D',
                'slug'  => 'gahan.satwiko',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fgahan.satwiko.png?alt=media&token=ea6ac6db-0eb3-433e-a88d-0221f805c521',
            ],
            [ // 26
                'name'  => 'dr. Muhammad Yulianto Sismoyo, Sp.JP',
                'slug'  => 'yulianto.sismoyo',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/yulianto.sismoyo.jpg',
            ],
            [ // 27
                'name'  => 'dr. Margono Gatot Suwandi, Sp.JP(K)',
                'slug'  => 'margono.gatot',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/margono.gatot.png',
            ],
            [ // 28
                'name'  => 'Dr. dr. Muhammad Taufik Ismail, Sp.JP(K)',
                'slug'  => 'taufik.ismail',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Ftaufik.ismail.png?alt=media&token=5394e843-04e4-4ba7-aa0e-5b3e3859924a',
            ],
            [ // 29
                'name'  => 'dr. Pamrayogi Hutomo, Sp.JP',
                'slug'  => 'pamrayogi.hutomo',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/pamrayogi.hutomo.jpg',
            ],
            [ // 30
                'name'  => 'dr. Real Kusumanjaya Marsam, Sp.JP(K)',
                'slug'  => 'real.kusumanjaya',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Freal.kusumanjaya.png?alt=media&token=c427c532-42c1-483b-af47-9810c6b3a103',
            ],
            [ // 31
                'name'  => 'dr. Rendi Asmara, Sp.JP(K)',
                'slug'  => 'rendi.asmara',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/rendi.asmara.jpg',
            ],
            [ // 32
                'name'  => 'dr. Rizki Amalia Gumilang, Sp.JP',
                'slug'  => 'riski.amalia',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/riski.amalia.jpeg.jpg',
            ],
            [ // 33
                'name'  => 'dr. RM. Arjono, Sp.PD., Sp.Jp(K)',
                'slug'  => 'rm.arjono',
                'desc'  => "",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv1%2Frm.arjono.jpeg?alt=media&token=4f0c0487-7921-4a27-9bfa-e8f67319380d',
            ],
            [ // 34
                'name'  => 'dr. Royhan Rozqie, Ph.D, Sp.JP',
                'slug'  => 'royhan.rozqie',
                'desc'  => "",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Froyhan.rozqie.png?alt=media&token=21b3b6ee-6d1c-4a80-b04d-8213a33bc266',
            ],
            [ // 35
                'name'  => 'dr. Suryo Prabowo, Sp.JP',
                'slug'  => 'suryo.prabowo',
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/suryo.prabowo.jpeg',
            ],
            [ // 36
                'name'  => 'dr. Vita Yanti Anggraeni, Ph.D, Sp.PD, Sp.JP',
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
                'name'  => 'Dr.Med dr. Putrika Prastuti Ratna Gharini Sp.JP(K)',
                'slug'  => 'putrika.prastuti',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fputrika.prastuti.png?alt=media&token=4b31b08d-aed4-4d8f-ac1b-796bd051a4d1',
            ],
            [ // 41
                'name'  => 'Prof. Dr. dr. Bambang Irawan, Sp.PD(K), Sp.JP',
                'slug'  => 'bambang.irawan',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv1%2Fbambang.irawan.jpeg?alt=media&token=0b266c67-3dff-4b53-b652-deb1775e013d',
            ],
            [ //42
                'name'  => 'Prof. Dr. dr. Budi Yuli Setianto, Sp.PD.KKV, Sp.JP(K)',
                'slug'  => 'budi.yuli',
                'desc'  => "Department of Cardiology & Vascular Medicine, FKKMK, UGM",
                'image' => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fbudi.yuli.png?alt=media&token=31dd3f01-54bd-4db1-8331-0b6572a3ca5e',
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
                'name'  => "Thomas Weiler, MD",
                'slug'  => "thomas.weiler",
                'desc'  => "",
                'image' => 'https://src.perki-jogja.com/assets/photo/thomas.weiler.jpeg',
            ],
            [
                'name'  => "dr. Pipin Ardhianto, Sp.JP(K)",
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
                'name'  => "dr. RR. Hari Hendriarti Satoto, Sp. Jp(K)",
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
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fbilly.aditya.jpg?alt=media&token=cc0070c6-0571-484e-ab3c-860439d2296e",
            ],
            [
                'name'  => "dr. Faisol Siddiq, Sp.JP",
                'slug'  => "faisol.siddiq",
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
                'name'  => "dr. Anindhita Muthmaina, Sp.JP",
                'slug'  => "anindhita.muthmaina",
                'desc'  => "",
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv3%2Fanindhita.muthmaina.jpeg?alt=media&token=8dc7487c-4d0d-4ae6-8763-b1dde71c9a37",
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
            [
                'name'  => "Dr. dr. Basuni Radi, S",
                'slug'  => "basuni.radi",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Mohamad Afis S, Sp.JP",
                'slug'  => "moh.afis",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Hemi Sinorita, Sp.PD-KEMD",
                'slug'  => "hemi.sinorita",
                'desc'  => "",
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv3%2Fhemi.sinorita.png?alt=media&token=e00d9bff-9aec-43ed-8d2b-d475010aaf21",
            ],
            [
                'name'  => "dr. Rizka Humardewayanti Asdie, Sp.PD-KPTI",
                'slug'  => "rizka.humardewayanti",
                'desc'  => "",
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv3%2Frizka.humardewayanti.png?alt=media&token=046875b4-0e5b-4451-ae74-c6f56db0d3a6",
            ],
            [
                'name'  => "dr. Yunanto Kurnia, Sp. BTKV, Subsp. VE (K)",
                'slug'  => "yunanto.kurnia",
                'desc'  => "",
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv3%2Fyunanto.kurnia.png?alt=media&token=355858c7-9e7c-48ad-9509-7f3ee0ad2006",
            ],
            [
                'name'  => "dr. Meirizal Hasan, Sp.OT (K)",
                'slug'  => "meirizal.hasan",
                'desc'  => "",
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fmeirizal.hasan.png?alt=media&token=07d7a80c-9550-491b-8107-a07b45e19445",
            ],
            [
                'name'  => "dr. Ardicho Irfantian, MMR",
                'slug'  => "ardicho.irfantian",
                'desc'  => "",
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fardicho.irfantian.jpeg?alt=media&token=709637a1-f6ae-4fc4-bf0d-af43d2ea2931",
            ],
            [
                'name'  => "Prof. Dr. Christantie Effendy, S.Kep, M. Kes",
                'slug'  => "christantie.effendy",
                'desc'  => "",
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv3%2Fchristantie.effendy.png?alt=media&token=e7b8658e-1b9f-4967-92e1-8dfe135eb55e",
            ],
            [
                'name'  => "Ns. Sofiawati, A.Md. TKv",
                'slug'  => "sofiawati",
                'desc'  => "",
                'image' => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FSpeakers%2Fv2%2Fsofiawati.png?alt=media&token=e437f0b7-b471-4360-ab47-2ef2af49d49b",
            ],
            [
                'name'  => "dr. Yuwinda Prima Ardelia, Sp.JP",
                'slug'  => "yuwinda.prima",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Siti Hanna Armarandra, Sp.JP",
                'slug'  => "siti.hana",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Helvina Vika Etami, Sp.JP",
                'slug'  => "helvina.vika",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Yunia Duana, Sp.JP",
                'slug'  => "yunia.duana",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Mutiara Putri, Sp.JP",
                'slug'  => "mutiara.putri",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Erlinda Pretty Laksneri, Sp.JP",
                'slug'  => "erlinda.pretty",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Yusrina Adani, Sp.JP",
                'slug'  => "yusrina.adani",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Evita Devi Noor Rahmawati, Sp.JP(K)",
                'slug'  => "evita.devi",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Candra Kurniawan, Sp.JP",
                'slug'  => "candra.kurniawan",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Athanasius Wrin Hundoyo, Ph.D., Sp.JP",
                'slug'  => "athanasius.wrin",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Adigama Priamas Febrianto, Sp.JP",
                'slug'  => "adigama.priamas",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "Latifah Wulan",
                'slug'  => "latifah.wulan",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "Aris Widaryanti",
                'slug'  => "aris.widaryanti",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "Ice Suciati",
                'slug'  => "ice.suciati",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "Beti Maitasari",
                'slug'  => "beti.meitasari",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "Intan Rengganis",
                'slug'  => "intan.rengganis",
                'desc'  => "",
                'image' => "",
            ],
            [
                'name'  => "dr. Andro Diasmada, Sp.JP",
                'slug'  => "andro.diasmada",
                'desc'  => "",
                'image' => "",
            ],
        ];

        foreach ($data as $datum) {
            $user = User::whereSlug($datum['slug'])
                ->first();

            $datum['is_speaker'] = 1;
            $datum['type'] = 'speaker';
            if ($user) {
                $user->update([
                    'type'       => $datum['type'],
                    'name'       => $datum['name'],
                    'slug'       => $datum['slug'],
                    'image'      => $datum['image'],
                    'is_speaker' => $datum['is_speaker'],
                ]);
            } else {
                User::create($datum);
            }
        }
    }
}
