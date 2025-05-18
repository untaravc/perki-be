<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Event;
use App\Models\Post;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class UploadFirebaseController extends Controller
{
    public $bucket = 'unt-dev.firebasestorage.app';
    public $base_path = 'Perki';
    protected $firebaseStorage;

    public function __construct()
    {
        $factory = (new Factory())
            ->withServiceAccount(config('services.firebase.credentials_file'))
            ->withDefaultStorageBucket($this->bucket);

        $this->firebaseStorage = $factory->createStorage();
    }

    public function firebaseUpload(Request $request)
    {
        switch ($request->model) {
            case 'document':
                return $this->uploadDocument();
            case 'event':
                return $this->uploadEvent();
            case 'post-image':
                return $this->uploadPostImage();
            case 'transactions':
                return $this->uploadTransaction();
            default:
                return "no model";
        }
    }

    public function uploadDocument()
    {
        $documents = Document::where('link', 'like', 'https://src.perki%')
            ->limit(10)
            ->get();

        $failed = [];
        $success = [];
        foreach ($documents as $document) {
            $dir = str_replace('https://src.perki-jogja.com/', '', $document->link);
            if (strpos($dir, 'https://') === false) {
                $file = public_path($dir);
                if (!file_exists($file)) {
                    $failed[] = $document['id'];
                } else {
                    $bucket = $this->firebaseStorage->getBucket();
                    try {
                        $dir2 = str_replace('storage/', '', $dir);

                        $object = $bucket->upload(
                            fopen($file, 'r'),
                            ['name' => $this->base_path . '/' . $dir2]
                        );

                        $new_firebase_path = 'https://firebasestorage.googleapis.com/v0/b/' .
                            $bucket->name() . '/o/' .
                            str_replace("@", "%40",
                                str_replace('/', '%2F', $object->name())) .
                            '?alt=media';

                        $document->update([
                            'link' => $new_firebase_path,
                        ]);

                        unlink($file);

                        $success[] = $document['id'];
                    } catch (\Exception $e) {
                        $failed[] = $document['id'];
                    }
                }
            }
        }

        return [
            'success' => $success,
            'failed'  => $failed,
        ];
    }

    public function uploadEvent()
    {
        $documents = Event::where('image', 'like', '/assets%')
            ->limit(50)
            ->get();

        $failed = [];
        $success = [];
        foreach ($documents as $document) {
            $dir = $document->image;
            if (strpos($dir, 'https://') === false) {
                $file = public_path($dir);
                if (!file_exists($file)) {
                    $failed[] = $document['id'];
                } else {
                    $bucket = $this->firebaseStorage->getBucket();
//                    try {
                        $dir2 = str_replace('storage/', '', $dir);

                        $object = $bucket->upload(
                            fopen($file, 'r'),
                            ['name' => $this->base_path . '/Events' . $dir2]
                        );

                        $new_firebase_path = 'https://firebasestorage.googleapis.com/v0/b/' .
                            $bucket->name() . '/o/' .
                            str_replace("@", "%40",
                                str_replace('/', '%2F', $object->name())) .
                            '?alt=media';

                        $document->update([
                            'image' => $new_firebase_path,
                        ]);

                        unlink($file);

                        $success[] = $document['id'];
//                    } catch (\Exception $e) {
//                        $failed[] = $document['id'];
//                    }
                }
            }
        }

        return [
            'success' => $success,
            'failed'  => $failed,
        ];
    }

    public function uploadPostImage()
    {
        $documents = Post::where('image', 'like', 'https://src.perki-%')
            ->limit(10)
            ->get();

        $failed = [];
        $success = [];
        foreach ($documents as $document) {
            $dir = str_replace('https://src.perki-jogja.com/', '', $document->image);
            if (strpos($dir, 'https://') === false) {
                $file = public_path($dir);
                if (!file_exists($file)) {
                    $failed[] = $document['id'];
                } else {
                    $bucket = $this->firebaseStorage->getBucket();
                    try {
                        $dir2 = str_replace('storage/', '', $dir);

                        $object = $bucket->upload(
                            fopen($file, 'r'),
                            ['name' => $this->base_path . '/PostImages/' . $dir2]
                        );

                        $new_firebase_path = 'https://firebasestorage.googleapis.com/v0/b/' .
                            $bucket->name() . '/o/' .
                            str_replace("@", "%40",
                                str_replace('/', '%2F', $object->name())) .
                            '?alt=media';

                        $document->update([
                            'image' => $new_firebase_path,
                        ]);

                        unlink($file);

                        $success[] = $document['id'];
                    } catch (\Exception $e) {
                        $failed[] = $document['id'];
                    }
                }
            }
        }

        return [
            'success' => $success,
            'failed'  => $failed,
        ];
    }

    public function uploadTransaction()
    {
        $documents = Transaction::where('transfer_proof', 'like', 'https://src.perki-%')
            ->limit(1)
            ->get();

        $failed = [];
        $success = [];
        foreach ($documents as $document) {
            $dir = str_replace('https://src.perki-jogja.com/', '', $document->transfer_proof);
            if (strpos($dir, 'https://') === false) {
                return $file = public_path($dir);
                if (!file_exists($file)) {
                    $failed[] = $document['id'];
                } else {
                    return $bucket = $this->firebaseStorage->getBucket();
                    try {
                        $dir2 = str_replace('storage/', '', $dir);

                        $object = $bucket->upload(
                            fopen($file, 'r'),
                            ['name' => $this->base_path . '/Transactions/' . $dir2]
                        );

                        $new_firebase_path = 'https://firebasestorage.googleapis.com/v0/b/' .
                            $bucket->name() . '/o/' .
                            str_replace("@", "%40",
                                str_replace('/', '%2F', $object->name())) .
                            '?alt=media';

                        $document->update([
                            'transfer_proof' => $new_firebase_path,
                        ]);

                        unlink($file);

                        $success[] = $document['id'];
                    } catch (\Exception $e) {
                        $failed[] = $document['id'];
                    }
                }
            }
        }

        return [
            'success' => $success,
            'failed'  => $failed,
        ];
    }

    public function getDir(Request $request)
    {
        $bucket = $this->firebaseStorage->getBucket();

        $objects = $bucket->objects([
            'prefix' => "KaryawanLog/" . $request->karyawan_id . "/",
            // 'delimiter' => '/',
        ]);

        $array = [];

        foreach ($objects as $object) {
            $fileName = $object->name();

            // Check if the file has a .log extension
            if (pathinfo($fileName, PATHINFO_EXTENSION) === 'log') {

                // Get the file content
                $stream = $object->downloadAsStream();
                $content = $stream->getContents();

                // Output the content
                $array[] = json_decode($content);
            }
        }

        return collect($array);
    }
}
