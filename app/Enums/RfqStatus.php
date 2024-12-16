<?php

namespace App\Enums;

enum RfqStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case SEDANG_DALAM_PENGIRIMAN = 'sedang-dalam-pengiriman';
    case SIAP_DIAMBIL = 'siap-diambil';
    case DIPROSES = 'diproses';
    case VERIFIED = 'verified';
    case APPROVED = 'approved';
    case DITOLAK = 'ditolak';
    case CANCELED = 'canceled';
    case SELESAI = 'selesai';

    public static function toArray(): array
    {
        return array_reduce(self::cases(), function ($acc, $status) {
            $acc[$status->name] = $status->value;

            return $acc;
        }, []);
    }

    public function label(?string $lang = null): string
    {
        $lang = $lang ?? app()->getLocale();

        return match ($this) {
            self::DRAFT => $lang === 'id' ? 'Draf' : 'Draft',
            self::PENDING => $lang === 'id' ? 'Menunggu' : 'Pending',
            self::SEDANG_DALAM_PENGIRIMAN => $lang === 'id' ? 'Sedang Dalam Pengiriman' : 'Sent',
            self::SIAP_DIAMBIL => $lang === 'id' ? 'Siap Diambil' : 'Ready to taken',
            self::DIPROSES => $lang === 'id' ? 'Diproses' : 'Processing',
            self::VERIFIED => $lang === 'id' ? 'Terverifikasi' : 'Verified',
            self::APPROVED => $lang === 'id' ? 'Disetujui' : 'Approved',
            self::DITOLAK => $lang === 'id' ? 'Ditolak' : 'Rejected',
            self::CANCELED => $lang === 'id' ? 'Dibatalkan' : 'Canceled',
            self::SELESAI => $lang === 'id' ? 'Selesai' : 'Completed',
        };
    }
}
