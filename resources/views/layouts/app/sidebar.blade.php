<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
            .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
            
            /* Efek Animasi Mesh Cairan di Latar Belakang */
            .liquid-bg {
                background: linear-gradient(135deg, #10b981 0%, #047857 50%, #045736 100%);
                background-size: 400% 400%;
                animation: liquidMovement 15s ease infinite;
            }
            @keyframes liquidMovement {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
        </style>
    </head>

    <body class="min-h-screen liquid-bg text-zinc-100 antialiased relative">
        <flux:sidebar sticky collapsible="mobile" class="!bg-white/5 !backdrop-blur-xl !border-e !border-white/10 text-white">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden text-white" />
            </flux:sidebar.header>
            
            <flux:sidebar.nav class="px-3 space-y-2">
                <flux:sidebar.group :heading="__('Platform')" class="grid text-white/40 text-[10px] font-bold tracking-wider sentence mb-2 px-1">
                    
                    @php
                        // Utility class Liquid Glass - Tanpa Panah, Baris Tunggal Rapi & Presisi
                        $liquidGlassItem = "group relative flex flex-row items-center justify-start gap-3 px-4 py-2.5 rounded-2xl transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] " .
                                           "bg-white/[0.06] backdrop-blur-md " .
                                           "border border-white/20 " . 
                                           "shadow-[0_4px_12px_rgba(0,0,0,0.05)] " .
                                           "hover:scale-[1.02] hover:bg-white/[0.12] hover:border-white/30 " .
                                           "hover:shadow-[0_6px_16px_rgba(255,255,255,0.08)] " .
                                           "active:scale-[0.98] " .
                                           "!text-white font-medium text-sm " .
                                           "data-[current]:bg-white/[0.18] data-[current]:border-white/40 data-[current]:shadow-inner";
                    @endphp

                    {{-- Dashboard --}}
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="{{ $liquidGlassItem }}">
                        <span>{{ __('Dashboard') }}</span>
                    </flux:sidebar.item>

                    {{-- Students --}}
                    @if(auth()->user()->role === 'admin')
                        <flux:sidebar.item icon="user-group" :href="route('student.index')" :current="request()->routeIs('student.index')" wire:navigate class="{{ $liquidGlassItem }}">
                            <span>{{ __('Students') }}</span>
                        </flux:sidebar.item>
                    @endif

                    {{-- Schedules --}}
                    <flux:sidebar.item icon="calendar-days" :href="route('schedule.index')" :current="request()->routeIs('schedule.index')" wire:navigate class="{{ $liquidGlassItem }}">
                        <span>{{ __('Schedules') }}</span>
                    </flux:sidebar.item>

                    {{-- Assignments --}}
                    <flux:sidebar.item icon="pencil-square" :href="route('assignment.index')" :current="request()->routeIs('assignment.index')" wire:navigate class="{{ $liquidGlassItem }}">
                        <span>{{ __('Assignments') }}</span>
                    </flux:sidebar.item>

                    {{-- Teachers --}}
                    @if(auth()->user()->role === 'admin')
                        <flux:sidebar.item icon="user" :href="route('teacher.index')" :current="request()->routeIs('teacher.index')" wire:navigate class="{{ $liquidGlassItem }}">
                            <span>{{ __('Teachers') }}</span>
                        </flux:sidebar.item>
                    @endif

                    {{-- Attendances & Grades --}}
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                        <flux:sidebar.item icon="calendar" :href="route('attendance.index')" :current="request()->routeIs('attendance.index')" wire:navigate class="{{ $liquidGlassItem }}">
                            <span>{{ __('Attendances') }}</span>
                        </flux:sidebar.item>

                        <flux:sidebar.item icon="academic-cap" :href="route('grade.index')" :current="request()->routeIs('grade.index')" wire:navigate class="{{ $liquidGlassItem }}">
                            <span>{{ __('Grades') }}</span>
                        </flux:sidebar.item>
                    @endif

                    {{-- Payments --}}
                    @if(auth()->user()->role === 'admin')
                        <flux:sidebar.item icon="currency-dollar" :href="route('payment.index')" :current="request()->routeIs('payment.index')" wire:navigate class="{{ $liquidGlassItem }}">
                            <span>{{ __('Payments') }}</span>
                        </flux:sidebar.item>
                    @endif

                    {{-- Announcements --}}
                    <flux:sidebar.item icon="megaphone" :href="route('announcement.index')" :current="request()->routeIs('announcement.index')" wire:navigate class="{{ $liquidGlassItem }}">
                        <span>{{ __('Announcements') }}</span>
                    </flux:sidebar.item>

                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="hover:!bg-white/10 !text-zinc-300">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank" class="hover:!bg-white/10 !text-zinc-300">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            {{-- Bagian Akun Profil Ber-Liquid Glass Tanpa Garis Pembatas --}}
            <div class="hidden lg:block px-3 py-2 mt-2">
                <flux:dropdown position="top" align="start" class="w-full">
                    <button type="button" 
                        class="group w-full flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]
                               bg-white/[0.06] backdrop-blur-md
                               border border-white/20
                               shadow-[0_4px_12px_rgba(0,0,0,0.05)]
                               hover:scale-[1.02] hover:bg-white/[0.12] hover:border-white/30
                               hover:shadow-[0_6px_16px_rgba(255,255,255,0.08)]
                               active:scale-[0.98] focus:outline-none"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            <flux:avatar 
                                :name="auth()->user()->name" 
                                :initials="auth()->user()->initials()" 
                                class="border border-white/25 shadow-sm !rounded-xl bg-zinc-700/80 text-white flex-shrink-0"
                            />
                            <span class="truncate text-white font-medium text-sm text-start">
                                {{ auth()->user()->name }}
                            </span>
                        </div>
                        <svg class="w-4 h-4 text-white/60 group-hover:text-white transition-colors duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                        </svg>
                    </button>

                    {{-- Dropdown Menu Diperbarui Penuh Menjadi Liquid Glass Premium --}}
                    <flux:menu class="!bg-white/[0.08] !backdrop-blur-xl border border-white/20 p-2 rounded-2xl shadow-[0_12px_40px_rgba(0,0,0,0.25)] text-white w-60">
                        <flux:menu.radio.group>
                            <div class="p-1 text-sm font-normal">
                                {{-- KOTAK PUTIH DIHAPUS: Sekarang layout bersih mengalir transparan --}}
                                <div class="flex items-center gap-3 px-2 py-1.5">
                                    <flux:avatar
                                        :name="auth()->user()->name"
                                        :initials="auth()->user()->initials()"
                                        class="border border-white/25 shadow-sm flex-shrink-0"
                                    />
                                    <div class="grid flex-1 text-start text-sm leading-tight min-w-0">
                                        <flux:heading class="truncate text-white font-semibold text-sm">{{ auth()->user()->name }}</flux:heading>
                                        <flux:text class="truncate text-white/60 text-xs mt-0.5">{{ auth()->user()->email }}</flux:text>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator class="!border-white/10 my-1" />

                        <flux:menu.radio.group>
                            <flux:menu.item 
                                :href="route('profile.edit')" 
                                icon="cog" 
                                wire:navigate 
                                class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] 
                                       !text-white bg-transparent border border-transparent
                                       hover:scale-[1.02] hover:!bg-white/[0.10] hover:border-white/10
                                       active:scale-[0.98]"
                            >
                                {{ __('Settings') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator class="!border-white/10 my-1" />

                        <form method="POST" action="{{ route('logout') }}" class="w-full m-0">
                            @csrf
                            <flux:menu.item
                                as="button"
                                type="submit"
                                icon="arrow-right-start-on-rectangle"
                                class="w-full cursor-pointer flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] 
                                       !text-red-400 bg-transparent border border-transparent
                                       hover:scale-[1.02] hover:!bg-red-500/20 hover:border-red-500/25
                                       active:scale-[0.98]"
                                data-test="logout-button"
                            >
                                {{ __('Log out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </flux:sidebar>

        <flux:header class="lg:hidden !bg-white/5 !backdrop-blur-md !border-b !border-white/10">
            <flux:sidebar.toggle class="lg:hidden text-white" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                    class="text-white"
                />

                {{-- Dropdown Versi Mobile --}}
                <flux:menu class="!bg-emerald-950/90 !backdrop-blur-xl !border-white/10 text-white">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate text-white">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate text-zinc-300">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="!border-white/10" />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate class="hover:!bg-white/10 !text-white">
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="!border-white/10" />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer !text-red-400 hover:!bg-red-500/20"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>