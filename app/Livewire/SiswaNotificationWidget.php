<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\Spmb;
use App\Models\SpmbSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

/**
 * Widget notifikasi untuk siswa dashboard (kolom kanan).
 * Tidak menggunakan dropdown, langsung tampil sebagai section.
 */
class SiswaNotificationWidget extends Component
{
    public array $notifications = [];
    public int $unreadCount = 0;

    public function mount(): void
    {
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        // Siswa login via guard 'siswa' (Siswa model), bukan User
        // Notifikasi siswa ditarget via target_user_id
        $siswa = Auth::guard('siswa')->user();
        if (!$siswa) return;

        $spmb = null;
        if ($siswa->spmb_id) {
            $spmb = Spmb::with('dokumen')->find($siswa->spmb_id);
        }

        if (!$spmb && $siswa->nik) {
            $spmb = Spmb::with('dokumen')
                ->where('nik_anak', $siswa->nik)
                ->latest('created_at')
                ->first();
        }

        // Cari user yang berelasi ke siswa ini (jika ada), atau gunakan target_user_id dari siswa.id
        $items = Notification::where(function ($q) use ($siswa) {
            $q->where('target_user_id', $siswa->id)
              ->orWhere(function ($q2) use ($siswa) {
                  $q2->whereNull('target_user_id')
                     ->whereJsonContains('target_roles', 'siswa')
                     ->where(function ($q3) use ($siswa) {
                         $q3->whereNull('data->recipient_siswa_id')
                            ->orWhere('data->recipient_siswa_id', $siswa->id);
                     });
              });
        })
        ->orderByDesc('created_at')
        ->limit(10)
        ->get();

        $databaseNotifications = $items->map(fn($n) => [
            'id'        => $n->id,
            'type'      => $n->type,
            'title'     => $n->title,
            'body'      => $n->body,
            'data'      => $n->data,
            'is_unread' => $n->isUnread(),
            'time_ago'  => $n->created_at->diffForHumans(),
            'sort_at'   => $n->created_at?->timestamp ?? now()->timestamp,
        ])->toArray();

        $notifications = array_merge(
            $this->buildSystemNotifications($spmb),
            $databaseNotifications,
        );

        usort($notifications, fn ($a, $b) => ($b['sort_at'] ?? 0) <=> ($a['sort_at'] ?? 0));

        $this->notifications = $notifications;

        $this->unreadCount = $items->filter(fn($n) => $n->isUnread())->count();
    }

