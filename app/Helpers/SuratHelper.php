<?php

namespace App\Helpers;

use Carbon\Carbon;

class SuratHelper
{
    /**
     * Render isi surat dengan mengganti placeholder {{field_key}} dengan nilai dari $data.
     *
     * Placeholder yang didukung:
     *   {{nama}}, {{umur}}, {{diagnosis}}, {{tgl_masuk}}, dll — nilai langsung dari $data
     *   {{tgl_masuk|date:d F Y}} — format tanggal (translatedFormat)
     *   {{tgl_masuk|date_en:F d}} — format tanggal bahasa Inggris
     *
     * Formatting teks:
     *   [[bold:teks]]      → <strong>teks</strong>
     *   [[underline:teks]] → <u>teks</u>
     *   [[italic:teks]]    → <em>teks</em>
     */
    public static function renderIsi(string $template, $data): string
    {
        // Ganti placeholder {{field_key}} atau {{field_key|format}}
        $result = preg_replace_callback('/\{\{(\w+)(?:\|([^}]+))?\}\}/', function ($matches) use ($data) {
            $key    = $matches[1];
            $format = $matches[2] ?? null;
            $value  = $data->{$key} ?? null;

            if ($value === null || $value === '') {
                return '<span style="text-decoration:underline">.................</span>';
            }

            if ($format) {
                [$formatType, $formatStr] = array_pad(explode(':', $format, 2), 2, '');
                if ($formatType === 'date' && $formatStr) {
                    try {
                        return Carbon::parse($value)->translatedFormat($formatStr);
                    } catch (\Exception $e) {
                        return $value;
                    }
                }
                if ($formatType === 'date_en' && $formatStr) {
                    try {
                        return Carbon::parse($value)->format($formatStr);
                    } catch (\Exception $e) {
                        return $value;
                    }
                }
            }

            return e($value);
        }, $template);

        // Ganti formatting markup
        $result = preg_replace('/\[\[bold:(.+?)\]\]/', '<strong>$1</strong>', $result);
        $result = preg_replace('/\[\[underline:(.+?)\]\]/', '<u>$1</u>', $result);
        $result = preg_replace('/\[\[italic:(.+?)\]\]/', '<em>$1</em>', $result);

        return $result;
    }
}
