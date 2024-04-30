<?php

namespace App\Livewire;

use App\Enum\EscolaridadeEnum;
use App\Mail\ResumeReceived;
use App\Models\Resume;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;


class Dashboard extends Component
{
    use WithFileUploads;

    #[Validate('required|min:3|max:65')]
    public ?string $nome = null;
    #[Validate('required|email|max:255')]
    public ?string $email = null;
    #[Validate('required|min:8|max:10|regex:/^\d{10}$/')]
    public ?string $telefone = null;
    #[Validate('required|max:255')]
    public ?string $cargo = null;
    #[Validate('required')]
    public ?string $escolaridade = null;
    public ?string $observacoes = null;
    #[Validate('required|file|mimes:pdf,doc,docx|max:1024')]
    public $arquivo;
    #[Validate('required|date_format:Y-m-d H:i:s')]
    public ?string $data_envio = null;

    public function render(): View
    {
        return view('livewire.dashboard');
    }

    public function store(): void
    {
        $this->validate();

        $resume = Resume::query()->create([
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'cargo' => $this->cargo,
            'escolaridade' => $this->escolaridade,
            'observacoes' => $this->observacoes,
            'arquivo' => $this->arquivo->store(path: 'public'),
            'data_envio' => $this->data_envio,
            'ip_address' => request()->ip()
        ]);

        Mail::to('admin@admin.com')->send(new ResumeReceived($resume));
    }
}
