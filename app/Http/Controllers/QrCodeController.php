<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateQrRequest;
use App\Models\QrCode;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class QrCodeController extends Controller
{
    public function generate(GenerateQrRequest $request)
    {
        $text = $request->input('text');
        $filename = 'qr_' . time() . '.png';
        $path = 'qrcodes/' . $filename;

        Storage::disk('public')->put($path, QrCodeGenerator::format('png')->size(300)->generate($text));

        $qrCode = QrCode::create([
            'user_id' => Auth::id() ?? 1,
            'text' => $text,
            'qr_path' => $path
        ]);

        return redirect()->route('qr.index')->with([
            'success' => 'QR kod yaratildi!',
            'qr_url' => asset('storage/' . $path),
            'qr_id' => $qrCode->id
        ]);
    }

    public function download($id)
    {
        $qr = QrCode::findOrFail($id);
        $file = storage_path("app/public/" . $qr->qr_path);

        return Response::download($file, "qr_code.png");
    }
}

