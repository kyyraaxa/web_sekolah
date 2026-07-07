<?php

use Livewire\Component;
use App\Livewire\Forms\PaymentForm;
use Livewire\Attributes\Computed;
use App\Models\Student;

new class extends Component
{
    // Instance class paymentform
    public PaymentForm $form;
    
    public function save()
    {
        $this->form->store();
        Flux::modal('create-payment')->close();

        // session
        session()->flash('success', 'Payment created successfully');

        $this->redirectRoute('payment.index', navigate: true);
    }

    // ambil semua data student
    #[computed]
    public function getStudents(){
        return Student::all();
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-payment" class="md:w-96" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Payment
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new student payment record
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                {{-- Input Student ID --}}
                <flux:select label="Student" wire:model="form.student_id" placeholder="Choose student...">
                    @foreach ($this->getStudents as $student)
                        <flux:select.option value="{{ $student->student_id }}">{{ $student->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input
                    label="Type"
                    placeholder="e.g., SPP"
                    wire:model="form.type"
                />

                <flux:input
                    label="Amount"
                    type="number"
                    placeholder="e.g., 500000"
                    wire:model="form.amount"
                />

                <flux:select label="Status" wire:model="form.status">
                    <flux:select.option value="Unpaid">Unpaid</flux:select.option>
                    <flux:select.option value="Paid">Paid</flux:select.option>
                </flux:select>

                <flux:input
                    label="Date"
                    type="date"
                    wire:model="form.date"
                />
            </div>
    
            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>
        </form>
    </flux:modal>
</div>