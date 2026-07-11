@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="MTs. NW Karang Juli" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <img src="{{ asset('img/logo0.png') }}" class="size-6 object-contain" alt="Logo">
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="MTs. NW Karang Juli" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <img src="{{ asset('img/logo0.png') }}" class="size-6 object-contain" alt="Logo">
        </x-slot>
    </flux:brand>
@endif
