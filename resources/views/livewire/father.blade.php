<div>

    <x-button wire:click="redirigir">
        Ir a prueba
    </x-button>
    <h1 class="text-2xl font-semibold">
        Soy el componente padre
    </h1>
    <x-input type="text" wire:model.live="name"></x-input>
    <p>
        {{ $name }}
    </p>
    <hr class="my-6">
    <div>
        {{-- @livewire('children', [
        ], key('contador-1')) --}}

        <livewire:children :name="$name" />
    </div>

    <script>
        console.log('hola desde padre');
    </script>
</div>
