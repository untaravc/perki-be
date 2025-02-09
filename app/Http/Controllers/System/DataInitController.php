<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use App\Imports\DefaultImport;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataInitController extends BaseController
{
    const TYPE = 1;
    const NAME = 2;
    const EMAIL = 3;
    const PHONE = 4;
    const INSTITUTION = 5;
    const PROVINCE = 6;
    const JOB_TYPE = 7;

    public function init(Request $request)
    {
        switch ($request->section) {
            case 'events':
                $event = new EventCvepController();
                return $event->event_init();
                break;
            case 'speakers':
                $speakers = new SpeakerInitController();
                return $speakers->init_speaker();
                break;
            case 'users':
                $speakers = new UserInitController();
                return $speakers->user_init();
                break;
            default:
                return [
                    'message' => 'section required'
                ];
        }

        // $user = new UserInitController();
        // $user->user_init();

        // $job_type = new JobTypeInitController();
        // $job_type->job_type_init();

        // $cat = new CategoryInitController();
        // $cat->categories_init();

        // $voucher = new VoucherInitController();
        // $voucher->voucher_init();

        return $this->response;
    }

    public function copyContact() {}

    public function importContact(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $rows = $this->active_rows($request);

        if (count($rows) < 1) {
            $this->response['errors'] = "data tidak ditemukan.";
            return $this->response;
        }

        // Validasi
        $errors = $this->validateData($rows);

        if (count($errors) > 0) {
            $this->response['errors'] = $errors;
            return $this->response;
        }

        // Input Data
        $this->inputData($rows);

        $this->response['message'] = 'Berhasil upload ' . count($rows) . ' data.';
        return $this->response;
    }

    private function active_rows(Request $request)
    {
        $tabs = Excel::toArray(new DefaultImport, $request->file);
        $rows = $tabs[0];

        $active_rows = [];
        foreach ($rows as $cols) {
            if ($cols[0] > 0) {
                $active_rows[] = $cols;
            }
        }
        return $active_rows;
    }

    private function validateData($rows)
    {
        $errors = [];
        foreach ($rows as $col) {
            if (strlen($col[self::EMAIL]) < 10) {
                $errors[] = 'Email dana baris ke ' . $col[0] . ' tidak sesuai.';
            }
        }

        return $errors;
    }

    private function inputData($rows)
    {
        foreach ($rows as $cols) {
            $has_data = Contact::whereEmail($cols[self::EMAIL])->first();
            $has_user = User::whereEmail($cols[self::EMAIL])->first();

            $institution = $has_user ? $has_user->institution : null;
            $province = $has_user ? $has_user->province : null;
            $job_type_code = $has_user ? $has_user->job_type_code : null;
            $phone = $has_user ? $has_user->phone : null;

            if ($has_data) {
                $has_data->update([
                    'phone' => $phone === null ? $cols[self::PHONE] : $has_user->phone,
                    'user_id' => $has_user ? $has_user->id : null,
                    'institution' => $cols[self::INSTITUTION] ?? $institution,
                    'province' => $cols[self::PROVINCE] ?? $province,
                    'job_type_code' => $cols[self::JOB_TYPE] ?? $job_type_code,
                ]);
            } else {
                Contact::create([
                    'type' => $cols[self::TYPE],
                    'name' => $cols[self::NAME],
                    'email' => $cols[self::EMAIL],
                    'phone' => $cols[self::PHONE],
                    'user_id' => $has_user ? $has_user->id : null,
                    'institution' => $cols[self::INSTITUTION] ?? $institution,
                    'province' => $cols[self::PROVINCE] ?? $province,
                    'job_type_code' => $cols[self::JOB_TYPE] ?? $job_type_code,
                ]);
            }
        }
    }

    public function insertToContact()
    {
        $users = User::where('email', '!=', null)->get();
        $updated = 0;
        $created = 0;
        foreach ($users as $user){
            $contact = Contact::whereEmail($user->email)->first();
            if(!$contact){
                Contact::create([
                    'type' => "personal",
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'user_id' => $user->id,
                    'institution' => $user->institution,
                    'province' => $user->province,
                    'job_type_code' => $user->job_type_code,
                ]);
                $created++;
            } else {
                $contact->update([
                    'phone' => $user->phone,
                    'user_id' => $user->id,
                    'institution' => $user->institution,
                    'city' => $user->city,
                    'province' => $user->province,
                    'job_type_code' => $user->job_type_code,
                ]);
                $updated++;
            }
        }

        return [
            'created' => $created,
            'updated' => $updated,
        ];
    }
}
