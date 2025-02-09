# QR Kod Generatsiyasi

Bu loyihada foydalanuvchilarga QR kodlarni yaratish va o'qish imkoniyatini taqdim etamiz. Web interfeys orqali QR kodlarni yaratish va yuklab olish mumkin.

## Loyihaning qisqacha tavsifi

Loyihada quyidagi asosiy funksiyalar mavjud:

1. **QR kodni yaratish**: Web interfeys orqali foydalanuvchi matn kiritib, QR kodni yaratishi mumkin.
2. **QR kodni yuklab olish**: Web sahifadan QR kodni PNG formatida yuklab olish mumkin.

## Texnologiyalar

- PHP (Laravel Framework)
- SimpleSoftwareIO QR Code Package
- QrCodeReader (QR kodni o'qish uchun)
- .env fayli orqali konfiguratsiyalar

## Loyiha o'rnatilishi

### 1. Muhitni o'rnatish

1. **Loyihani yuklab olish**:
    ```bash
    git clone https://github.com/yourusername/telegram-qr-code-bot.git
    cd telegram-qr-code-bot
    ```

2. **Loyihani o'rnatish**:
    ```bash
    composer install
    ```

3. **`.env` faylini sozlash**:
    `.env` faylida kerakli sozlamalarni (masalan, Telegram bot tokeni) o'rnatish zarur. 
    Misol:
    ```dotenv
    TELEGRAM_BOT_TOKEN=your-telegram-bot-token
    ```

4. **Laravel konfiguratsiyasi**:
    ```bash
    php artisan key:generate
    ```

5. **Storage'ni amalga oshirish**:
    QR kodlar va boshqa fayllar saqlanadigan joyni yaratish:
    ```bash
    php artisan storage:link
    ```

### 2. Web interfeysi

Web interfeys orqali foydalanuvchilar QR kodlarni yaratishi va yuklab olishi mumkin. Buning uchun quyidagi route`ni ishlatishingiz mumkin:

- **QR kod yaratish**:
    `GET /generate-qr-code?text=your-text`

    Bu URL orqali foydalanuvchi matn kiritib, QR kod yaratish mumkin.

### 3. API uchun

Web interfeysi o'rtasidagi aloqani o'rnatish uchun quyidagi API endpoint ishlatiladi:

- **QR kodni yaratish**:
    `POST /api/telegram/generate-qr-code`
    
    Bu endpoint matnni qabul qilib, QR kodni yaratadi va natijani foydalanuvchiga JSON formatda yuboradi.

    Misol:
    ```json
    {
        "message": "QR kod muvaffaqiyatli yaratildi.",
        "file_path": "http://yourdomain.com/storage/qrcodes/12345.png"
    }
    ```

### 4. Foydalanuvchi interfeysi

Foydalanuvchi quyidagi funksiyalarni amalga oshirishi mumkin:

1. **Matnni kiritib, QR kodni yaratish**.
2. **Yaratilgan QR kodni web interfeysidan yuklab olish**.

### 5. Xatoliklar va qo'llab-quvvatlash

Agar QR kodni o'qishda xatolik yuzaga kelsa, foydalanuvchiga `QR kodni o'qishda xato!` xabarini yuborasiz.

Agar boshqa savollar yoki xatoliklar yuzaga kelsa, loyiha sahifasiga murojaat qiling yoki quyidagi emailga yozing: `your-email@example.com`

---

## Loyiha Tavsiflari

- **QR kodlarni generatsiya qilish** uchun `SimpleSoftwareIO\QrCode\Facades\QrCode` paketi ishlatilgan.
- **QR kodni o'qish** uchun `QrCodeReader` paketi ishlatilgan.
