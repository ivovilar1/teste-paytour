<?php

use App\Livewire\Dashboard;
use App\Mail\ResumeReceived;
use App\Models\Resume;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;


it('should be able to create a new resume', function () {

    Mail::fake();

    Storage::fake('public');

    $file = UploadedFile::fake()->create('resume.pdf');

    assertDatabaseCount('resumes', 0);

    Livewire::test(Dashboard::class)
        ->set('nome', 'Joe Doe')
        ->set('email', 'joe@doe.com')
        ->set('telefone', '11111111111')
        ->set('cargo', 'dev fullstack php')
        ->set('escolaridade', 1)
        ->set('observacoes', '')
        ->set('arquivo', $file)
        ->set('data_envio', now())
        ->call('store')
        ->assertHasNoErrors()
        ->assertOk();

    assertDatabaseCount('resumes', 1);

    $resume = Resume::latest()->first();

    assertDatabaseHas('resumes', [
        'nome' => $resume->nome,
        'email' => $resume->email,
        'telefone' => $resume->telefone,
    ]);

    Mail::assertSent(ResumeReceived::class);
});
