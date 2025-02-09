<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class QrCodeRequest extends FormRequest
{
    /**
     * Foydalanuvchiga ruxsat berilganmi yoki yo'qligini tekshiradi.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Hamma foydalanuvchilarga ruxsat beriladi
    }

    /**
     * So'rovni tekshirish uchun qo'llaniladigan qoidalar.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => 'required|string',  // 'text' maydoni required, string va maksimal uzunligi 255 bo'lishi kerak
        ];
    }

    /**
     * Validatsiya xatolarini qaytarishda foydalanuvchiga moslashtirilgan xabarlarni yuborish.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'text.required' => 'Matnni kiritish kerak!',
            'text.string' => 'Matn faqat harf va raqamlardan iborat bo\'lishi kerak!',
            'text.max' => 'Matn uzunligi 255 belgidan oshmasligi kerak!',
        ];
    }
}

