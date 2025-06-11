<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function info(Request $request)
    {
        $data['aim_main'] = [
            'Meningkatkan kapasitas dokter Puskesmas dalam interpretasi EKG untuk menunjang diagnosis dini dan penanganan cepat kasus kardiovaskular.'
        ];
        $data['aims'] = [
            'Meningkatkan kemampuan interpretasi EKG secara cepat dan akurat.',
            'Meningkatkan  kepercayaan  diri  dokter  Puskesmas  dalam  menghadapi  kasus kardiovaskular.',
            'Mendorong penguatan respon kegawatdaruratan kardiovaskular di Puskesmas.',
            'Membangun  jejaring  antar  dokter  layanan  primer  khususnya  di  Daerah  Istimewa Yogyakarta. '
        ];
        $data['participants'] = [
            'Dokter Umum Puskesmas',
            'Dokter Internship Puskesmas'
        ];

        $data['term'] = [
            'Free registrasi untuk babak penyisihan',
            'Peserta babak final wajib terdaftar sebagai peserta symposium JCU-Jincartos 2025',
            'Registrasi dapat dilakukan melalui laman jcu.perki-jogja.com ',
            'Waktu registrasi : 16 Juni – 6 Juli 2025',
        ];

        $data['elimination'] = [
            "date"  => 'Sunday, 13th July 2025',
            "time"  => '10.00 – 12.00 WIB',
            "place" => 'Online via Zoom Meeting Platform',
        ];

        $data['final'] = [
            "date"  => 'Sunday, 3rd August 2025',
            "time"  => '13.00 – 14.00 WIB',
            "place" => 'Hotel Tentrem, Yogyakarta',
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function index(Request $request)
    {
        $data = Group::whereSection($request->section);

    }

    public function create(Request $request)
    {
        $auth = $request->user();
        $this->validateData($request);
        $members = collect($request->input('members'));

        if ($members->isEmpty()) {
            $this->response['success'] = false;
            $this->response['message'] = "Member is required";
            return $this->response;
        }

        $users = User::whereIn('email', $members->pluck('email')->toArray())->get();

        DB::beginTransaction();
        // insert groups
        $group = Group::create([
            "user_id"     => $auth['id'],
            "section"     => "jcu25",
            "category"    => "ecg",
            "name"        => $request->name,
            "institution" => $request->institution,
            "address"     => $request->address,
            "email"       => $request->email,
            "phone"       => $request->phone,
            "status"      => 100,
        ]);

        // insert group detail
        foreach ($members as $member) {
            $user = $users->where('email', $member['email'])->first();
            GroupDetail::create([
                "section"   => $group->section,
                "group_id"  => $group->id,
                "user_id"   => $user ? $user->id : null,
                "user_name" => $member['name'],
                "email"     => $member['email'],
                "phone"     => $member['phone'],
                "flag"      => $member['flag'],
            ]);
        }
        DB::commit();

        return $this->response;
    }

    public function validateData($request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            "institution" => "required",
            "address"     => "required",
            "email"       => "required|email",
            "phone"       => "required|numeric",
        ]);

        if ($validator->fails()) {
            $this->response['errors'] = $validator->errors();
            abort(response($this->response, 422));
        }
    }
}
