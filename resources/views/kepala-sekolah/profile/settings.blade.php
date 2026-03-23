@extends('layouts.kepala_sekolah')

@section('title', 'Pengaturan')
@section('breadcrumb', 'Pengaturan Akun')

@push('styles')
<style>
    .settings-card {
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 1.5rem;
        box-shadow: 0 18px 45px -28px rgba(15, 23, 42, 0.28);
    }

    .dark .settings-card {
        background: rgba(15, 23, 42, 0.86);
        border-color: rgba(51, 65, 85, 0.9);
        box-shadow: 0 18px 45px -28px rgba(2, 6, 23, 0.6);
    }

    .theme-option {
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 1.25rem;
        padding: 1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        background: #fff;
    }

    .dark .theme-option {
        background: rgba(15, 23, 42, 0.92);
        border-color: rgba(51, 65, 85, 0.9);
    }

    .theme-option.is-active {
        border-color: #6B46C1;
        box-shadow: 0 0 0 4px rgba(107, 70, 193, 0.12);
        transform: translateY(-1px);
    }

    .setting-switch {
        position: relative;
        width: 3.25rem;
        height: 1.9rem;
        border-radius: 9999px;
        background: #cbd5e1;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .setting-switch::after {
        content: "";
        position: absolute;
        top: 0.22rem;
        left: 0.22rem;
        width: 1.45rem;
        height: 1.45rem;
        border-radius: 9999px;
        background: #fff;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.18);
    }

    .setting-switch.is-active {
        background: #6B46C1;
    }

    .setting-switch.is-active::after {
        transform: translateX(1.35rem);
    }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="settings-card p-6 md:p-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-bold tracking-[0.3em] uppercase text-primary mb-2">Pengaturan Akun</p>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-slate-100">Atur panel sesuai kebutuhan Anda</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Versi sederhana: tampilan, notifikasi, dan keamanan akun.</p>
            </div>
            <div class="rounded-2xl bg-slate-50 dark:bg-slate-800/80 px-5 py-4">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500">Login terakhir</p>
                <p class="mt-1 font-semibold text-slate-800 dark:text-slate-100">
                    {{ $user->last_login_at ? $user->last_login_at->translatedFormat('d F Y, H:i') : 'Belum tercatat' }}
                </p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    {{ $user->last_login_ip ?: 'IP belum tersedia' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.25fr_0.95fr]">
        <section class="settings-card p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary">palette</span>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">Tampilan</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Pilih mode warna panel admin.</p>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3" id="themeOptions">
                <button type="button" class="theme-option text-left" data-theme-option="light">
                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Light</p>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Tampilan terang klasik.</p>
                </button>
                <button type="button" class="theme-option text-left" data-theme-option="dark">
                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Dark</p>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Nyaman untuk ruangan redup.</p>
                </button>
                <button type="button" class="theme-option text-left" data-theme-option="system">
                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100">System</p>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Ikuti pengaturan perangkat.</p>
                </button>
            </div>
        </section>

        <section class="settings-card p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary">notifications</span>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">Notifikasi</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Simpan preferensi notifikasi di browser ini.</p>
                </div>
            </div>

            <div class="space-y-4">
                <button type="button" class="w-full flex items-center justify-between gap-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 px-4 py-4 text-left" data-setting-toggle="newAccounts">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-slate-100">Akun Baru</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Info saat ada akun pengguna baru.</p>
                    </div>
                    <span class="setting-switch"></span>
                </button>

                <button type="button" class="w-full flex items-center justify-between gap-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 px-4 py-4 text-left" data-setting-toggle="newPpdb">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-slate-100">PPDB Baru</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Notifikasi pendaftaran masuk baru.</p>
                    </div>
                    <span class="setting-switch"></span>
                </button>

                <button type="button" class="w-full flex items-center justify-between gap-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 px-4 py-4 text-left" data-setting-toggle="guestbook">
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-slate-100">Buku Tamu</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Info pesan atau kunjungan baru.</p>
                    </div>
                    <span class="setting-switch"></span>
                </button>
            </div>
        </section>
    </div>

    <section class="settings-card p-6 md:p-8">
        <div class="flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-primary">security</span>
            <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">Keamanan Akun</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Akses cepat ke pengelolaan keamanan akun.</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('kepala-sekolah.profile.index') }}?tab=password" class="rounded-2xl bg-slate-50 dark:bg-slate-800/80 p-5 transition hover:-translate-y-0.5 hover:shadow-lg">
                <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Ubah Password</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Buka halaman profil dan langsung masuk ke tab password.</p>
            </a>

            <div class="rounded-2xl bg-slate-50 dark:bg-slate-800/80 p-5">
                <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Status Login</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    {{ $user->last_login_at ? 'Terakhir masuk ' . $user->last_login_at->diffForHumans() : 'Belum ada catatan login yang tersedia.' }}
                </p>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var themeButtons = document.querySelectorAll('[data-theme-option]');
        var toggleButtons = document.querySelectorAll('[data-setting-toggle]');
        var themeKey = 'kepala-sekolahTheme';
        var notificationKey = 'kepala-sekolahNotificationSettings';

        function getSavedTheme() {
            return localStorage.getItem(themeKey) || 'system';
        }

        function applyTheme(theme) {
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var shouldUseDark = theme === 'dark' || (theme === 'system' && prefersDark);
            document.documentElement.classList.toggle('dark', shouldUseDark);
            document.documentElement.dataset.themePreference = theme;
            if (document.body) {
                document.body.classList.toggle('dark', shouldUseDark);
                document.body.dataset.themePreference = theme;
            }
            localStorage.setItem(themeKey, theme);
            if (typeof window.applyKepalaSekolahTheme === 'function') {
                window.applyKepalaSekolahTheme();
            }

            themeButtons.forEach(function (button) {
                button.classList.toggle('is-active', button.dataset.themeOption === theme);
            });
        }

        function getNotificationSettings() {
            var raw = localStorage.getItem(notificationKey);
            if (!raw) {
                return {
                    newAccounts: true,
                    newPpdb: true,
                    guestbook: true
                };
            }

            try {
                return JSON.parse(raw);
            } catch (error) {
                return {
                    newAccounts: true,
                    newPpdb: true,
                    guestbook: true
                };
            }
        }

        function renderNotificationSettings() {
            var settings = getNotificationSettings();

            toggleButtons.forEach(function (button) {
                var key = button.dataset.settingToggle;
                var switchEl = button.querySelector('.setting-switch');
                var isActive = Boolean(settings[key]);
                switchEl.classList.toggle('is-active', isActive);
            });
        }

        themeButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                applyTheme(button.dataset.themeOption);
            });
        });

        toggleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var settings = getNotificationSettings();
                var key = button.dataset.settingToggle;
                settings[key] = !settings[key];
                localStorage.setItem(notificationKey, JSON.stringify(settings));
                renderNotificationSettings();
            });
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
            if (getSavedTheme() === 'system') {
                applyTheme('system');
            }
        });

        applyTheme(getSavedTheme());
        renderNotificationSettings();
    });
</script>
@endpush
