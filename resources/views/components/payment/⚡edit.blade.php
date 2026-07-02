<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Payment;
use App\Livewire\Forms\PaymentForm;

new class extends Component
{
    public PaymentForm $form;

    #[On('edit-payment')]
    public function editPayment($id){
        $payment = Payment::find($id);
        $this->form->setPayment($payment);
        Flux::modal('edit-payment')->show();
    }

    public function updatePayment() {
        $this->form->update();
        Flux::modal('edit-payment')->close();
        session()->flash('success', 'Payment updated successfully');
        $this->redirectRoute('payment.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete-payment')]
    public function confirmDelete($id)
    {
        $payment = Payment::find($id);
        $this->form->setPayment($payment);
        Flux::modal('delete-payment')->show();
    }

    public function deletePayment() {
        $this->form->destroy();
        Flux::modal('delete-payment')->close();
        session()->flash('success', 'Payment deleted successfully');
        $this->redirectRoute('payment.index', navigate: true);
    }
};
?>

<div>
    {{-- edit modal --}}
    <flux:modal 
        name="edit-payment" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="updatePayment">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Payment
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit student payment details below
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Student ID"
                    type="number"
                    placeholder="e.g., 1"
                    wire:model="form.student_id"
                />

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

            <div 
                wire:show="$dirty"
                class="text-red-500 dark:text-red-400"
            >
                you have unsaved changes
            </div>
    
            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- delete modal --}}
    <flux:modal 
        name="delete-payment" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="deletePayment">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Payment
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    this action cannot be undone
                </flux:text>
            </div>

            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>