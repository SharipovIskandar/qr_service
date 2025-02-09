<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramBotController extends Controller
{
    protected $telegram;

    /**
     * @throws TelegramSDKException
     */
    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function handleWebhook(Request $request)
    {
        $update = $this->telegram->getWebhookUpdate();

        $message = $update->getMessage();
        $chatId = $message->getChat()->getId();
        $text = $message->getText();

        if ($text == '/start') {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Salom! QR kodni yaratish uchun matn yuboring yoki QR kodni yuboring.'
            ]);
        }

        // Agar foydalanuvchi matn yuborsa (QR kod generatsiyasi)
        if ($text && $text != '/start') {
            // QR kod yaratish
            $qrCode = QrCode::format('png')->size(300)->generate($text);
            $fileName = 'qrcodes/' . uniqid() . '.png';

            \Storage::disk('public')->put($fileName, $qrCode);

            // Foydalanuvchiga QR kodni yuborish
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'QR kod muvaffaqiyatli yaratildi.',
                'reply_markup' => [
                    'inline_keyboard' => [
                        [
                            ['text' => 'QR Kodni Ko\'rish', 'url' => url('storage/' . $fileName)]
                        ]
                    ]
                ]
            ]);
        }

        if ($message->hasPhoto()) {
            $photo = $message->getPhoto();
            $fileId = $photo[count($photo) - 1]->getFileId();
            $file = $this->telegram->getFile(['file_id' => $fileId]);

            $filePath = $file->getFilePath();
            $downloadUrl = "https://api.telegram.org/file/bot" . env('TELEGRAM_BOT_TOKEN') . "/" . $filePath;

            $filePathLocal = storage_path('app/public/' . uniqid() . '.jpg');
            file_put_contents($filePathLocal, file_get_contents($downloadUrl));

            $qrReader = new QrCodeReader();
            $text = $qrReader->read($filePathLocal);

            if ($text) {
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "QR kod matni: " . $text
                ]);
            } else {
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'QR kodni o\'qishda xato!'
                ]);
            }
        }
    }
}
