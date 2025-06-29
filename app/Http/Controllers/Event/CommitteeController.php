<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function committee(Request $request)
    {
        if ($request->ref == '2024') {
            return $this->event2024();
        } else {
            if ($request->section == 'jcu25') {
                return $this->committeeJcu25();
            }
            return $this->event2023();
        }
    }

    private function event2023()
    {
        $data = [];
        $data[] = [
            'title' => "Advisor",
            'users' => [
                ['user' => 'bambang.irawan'],
                ['user' => 'budi.yuli'],
                ['user' => 'arjono'],
                ['user' => 'hariadi.hariawan'],
                ['user' => 'irsad.andi'],
            ],
        ];

        $data[] = [
            'title' => "Executive",
            'users' => [
                ['user' => 'anggoro.budi', 'position' => 'Chairperson'],
                ['user' => 'vita.yanti', 'position' => 'Vice chairperson'],
                ['user' => 'dyah.samti', 'position' => 'Secretary'],
                ['user' => 'lucia.kris', 'position' => 'Treasurer'],
                ['user' => 'hendry.purnasidha', 'position' => 'Sponsorship coordinator'],
            ]
        ];

        $names = [];

        $names[] = [
            'title' => "Scientific Section",
            'users' => [
                ['user' => 'fera.hidayati', 'position' => 'Coordinator'],
                ['user' => 'lucia.kris'],
                ['user' => 'nahar.taufiq'],
                ['user' => 'dyah.wulan'],
                ['user' => 'rizky.amalia'],
            ]
        ];

        $names[] = [
            'title' => "Program Section",
            'users' => [
                ['user' => 'hendry.purnasidha', 'position' => 'Coordinator'],
                ['user' => 'hasanah.mumpuni'],
                ['user' => 'erika.maharani'],
                ['user' => 'annisa.tridamayanti'],
            ]
        ];

        $names[] = [
            'title' => "Registration Section",
            'users' => [
                ['user' => 'royhan.rozqie', 'position' => 'Coordinator'],
                ['user' => 'inggita.hanung'],
            ]
        ];

        $names[] = [
            'title' => "Publication, Website and Documentation Section",
            'users' => [
                ['user' => 'taufik.ismail', 'position' => 'Coordinator'],
                ['user' => 'margono.gatot'],
                ['user' => 'firman.fauzan'],
            ]
        ];

        $names[] = [
            'title' => "Logistic and Consumption Section",
            'users' => [
                ['user' => 'real.kusumanjaya', 'position' => 'Coordinator'],
                ['user' => 'indah.paranita'],
                ['user' => 'evita.devi'],
                ['user' => 'dyah.adhi'],
            ]
        ];

        $names[] = [
            'title' => "Free Paper Section (Abstract, Oral Presentation and Proceeding)",
            'users' => [
                ['user' => 'gahan.satwiko', 'position' => 'Coordinator'],
                ['user' => 'dyah.samti'],
                ['user' => 'arditya.damarkusuma'],
                ['user' => 'firandi.saputra'],
                ['user' => 'dyah.adhi'],
            ]
        ];

        $names[] = [
            'title' => "Equipment, Exhibition, and Accommodation Section",
            'users' => [
                ['user' => 'putrika.prastuti', 'position' => 'Coordinator'],
                ['user' => 'wahyu.himawan'],
                ['user' => 'gagah.buana'],
            ]
        ];

        $names[] = [
            'title' => "The sixth JINCARTOS 2023",
            'users' => [
                ['user' => 'dyah.wulan', 'position' => 'Coordinator'],
                ['user' => 'royhan.rozqie'],
                ['user' => 'dyah.samti'],
            ]
        ];

        $names[] = [
            'title' => "Alumni Gathering",
            'users' => [
                ['user' => 'bagus.andi', 'position' => 'Coordinator'],
                ['user' => 'hari.yusti'],
            ]
        ];

        //        $names[] = [
        //            'title' => "Secretariat",
        //            'users' => [
        //                ['user' => 'latifah.wulan', 'position' => 'Coordinator'],
        //                ['user' => 'aris.widaryanti'],
        //                ['user' => 'ice.suciati'],
        //                ['user' => 'beti.meitasari'],
        //                ['user' => 'intan.rengganis'],
        //            ]
        //        ];

        $user = User::where('is_speaker', 1)
            ->select('image', 'name', 'slug', 'desc')
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            for ($u = 0; $u < count($data[$i]['users']); $u++) {
                $selected = $user->where('slug', $data[$i]['users'][$u]['user'])->first();

                if ($selected) {
                    $data[$i]['users'][$u]['data'] = $selected;
                }
            }
        }

        for ($i = 0; $i < count($names); $i++) {
            for ($u = 0; $u < count($names[$i]['users']); $u++) {
                $selected = $user->where('slug', $names[$i]['users'][$u]['user'])->first();

                if ($selected) {
                    $names[$i]['users'][$u]['data'] = $selected;
                }
            }
        }

        $this->response['result']['photos'] = $data;
        $this->response['result']['name'] = $names;
        return $this->response;
    }

    private function event2024()
    {
        $data = [];
        $data[] = [
            'title' => "Advisor",
            'users' => [
                ['user' => 'bambang.irawan'],
                ['user' => 'budi.yuli'],
                ['user' => 'real.kusumanjaya'],
                ['user' => 'hariadi.hariawan'],
                ['user' => 'irsad.andi'],
            ],
        ];

        $data[] = [
            'title' => "Executive",
            'users' => [
                ['user' => 'fera.hidayati', 'position' => 'Chairperson'],
                ['user' => 'firandi.saputra', 'position' => 'Vice chairperson'],
                ['user' => 'monika.putri', 'position' => 'Secretary'],
                ['user' => 'dyah.wulan', 'position' => 'Treasurer'],
                ['user' => 'dyah.samti', 'position' => 'Treasurer'],
                // ['user' => 'hendry.purnasidha', 'position' => 'Sponsorship coordinator'],
                // ['user' => 'bagus.a', 'position' => 'Sponsorship coordinator'],
            ]
        ];

        $names = [];

        $names[] = [
            'title' => "Scientific Section",
            'users' => [
                ['user' => 'anggoro.budi', 'position' => 'Coordinator'],
                ['user' => 'lucia.kris'],
                ['user' => 'nahar.taufiq'],
            ]
        ];

        $names[] = [
            'title' => "Program Section",
            'users' => [
                ['user' => 'dyah.wulan', 'position' => 'Coordinator'],
                ['user' => 'hasanah.mumpuni'],
                ['user' => 'erika.maharani'],
            ]
        ];

        $names[] = [
            'title' => "Registration Section",
            'users' => [
                ['user' => 'monika.putri', 'position' => 'Coordinator'],
            ]
        ];

        $names[] = [
            'title' => "Publication, Website and Documentation Section",
            'users' => [
                ['user' => 'taufik.ismail', 'position' => 'Coordinator'],
                ['user' => 'royhan.rozqie'],
                ['user' => 'angga.dwi'],
            ]
        ];

        $names[] = [
            'title' => "Logistic Section",
            'users' => [
                ['user' => 'dyah.adhi', 'position' => 'Coordinator'],
                ['user' => 'anindhita.muthmaina'],
            ]
        ];

        $names[] = [
            'title' => "Free Paper Section (Abstract, Oral Presentation and Proceeding)",
            'users' => [
                ['user' => 'arditya.damarkusuma', 'position' => 'Coordinator'],
                ['user' => 'gahan.satwiko'],
            ]
        ];

        $names[] = [
            'title' => "Equipment, Exhibition, and Accommodation Section",
            'users' => [
                ['user' => 'billy.aditya', 'position' => 'Coordinator'],
                ['user' => 'putrika.prastuti'],
            ]
        ];

        // $names[] = [
        //     'title' => "The sixth JINCARTOS 2023",
        //     'users' => [
        //         ['user' => 'dyah.wulan', 'position' => 'Coordinator'],
        //         ['user' => 'royhan.rozqie'],
        //         ['user' => 'dyah.samti'],
        //     ]
        // ];

        $names[] = [
            'title' => "Alumni Gathering",
            'users' => [
                ['user' => 'erdiansyah.zulyadaini', 'position' => 'Coordinator'],
            ]
        ];

        //        $names[] = [
        //            'title' => "Secretariat",
        //            'users' => [
        //                ['user' => 'latifah.wulan', 'position' => 'Coordinator'],
        //                ['user' => 'aris.widaryanti'],
        //                ['user' => 'ice.suciati'],
        //                ['user' => 'beti.meitasari'],
        //                ['user' => 'intan.rengganis'],
        //            ]
        //        ];

        $user = User::where('is_speaker', 1)
            ->select('image', 'name', 'slug', 'desc')
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            for ($u = 0; $u < count($data[$i]['users']); $u++) {
                $selected = $user->where('slug', $data[$i]['users'][$u]['user'])->first();

                if ($selected) {
                    $data[$i]['users'][$u]['data'] = $selected;
                }
            }
        }

        for ($i = 0; $i < count($names); $i++) {
            for ($u = 0; $u < count($names[$i]['users']); $u++) {
                $selected = $user->where('slug', $names[$i]['users'][$u]['user'])->first();

                if ($selected) {
                    $names[$i]['users'][$u]['data'] = $selected;
                }
            }
        }

        $this->response['result']['photos'] = $data;
        $this->response['result']['name'] = $names;
        return $this->response;
    }

    private function committeeJcu25()
    {
        $data = [];
        $data[] = [
            'title' => "Advisor",
            'users' => [
                ['user' => 'bambang.irawan'],
                ['user' => 'budi.yuli'],
                ['user' => 'rm.arjono'],
                ['user' => 'real.kusumanjaya'],
                ['user' => 'hariadi.hariawan'],
                ['user' => 'irsad.andi'],
            ],
        ];

        $data[] = [
            'title' => "Executive",
            'users' => [
                ['user' => 'firandi.saputra', 'position' => 'Chairperson'],
                ['user' => 'dyah.adhi', 'position' => 'Vice chairperson'],
                ['user' => 'anindhita.muthmaina', 'position' => 'Treasurer'],
                ['user' => 'dyah.wulan', 'position' => 'Treasurer'],
            ]
        ];

        $data[] = [
            'title' => "Sponsorship Section",
            'users' => [
                ['user' => 'monika.putri', 'position' => 'Coordinator'],
                ['user' => 'real.kusumanjaya'],
                ['user' => 'hendry.purnasidha'],
                ['user' => 'bagus.andi'],
            ]
        ];

        $data[] = [
            'title' => "Scientific Section",
            'users' => [
                ['user' => 'fera.hidayati', 'position' => 'Coordinator'],
                ['user' => 'lucia.kris'],
                ['user' => 'nahar.taufiq'],
                ['user' => 'yuwinda.prima'],
            ]
        ];

        $data[] = [
            'title' => "Program Section",
            'users' => [
                ['user' => 'arditya.damarkusuma', 'position' => 'Coordinator'],
                ['user' => 'anggoro.budi'],
                ['user' => 'erika.maharani'],
                ['user' => 'siti.hana'],
                ['user' => 'helvina.vika'],
            ]
        ];

        $data[] = [
            'title' => "Registration Section",
            'users' => [
                ['user' => 'anindhita.muthmaina', 'position' => 'Coordinator'],
                ['user' => 'yunia.duana'],
                ['user' => 'mutiara.putri'],
            ]
        ];

        $data[] = [
            'title' => "Publication, Website and Documentation Section",
            'users' => [
                ['user' => 'gahan.satwiko', 'position' => 'Coordinator'],
                ['user' => 'royhan.rozqie'],
                ['user' => 'andro.diasmada'],
            ]
        ];

        $data[] = [
            'title' => "Consumption  Section",
            'users' => [
                ['user' => 'hasanah.mumpuni', 'position' => 'Coordinator'],
                ['user' => 'erlinda.pretty'],
            ]
        ];

        $data[] = [
            'title' => "Free Paper Section (Abstract, Oral Presentation and Proceeding)",
            'users' => [
                ['user' => 'dyah.samti', 'position' => 'Coordinator'],
                ['user' => 'yusrina.adani'],
            ]
        ];

        $data[] = [
            'title' => "Equipment, Exhibition, and Accommodation Section",
            'users' => [
                ['user' => 'billy.aditya', 'position' => 'Coordinator'],
                ['user' => 'putrika.prastuti'],
            ]
        ];
        $data[] = [
            'title' => "Information and Technology Section",
            'users' => [
                ['user' => 'angga.dwi', 'position' => 'Coordinator'],
            ]
        ];

        $data[] = [
            'title' => "The Eighth JINCARTOS",
            'users' => [
                ['user' => 'taufik.ismail', 'position' => 'Coordinator'],
            ]
        ];

        $data[] = [
            'title' => "InaPH Section",
            'users' => [
                ['user' => 'dyah.wulan', 'position' => 'Coordinator'],
            ]
        ];

        $data[] = [
            'title' => "Alumni Gathering",
            'users' => [
                ['user' => 'evita.devi', 'position' => 'Coordinator'],
                ['user' => 'inggita.hanung'],
                ['user' => 'candra.kurniawan'],
            ]
        ];

        $data[] = [
            'title' => "Mini Soccer",
            'users' => [
                ['user' => 'faisol.siddiq', 'position' => 'Coordinator'],
                ['user' => 'athanasius.wrin'],
                ['user' => 'adigama.priamas'],
            ]
        ];

        $data[] = [
            'title' => "Secretariat",
            'users' => [
                ['user' => 'latifah.wulan', 'position' => 'Coordinator'],
                ['user' => 'aris.widaryanti'],
                ['user' => 'ice.suciati'],
                ['user' => 'beti.meitasari'],
                ['user' => 'intan.rengganis'],
            ]
        ];

        $user = User::where('is_speaker', 1)
            ->select('image', 'name', 'slug', 'desc')
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            for ($u = 0; $u < count($data[$i]['users']); $u++) {
                $selected = $user->where('slug', $data[$i]['users'][$u]['user'])->first();

                if ($selected) {
                    $data[$i]['users'][$u]['data'] = $selected;
                }
            }
        }

//        for ($i = 0; $i < count($names); $i++) {
//            for ($u = 0; $u < count($names[$i]['users']); $u++) {
//                $selected = $user->where('slug', $names[$i]['users'][$u]['user'])->first();
//
//                if ($selected) {
//                    $names[$i]['users'][$u]['data'] = $selected;
//                }
//            }
//        }

        $this->response['result']['photos'] = $data;
        $this->response['result']['name'] = [];
        return $this->response;
    }
}
