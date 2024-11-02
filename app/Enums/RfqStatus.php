<?php

namespace App\Enums;

enum RfqStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';

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
            self::VERIFIED => $lang === 'id' ? 'Terverifikasi' : 'Verified',
            self::APPROVED => $lang === 'id' ? 'Disetujui' : 'Approved',
            self::REJECTED => $lang === 'id' ? 'Ditolak' : 'Rejected',
            self::CANCELED => $lang === 'id' ? 'Dibatalkan' : 'Canceled',
            self::COMPLETED => $lang === 'id' ? 'Selesai' : 'Completed',
        };
    }
}
