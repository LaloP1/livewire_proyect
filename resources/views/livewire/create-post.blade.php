{{-- Todo el contenido de un componente siempre debe de estar en una etiqueta padre --}}
<div>
    {{-- <h1>{{ $name }} </h1> --}}
    <div>
        <x-input type="text" wire:model.live="name" />

        <x-button wire:click="save">
            Save
        </x-button>
    </div>

    <p>{{ $name }}</p>
</div>
