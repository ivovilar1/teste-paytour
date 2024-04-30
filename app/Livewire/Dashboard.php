<?php

namespace App\Livewire;

use App\Mail\ResumeReceived;
use App\Models\Resume;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;


class Dashboard extends Component
{
    use WithFileUploads;

    public ?string $nome = null;
    public ?string $email = null;
    public ?string $telefone = null;
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
