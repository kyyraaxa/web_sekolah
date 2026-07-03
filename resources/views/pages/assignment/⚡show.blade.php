<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

new class extends Component
{
    use WithFileUploads;

    public $assignment;
    public $submission_text = '';
    public $file;
    
    // Modal Grading properti
    public $selected_submission_id;
    public $grade_input;

    public function mount($id)
    {
        $this->assignment = Assignment::findOrFail($id);
        
        // Load data lama jika diakses siswa yang sudah pernah mengumpul
        if (Auth::user()->role === 'student') {
            $existing = Submission::where('assignment_id', $this->assignment->assignment_id)
                                  ->where('user_id', Auth::id())
                                  ->first();
            if ($existing) {
                $this->submission_text = $existing->submission_text;
            }
        }
    }

    // Aksi simpan pengumpulan (Khusus Student)
    public function submitAssignment()
    {
        if (Auth::user()->role !== 'student') abort(403);

        $this->validate([
            'submission_text' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:5120',
        ]);

        $filePath = null;
        if ($this->file) {
            $filePath = $this->file->store('submissions', 'public');
        }

        Submission::updateOrCreate(
            [
                'assignment_id' => $this->assignment->assignment_id,
                'user_id' => Auth::id()
            ],
            [
                'submission_text' => $this->submission_text,
                'file_path' => $filePath ?? DB::raw('file_path'),
            ]
        );

        session()->flash('success', 'Tugas berhasil dikumpulkan/diperbarui!');
        // Sinkronisasi nama rute ke jamak (assignment.show)
        $this->redirectRoute('assignment.show', $this->assignment->assignment_id, navigate: true);
    }

    // Buka Modal Nilai (Khusus Admin/Teacher)
    public function openGradeModal($submissionId)
    {
        $sub = Submission::find($submissionId);
        $this->selected_submission_id = $submissionId;
        $this->grade_input = $sub->grade;
        
        Flux::modal('grade-modal')->show();
    }

    // Simpan Nilai
    public function saveGrade()
    {
        $this->validate(['grade_input' => 'required|integer|min:0|max:100']);

        $sub = Submission::findOrFail($this->selected_submission_id);
        $sub->update(['grade' => $this->grade_input]);

        Flux::modal('grade-modal')->close();
        session()->flash('success', 'Nilai siswa berhasil disimpan!');
    }
};
?>

