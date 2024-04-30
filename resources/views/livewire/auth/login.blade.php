<x-card title="Login" shadow class="mx-auto w-[450px] bg-gray-100 dark:bg-gray-900">

    @if($errors->hasAny(['invalidCredentials']))
        <x-alert icon="o-exclamation-triangle" class="alert-warning mb-4">
            @error('invalidCredentials')
            <span>{{ $message }}</span>
            @enderror
        </x-alert>
    @endif

    <x-form wire:submit="login">
        <x-input label="Email" wire:model="email" />
        <x-input label="Password" wire:model="password" type="password"/>
        <x-slot:actions>
            <div class="w-full flex items-center justify-center">
                <div>
                    <x-button label="Login" class="bg-purple-200" type="submit" spinner="submit" icon="o-paper-airplane"/>
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