    private function buildSystemNotifications(?Spmb $spmb): array
    {
        $notifications = [[
            'id' => 'system-welcome',
            'type' => 'system_welcome',
            'title' => 'Selamat datang di Dashboard Siswa',
            'body' => 'Notification System akan menampilkan perkembangan formulir, dokumen, dan catatan admin secara berurutan di sini.',
            'data' => ['url' => route('siswa.dashboard')],
            'is_unread' => false,
            'time_ago' => 'Panduan awal',
            'sort_at' => 1,
        ]];

        if (!$spmb) {
            $notifications[] = [
                'id' => 'system-start-registration',
                'type' => 'system_start_registration',
                'title' => 'Silakan mulai pendaftaran',
                'body' => 'Lengkapi formulir pendaftaran terlebih dahulu untuk memulai proses PPDB Anda.',
                'data' => ['url' => route('siswa.formulir')],
                'is_unread' => false,
                'time_ago' => 'Baru saja',
                'sort_at' => now()->timestamp,
            ];

            return $notifications;
        }

        $announcementNotification = $this->buildAnnouncementNotification($spmb);
        if ($announcementNotification) {
            $notifications[] = $announcementNotification;
        }

        $formSubmittedAt = $spmb->created_at;
        $documentsSubmittedAt = $spmb->dokumen && $spmb->dokumen->isNotEmpty()
            ? $spmb->dokumen->max(function ($dokumen) {
                return optional($dokumen->updated_at ?? $dokumen->created_at)->timestamp ?? 0;
            })
            : null;

        if (!$spmb->dokumen_terunggah) {
            $notifications[] = [
                'id' => 'system-formulir-' . $spmb->id,
                'type' => 'system_formulir',
                'title' => 'Terima kasih telah mendaftar',
                'body' => 'Formulir Anda sudah kami terima. Sekarang silakan lengkapi dokumen pendukung agar proses verifikasi dapat dilanjutkan.',
                'data' => ['url' => route('siswa.dokumen')],
                'is_unread' => false,
                'time_ago' => optional($formSubmittedAt)->diffForHumans() ?? 'Baru saja',
                'sort_at' => optional($formSubmittedAt)->timestamp ?? now()->timestamp,
            ];
        } else {
            $notifications[] = [
                'id' => 'system-documents-' . $spmb->id,
                'type' => 'system_documents',
                'title' => 'Dokumen berhasil dikirim',
                'body' => 'Terima kasih telah mendaftar di TK PGRI Harapan Bangsa 1. Formulir dan dokumen Anda sudah kami terima, dan data Anda akan kami verifikasi.',
                'data' => ['url' => route('siswa.pengumuman')],
                'is_unread' => false,
                'time_ago' => $documentsSubmittedAt
                    ? now()->setTimestamp($documentsSubmittedAt)->diffForHumans()
                    : optional($formSubmittedAt)->diffForHumans() ?? 'Baru saja',
                'sort_at' => $documentsSubmittedAt ?? (optional($formSubmittedAt)->timestamp ?? now()->timestamp),
            ];
        }

        return $notifications;
    }

    private function buildAnnouncementNotification(Spmb $spmb): ?array
    {
        $setting = null;

        if ($spmb->tahun_ajaran_id) {
            $setting = SpmbSetting::where('tahun_ajaran_id', $spmb->tahun_ajaran_id)->latest('id')->first();
        }

        if (!$setting && $spmb->tahunAjaran) {
            $setting = SpmbSetting::where('tahun_ajaran', $spmb->tahunAjaran->tahun_ajaran)->latest('id')->first();
        }

        if (!$setting || !$setting->isPengumumanTampil()) {
            return null;
        }

        $sortAt = optional($setting->published_at ?? $setting->pengumuman_mulai)->timestamp ?? now()->timestamp;
        $timeAgo = ($setting->published_at ?? $setting->pengumuman_mulai)
            ? ($setting->published_at ?? $setting->pengumuman_mulai)->diffForHumans()
            : 'Baru saja';

        $title = 'Pengumuman hasil seleksi telah tersedia';
        $body = 'Silakan buka halaman pengumuman untuk melihat hasil akhir pendaftaran Anda.';

        return [
            'id' => 'system-announcement-' . $spmb->id,
            'type' => 'system_announcement',
            'title' => $title,
            'body' => $body,
            'data' => ['url' => route('siswa.pengumuman')],
            'is_unread' => false,
            'time_ago' => $timeAgo,
            'sort_at' => $sortAt,
        ];
    }

    public function markRead(string $id): void
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        $this->loadNotifications();
    }

    public function markAllRead(): void
    {
        $siswa = Auth::guard('siswa')->user();
        if (!$siswa) return;

        Notification::where(function ($q) use ($siswa) {
            $q->where('target_user_id', $siswa->id)
              ->orWhere(function ($q2) use ($siswa) {
                  $q2->whereNull('target_user_id')
                     ->whereJsonContains('target_roles', 'siswa')
                     ->where(function ($q3) use ($siswa) {
                         $q3->whereNull('data->recipient_siswa_id')
                            ->orWhere('data->recipient_siswa_id', $siswa->id);
                     });
              });
        })
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

        $this->loadNotifications();
    }

    #[On('siswa-notification-received')]
    public function onNotificationReceived(): void
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.siswa-notification-widget');
    }
}