<div class="max-w-4xl mx-auto space-y-6 p-6">
    {{-- Header / Detail Tugas Utama --}}
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-3 shadow-sm">
        <div class="flex justify-between items-start gap-4">
            <div>
                <flux:heading size="xl">{{ $assignment->title }}</flux:heading>
                <flux:subheading>{{ $assignment->subject }}</flux:subheading>
            </div>
            <span class="text-xs font-semibold px-3 py-1 bg-red-50 text-red-600 dark:bg-red-950/30 dark:text-red-400 rounded-full shrink-0">
                Batas Waktu: {{ $assignment->due_date->format('d M Y, H:i') }}
            </span>
        </div>
        <flux:separator variant="subtle" />
        <p class="text-sm text-zinc-600 dark:text-zinc-300 whitespace-pre-line">
            {{ $assignment->description ?? 'Tidak ada instruksi deskripsi tambahan untuk tugas ini.' }}
        </p>
    </div>

    <x-flash-message />

    {{-- ========================================================================= --}}
    {{-- PANEL GURU / ADMIN: DAFTAR PENGUMPULAN SISWA                              --}}
    {{-- ========================================================================= --}}
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
        <div class="space-y-4">
            <flux:heading size="lg">Daftar Pengumpulan Tugas Siswa</flux:heading>
            
            @php 
                $submissions = $assignment->submissions()->with('user')->get();
            @endphp

            @if($submissions->isEmpty())
                <p class="text-sm text-zinc-500 italic">Belum ada siswa yang mengumpulkan tugas ini.</p>
            @else
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                    <flux:table>
                        <flux:table.columns>
                            {{-- Modifikasi: Ditambahkan kelas pl-4 agar header tidak menempel --}}
                            <flux:table.column class="pl-4">Siswa</flux:table.column>
                            <flux:table.column>Teks / Link Jawaban</flux:table.column>
                            <flux:table.column>File Dokumen</flux:table.column>
                            <flux:table.column>Nilai</flux:table.column>
                            <flux:table.column>Aksi</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach($submissions as $sub)
                                <flux:table.row>
                                    {{-- Modifikasi: Ditambahkan kelas pl-4 agar nama siswa sejajar dengan headernya --}}
                                    <flux:table.cell class="font-medium pl-4">{{ $sub->user->name }}</flux:table.cell>
                                    <flux:table.cell class="max-w-xs truncate">{{ $sub->submission_text }}</flux:table.cell>
                                    <flux:table.cell>
                                        @if($sub->file_path)
                                            <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline font-medium">Unduh Berkas</a>
                                        @else
                                            <span class="text-xs text-zinc-400">-</span>
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <span class="font-bold {{ $sub->grade ? 'text-green-600 dark:text-green-400' : 'text-zinc-400' }}">
                                            {{ $sub->grade ?? 'Belum Dinilai' }}
                                        </span>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:button size="sm" wire:click="openGradeModal({{ $sub->submission_id }})">Beri Nilai</flux:button>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                </div>
            @endif
        </div>

        {{-- Modal Pengisian Nilai oleh Admin/Teacher --}}
        <flux:modal name="grade-modal" class="md:w-96">
            <form wire:submit.prevent="saveGrade" class="space-y-4">
                <flux:heading size="lg">Berikan Penilaian</flux:heading>
                <flux:input label="Skor Nilai (0-100)" type="number" wire:model="grade_input" placeholder="Misal: 90" />
                <div class="flex justify-end gap-2">
                    <flux:modal.close><flux:button variant="outline">Batal</flux:button></flux:modal.close>
                    <flux:button type="submit" variant="primary" color="primary">Simpan Nilai</flux:button>
                </div>
            </form>
        </flux:modal>
    @endif

    {{-- ========================================================================= --}}
    {{-- PANEL SISWA: LEMBAR SUBMIT JAWABAN                                        --}}
    {{-- ========================================================================= --}}
    @if(auth()->user()->role === 'student')
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-4 shadow-sm">
            <flux:heading size="lg">Lembar Pengumpulan Kamu</flux:heading>

            @php
                $mySub = $assignment->userSubmission;
            @endphp

            @if($mySub && $mySub->grade !== null)
                <div class="p-4 bg-green-50 dark:bg-green-950/20 text-green-700 dark:text-green-400 rounded-xl border border-green-200 dark:border-green-900">
                    <strong>Tugas Telah Dinilai Selesai!</strong> Skor yang kamu peroleh: <span class="text-xl font-black">{{ $mySub->grade }}</span>
                </div>
            @endif

            <form wire:submit.prevent="submitAssignment" class="space-y-4">
                <flux:textarea 
                    label="Catatan Jawaban / Link Tautan Google Drive" 
                    placeholder="Tulis ringkasan teks atau lampirkan link cloud storage jawaban di sini..." 
                    wire:model="submission_text"
                    rows="5"
                    :disabled="$mySub && $mySub->grade !== null"
                />

                <flux:input 
                    label="Lampiran File Tambahan (PDF, DOCX, ZIP)" 
                    type="file" 
                    wire:model="file" 
                    :disabled="$mySub && $mySub->grade !== null"
                />

                <div class="flex justify-end">
                    <flux:button type="submit" color="primary" variant="primary" :disabled="$mySub && $mySub->grade !== null">
                        {{ $mySub ? 'Perbarui Jawaban' : 'Kumpulkan Sekarang' }}
                    </flux:button>
                </div>
            </form>
        </div>
    @endif
</div>