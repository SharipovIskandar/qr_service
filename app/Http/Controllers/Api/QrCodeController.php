<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QrCodeRequest;
use App\Utils\MyQrCodeReader;
use Illuminate\Http\Request;
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
        // QR kod faylini olish
        $file = $request->file('qr_code');  // Faylni form-data orqali yuboring

        if (!$file) {
            return response()->json([
                'error' => 'QR kod fayli yuborilmagan!'
            ], 400);
        }

        // Faylni yuklab olish
        $filePath = $file->getRealPath();

        $qrReader = new MyQrCodeReader();
        $text = $qrReader->read($filePath);

        if ($text === null) {
            return response()->json([
                'error' => 'QR kodni o\'qib bo\'lmadi.'
            ], 400);
        }

        return response()->json([
            'message' => 'QR kod muvaffaqiyatli o\'qildi.',
            'data' => $text
        ]);
    }
}


