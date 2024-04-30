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
        ->set('telefone', '1111111111')
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

describe('validations', function () {
    test('nome', function ($rule, $value) {
        Livewire::test(Dashboard::class)
            ->set('nome', $value)
            ->call('store')
            ->assertHasErrors(['nome' => $rule]);
    })
        ->with([
            'required' => ['required', ''],
            'min' => ['min', 'Jo'],
            'max' => ['max', str_repeat('a', 66)]
        ]);
    test('email', function ($rule, $value) {
        Livewire::test(Dashboard::class)
            ->set('email', $value)
            ->call('store')
            ->assertHasErrors(['email' => $rule]);
    })
        ->with([
            'required' => ['required', ''],
            'email' => ['email', 'not-valid-email'],
            'max' => ['max', str_repeat('a', 255) . '@doe.com']
        ]);
    test('telefone', function ($rule, $value) {
        Livewire::test(Dashboard::class)
            ->set('telefone', $value)
            ->call('store')
            ->assertHasErrors(['telefone' => $rule]);
    })
        ->with([
            'required' => ['required', ''],
            'min' => ['min', '1111'],
            'max' => ['max', '11111111111'],
            'regex' => ['regex', '1111-111']
        ]);
    test('cargo', function ($rule, $value) {
        Livewire::test(Dashboard::class)
            ->set('cargo', $value)
            ->call('store')
            ->assertHasErrors(['cargo' => $rule]);
    })
        ->with([
            'required' => ['required', ''],
            'max' => ['max', str_repeat('a', 256)],
        ]);
    test('escolaridade', function ($rule, $value) {
        Livewire::test(Dashboard::class)
            ->set('escolaridade', $value)
            ->call('store')
            ->assertHasErrors(['escolaridade' => $rule]);
    })
        ->with([
            'required' => ['required', ''],
        ]);
    test('arquivo should be required', function () {
        Livewire::test(Dashboard::class)
            ->set('arquivo', '')
            ->call('store')
            ->assertHasErrors(['arquivo' => __('validation.required', ['attribute' => 'arquivo'])]);
    });
    test('arquivo should be file', function () {
        Livewire::test(Dashboard::class)
            ->set('arquivo', 'not-a-file')
            ->call('store')
            ->assertHasErrors(['arquivo' => __('validation.file', ['attribute' => 'arquivo'])]);
    });
    test('arquivo should valid mimes type', function () {
        $file = createFakeFile('resume.csv', 100, 'text/csv');
        Livewire::test(Dashboard::class)
            ->set('arquivo', $file)
            ->call('store')
            ->assertHasErrors();
    });
    test("arquivo size shouldn't be greater then 1mb", function () {
        $file = createFakeFile('resume.pdf', 1500, 'pdf');
        Livewire::test(Dashboard::class)
            ->set('arquivo', $file)
            ->call('store')
            ->assertHasErrors(['arquivo' => __('validation.max.file', ['attribute' => 'arquivo', 'max' => '1024'])]);
    });
});
function createFakeFile(string $name, int $size, string $mimeType): UploadedFile
{
    return UploadedFile::fake()->create($name, $size, $mimeType);
}
