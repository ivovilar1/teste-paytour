<?php

namespace App\Livewire;

use App\Mail\ResumeReceived;
use App\Models\Resume;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
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
    public ?string $escolaridade = null;
    public ?string $observacoes = null;
    public $arquivo;
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
        ]);

        Mail::to('admin@admin.com')->send(new ResumeReceived($resume));
    }
}
