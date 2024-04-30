<div>
    <x-form wire:submit="store">
        <x-input label="Nome" wire:model="nome" />
        <x-input label="E-mail" wire:model="email" />
        <x-input label="Telefone" wire:model="telefone" />
        <x-input label="Cargo" wire:model="cargo" />
        <x-select label="Escolaridade" :options="$escolaridades" wire:model="escolaridade" />
        <x-textarea
            label="Observações"
            wire:model="observacoes"
            inline />
        <x-file wire:model="arquivo" label="Arquivo" hint="PDF, DOC, DOCX"/>
        <x-datetime label="Data e hora" wire:model="data_envio" icon="o-calendar" type="datetime-local" />
        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Store" class="btn-primary" type="submit" spinner="store" />
        </x-slot:actions>
    </x-form>
</div>
