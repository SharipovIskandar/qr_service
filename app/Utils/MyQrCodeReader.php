<?php
namespace App\Utils;

use Exception;
use Imagick;

class MyQrCodeReader
{
    /**
     * QR kodni o'qish
     *
     * @param string $filePath
     * @return array
     */
    public function read(string $filePath)
    {
        try {
            $imagick = new Imagick($filePath);

            $imagick->setImageFormat('png');
            $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);

            $qrText = $imagick->identifyImage();

            return $qrText;
        } catch (Exception $e) {
            return null;
        }
    }
}

