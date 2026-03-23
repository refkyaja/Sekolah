<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Spmb;
use App\Models\Siswa;
use App\Models\User;
use App\Events\NotificationSent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * GET /notifications/data
     * Ambil notifikasi terbaru untuk user yang sedang login.
     */
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $notifications = Notification::forAuthUser($user)
            ->recent(15)
            ->get()
            ->map(fn($n) => [
                'id'         => $n->id,
                'type'       => $n->type,
                'title'      => $n->title,
                'body'       => $n->body,
                'data'       => $n->data,
                'is_unread'  => $n->isUnread(),
                'read_at'    => $n->read_at?->toIso8601String(),
                'created_at' => $n->created_at->toIso8601String(),
                'time_ago'   => $n->created_at->diffForHumans(),
            ]);

        $unreadCount = Notification::forAuthUser($user)->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    /**
     * POST /notifications/{id}/read
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markRead(string $id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $notification = Notification::forAuthUser($user)->findOrFail($id);
        $notification->markAsRead();

        $unreadCount = Notification::forAuthUser($user)->unread()->count();

        return response()->json([
            'success'      => true,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * POST /notifications/read-all
     * Tandai semua notifikasi user ini sebagai sudah dibaca.
     */
    public function markAllRead(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        Notification::forAuthUser($user)
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json([
            'success'      => true,
            'unread_count' => 0,
        ]);
    }

    // ==================== HELPER: Dispatch Notifikasi ====================

    /**
     * Kirim notifikasi ke role tertentu dan broadcast via Reverb.
     * Gunakan ini dari controller lain atau job.
     *
     * Contoh:
     * NotificationController::send(
     *   roles: ['admin', 'operator'],
     *   type: 'ppdb_baru',
     *   title: 'Pendaftaran Baru Masuk',
     *   body: 'Ada pendaftaran baru dari ' . $spmb->nama_lengkap,
     *   data: ['url' => route('admin.ppdb.show', $spmb->id)]
     * );
     */
    public static function send(
        array $roles,
        string $type,
        string $title,
        string $body,
        array $data = [],
        ?int $targetUserId = null
    ): Notification {
        // Buat record notif di DB
        $notification = Notification::create([
            'type'           => $type,
            'title'          => $title,
            'body'           => $body,
            'data'           => $data ?: null,
            'target_roles'   => count($roles) > 0 ? $roles : null,
            'target_user_id' => $targetUserId,
        ]);

        // Tentukan user IDs yang harus menerima broadcast
        $query = User::query();

        if ($targetUserId) {
            $query->where('id', $targetUserId);
        } elseif (count($roles) > 0) {
            $query->whereIn('role', $roles);
        }

        $userIds = $query->pluck('id')->map(fn($id) => (int) $id)->toArray();

        if (!empty($userIds)) {
            event(new NotificationSent($notification, $userIds));
        }

        return $notification;
    }

    /**
     * Kirim notifikasi personal ke satu user (siswa/guru tertentu).
     */
    public static function sendToUser(
        int $userId,
        string $type,
        string $title,
        string $body,
        array $data = []
    ): Notification {
        return static::send([], $type, $title, $body, $data, $userId);
    }

    public static function sendToSiswa(
        int $siswaId,
        string $type,
        string $title,
        string $body,
        array $data = []
    ): Notification {
        $payload = array_merge($data, [
            'recipient_siswa_id' => $siswaId,
        ]);

        $notification = Notification::create([
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => $payload,
            'target_roles' => ['siswa'],
        ]);

        event(new NotificationSent($notification, [$siswaId]));

        return $notification;
    }

    /**
     * Kirim notifikasi saat ada pendaftaran siswa baru masuk.
     */
    public static function notifyNewSpmbRegistration(Spmb $spmb): ?Notification
    {
        try {
            $detailUrl = route('admin.ppdb.show', $spmb);

            return static::send(
                roles: ['admin', 'operator', 'kepala_sekolah'],
                type: 'ppdb_baru',
                title: 'Pendaftaran Baru Masuk',
                body: 'Pendaftaran atas nama ' . ($spmb->nama_lengkap_anak ?? 'calon siswa baru') . ' baru saja dikirim.',
                data: [
                    'spmb_id' => $spmb->id,
                    'no_pendaftaran' => $spmb->no_pendaftaran,
                    'status_pendaftaran' => $spmb->status_pendaftaran,
                    'url' => $detailUrl,
                ],
            );
        } catch (\Throwable $exception) {
            Log::warning('Gagal mengirim notifikasi pendaftaran baru.', [
                'spmb_id' => $spmb->id,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }
    }
}
