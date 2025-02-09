<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QrCodeRequest;
use Illuminate\Http\Request;
use BaconQrCode\Reader\QrReader;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate(QrCodeRequest $request)
    {
        $text = $request->input('text');

        if (!$text) {
            return response()->json([
                'error' => 'Matnni kiritish kerak!'
            ], 400);
        }

        $qrCode = QrCode::format('png')->size(300)->generate($text);

        $fileName = 'qrcodes/' . uniqid() . '.png';

        \Storage::disk('public')->put($fileName, $qrCode);

        return response()->json([
            'message' => 'QR kod muvaffaqiyatli yaratildi.',
            'file_path' => url('storage/' . $fileName)
        ]);
    }

    public function read(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        $file = $request->file('file');
        $imagePath = $file->store('temp', 'public');
        $fullPath = storage_path('app/public/' . $imagePath);

        // QR kodni o'qish
        $qrReader = new QrReader($fullPath);
        $result = $qrReader->decode();

        if (!$result) {
            return response()->json(['error' => 'QR kodni o‘qishda xatolik yuz berdi.'], 400);
        }

        return response()->json([
            'message' => 'QR kod muvaffaqiyatli o‘qildi.',
            'data' => $result->getText(), // O'qilgan ma'lumot
        ]);
    }
}


