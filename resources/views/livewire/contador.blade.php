<div>
    <x-button wire:click="restar">
        -
    </x-button>

    <span class="mx-[20px]">
        {{ $contador }}
    </span>

    {{-- sumar(5) estoy declarando una funcion que contiene un parametro --}}
    <x-button wire:click="sumar(5)">
        +
    </x-button>
</div>
