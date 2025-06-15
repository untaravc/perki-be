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

    public function mine(Request $request)
    {
        $auth = $request->user();
        $data = Group::whereUserId($auth->id)
            ->with('members')->first();

        if($data){
            $this->response['result'] = $data;
            return $this->response;
        }

        $this->response['success'] = false;
        return $this->response;
    }

    public function index(Request $request)
    {
        $auth = $request->user();
        $data = Group::whereSection($request->section)
            ->whereuserId($auth['id'])
            ->with('members')
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }

    public function store(Request $request)
    {
        $auth = $request->user();
        $this->validateData($request);
        $members = collect($request->input('members'));

        $complete = true;
        foreach ($members as $member) {
            if (strlen($member['user_name']) < 2) {
                $complete = false;
            }
            if (strlen($member['institution']) < 2) {
                $complete = false;
            }
//            if(strlen($member['document_link']) < 2){$complete = false;}
        }

        if ($members->isEmpty() || !$complete) {
            $this->response['success'] = false;
            $this->response['message'] = "Member is required";
            return $this->response;
        }

        DB::beginTransaction();
        // insert groups
        $group = Group::create([
            "user_id"  => $auth['id'],
            "section"  => "jcu25",
            "category" => "ecg",
            "name"     => $request->name,
            "address"  => $request->address,
            "email"    => $request->email,
            "phone"    => $request->phone,
            "status"   => 100,
        ]);

        // insert group detail
        foreach ($members as $member) {
            GroupDetail::create([
                "section"       => $group->section,
                "group_id"      => $group->id,
                "user_id"       => "",
                "user_name"     => $member['user_name'],
                "flag"          => $member['flag'],
                "institution"   => $member['institution'],
                "document_link" => $member['document_link'],
            ]);
        }
        DB::commit();

        return $this->response;
    }

    public function update(Request $request, $id)
    {
        $auth = $request->user();
        $this->validateData($request);
        $members = collect($request->input('members'));

        $complete = true;
        foreach ($members as $member) {
            if (strlen($member['user_name']) < 2) {
                $complete = false;
            }
            if (strlen($member['institution']) < 2) {
                $complete = false;
            }
        }

        if ($members->isEmpty() || !$complete) {
            $this->response['success'] = false;
            $this->response['message'] = "Member is required";
            return $this->response;
        }

        $group = Group::whereUserId($auth['id'])
            ->find($id);

        if ($group) {
            $group->update([
                "name"    => $request->name,
                "address" => $request->address,
                "email"   => $request->email,
                "phone"   => $request->phone,
            ]);
        }

        foreach ($members as $member) {
            if ($member['id']) {
                $detail = GroupDetail::find($member['id']);
                if ($detail) {
                    $detail->update([
                        "user_name"     => $member['user_name'],
                        "flag"          => $member['flag'],
                        "institution"   => $member['institution'],
                        "document_link" => $member['document_link'],
                    ]);
                }
            }
        }

        return $this->response;
    }

    public function validateData($request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            "address" => "required",
            "email"   => "required|email",
            "phone"   => "required|numeric",
        ]);

        if ($validator->fails()) {
            $this->response['success'] = false;
            $this->response['errors'] = $validator->errors();
            $this->response['message'] = "Please fill in all the required fields.";
            abort(response($this->response, 422));
        }
    }

    public function show(Request $request, $id)
    {
        $auth = $request->user();
        $data = Group::whereuserId($auth['id'])
            ->with('members')
            ->find($id);

        $this->response['result'] = $data;
        return $this->response;
    }
}
