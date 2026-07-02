<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Payment;
use Illuminate\Validation\Rule;

class PaymentForm extends Form
{
    public ?int $payment_id = null;

    public ?int $student_id = null;
    public string $type = '';
    public ?float $amount = null;
    public string $status = 'Unpaid';
    public ?string $date = null;

    public function rules(): array
    {
        return [
            'student_id' => [
                'required',
                'integer',
                'exists:students,student_id', // Memastikan siswa ada di database
            ],
            'type' => [
                'required',
                'string',
                'max:255',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
                'string',
                'in:Paid,Unpaid',
            ],
            'date' => [
                'nullable',
                'date',
            ],
        ];
    }

    public function store()
    {
        // Logika otomatis: Jika status Lunas (Paid) tapi tanggal kosong, isi dengan tanggal hari ini
        if ($this->status === 'Paid' && empty($this->date)) {
            $this->date = date('Y-m-d');
        }

        $this->validate();

        Payment::create($this->only(['student_id', 'type', 'amount', 'status', 'date']));
        $this->reset();
    }

    public function setPayment(Payment $payment): void
    {
        $this->payment_id = $payment->payment_id;
        $this->student_id = $payment->student_id;
        $this->type       = $payment->type;
        $this->amount     = $payment->amount;
        $this->status     = $payment->status;
        $this->date       = $payment->date;
    }

    public function update()
    {
        // Logika otomatis yang sama saat data diperbarui
        if ($this->status === 'Paid' && empty($this->date)) {
            $this->date = date('Y-m-d');
        }

        $this->validate();

        $payment = Payment::findOrFail($this->payment_id);
        $payment->update($this->only(['student_id', 'type', 'amount', 'status', 'date']));
    }

    public function destroy()
    {
        if ($this->payment_id) {
            Payment::findOrFail($this->payment_id)->delete();
            $this->reset(); // Bersihkan isi form setelah dihapus
        }
    }
}