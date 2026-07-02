<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Payment;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function payments()
    {
        // Menggunakan Eager Loading 'student' agar query data nama siswa efisien
        return Payment::with('student')->latest()->paginate(10);
    }

    public function edit($id){
        $this->dispatch('edit-payment', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Payments</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage student payments</flux:subheading>
    <flux:separator variant="subtle" />
    
    <flux:modal.trigger name="create-payment">
        <flux:button variant="primary" icon="plus" color="primary">Add Payment</flux:button>
    </flux:modal.trigger>

    <livewire:payment.create />
    <livewire:payment.edit />
    <x-flash-message />

    {{-- table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->payments">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Student Name</flux:table.column>
                <flux:table.column>Type</flux:table.column>
                <flux:table.column>Amount</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Date</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->payments as $payment)
                    <flux:table.row :key="$payment->payment_id">

                        {{-- Nomor Urut --}}
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->payments->firstItem() - 1) }}
                        </flux:table.cell>

                        {{-- Nama Siswa & ID Relasi --}}
                        <flux:table.cell class="flex items-center gap-3 font-medium text-zinc-800 dark:text-white">
                            @if($payment->student)
                                {{ $payment->student->name }}
                                <span class="text-xs text-zinc-400 font-normal">(#{{ $payment->student_id }})</span>
                            @else
                                <span class="text-red-500 italic text-xs">Siswa Tidak Ditemukan</span>
                            @endif
                        </flux:table.cell>

                        {{-- Tipe Pembayaran --}}
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $payment->type }}
                        </flux:table.cell>

                        {{-- Jumlah Uang dengan Format Rupiah --}}
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400 font-medium">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </flux:table.cell>

                        {{-- Status dengan Badge Warna Dinamis --}}
                        <flux:table.cell>
                            <span class="font-bold px-2 py-0.5 rounded text-xs
                                {{ $payment->status === 'Paid' ? 'text-green-600 bg-green-50 dark:bg-green-950/30' : 'text-red-600 bg-red-50 dark:bg-red-950/30' }}">
                                {{ $payment->status }}
                            </span>
                        </flux:table.cell>

                        {{-- Tanggal Bayar --}}
                        <flux:table.cell class="whitespace-nowrap text-zinc-500 dark:text-zinc-400">
                            {{ $payment->date ? date('d-m-Y', strtotime($payment->date)) : '-' }}
                        </flux:table.cell>

                        {{-- Dropdown Menu Aksi --}}
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $payment->payment_id }})">Edit</flux:menu.item>

                                    <flux:menu.separator />

                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $payment->payment_id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete-payment', {id: {{ $payment->payment_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>