<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            body { font-family: 'Inter', sans-serif; }
            .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
            
            /* Efek Animasi Mesh Cairan di Latar Belakang */
            .liquid-bg {
                background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #525f06 100%);
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
            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid text-emerald-200/40">
                    
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    @if(auth()->user()->role === 'admin')
                        <flux:sidebar.item icon="user" :href="route('student.index')" :current="request()->routeIs('student.index')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                            {{ __('Students') }}
                        </flux:sidebar.item>
                    @endif
                    <flux:sidebar.item icon="calendar-days" :href="route('schedule.index')" :current="request()->routeIs('schedule.index')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                        {{ __('Schedules') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="pencil-square" :href="route('assignment.index')" :current="request()->routeIs('assignment.index')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                        {{ __('Assignments') }}
                    </flux:sidebar.item>

                    @if(auth()->user()->role === 'admin')
                        <flux:sidebar.item icon="user-group" :href="route('teacher.index')" :current="request()->routeIs('teacher.index')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                            {{ __('Teachers') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                        <flux:sidebar.item icon="calendar" :href="route('attendance.index')" :current="request()->routeIs('attendance.index')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                            {{ __('Attendances') }}
                        </flux:sidebar.item>

                        <flux:sidebar.item icon="academic-cap" :href="route('grade.index')" :current="request()->routeIs('grade.index')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                            {{ __('Grades') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->role === 'admin')
                        <flux:sidebar.item icon="currency-dollar" :href="route('payment.index')" :current="request()->routeIs('payment.index')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                            {{ __('Payments') }}
                        </flux:sidebar.item>
                    @endif

                    <flux:sidebar.item icon="megaphone" :href="route('announcement.index')" :current="request()->routeIs('announcement.index')" wire:navigate class="hover:!bg-white/10 !text-white transition rounded-xl">
                        {{ __('Announcements') }}
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

            <x-desktop-user-menu class="hidden lg:block brightness-120" :name="auth()->user()->name" />
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