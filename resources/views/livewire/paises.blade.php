<div>
    {{-- @livewire('hijo') --}}

    <x-button class="mb-4" wire:click="$set('contador', 0)">
        Resetear
    </x-button>

    <x-button class="mb-4" wire:click="$toggle('open')">
        Mostrar / Ocultar
    </x-button>


    <form class="mb-[20px]" wire:submit="save">
        {{-- Aqui estoy vinculando mi input para que guarde el valor en su variable  --}}
        <x-input
         wire:model="pais"
         placeholder="Ingrese un pais"
         wire:keydown.space="increment"  />
        <x-button>
            Agregar
        </x-button>
    </form>
    @if ($open)
        <ul class="list-disc list-inside space-y-2">
            @foreach ($paises as $index => $pais)
                <li wire:key="pais-{{ $index }}">
                    <span wire:mouseenter="changeActive('{{ $pais }}')">
                        ({{ $index }}) {{ $pais }}
                    </span>
                    <x-danger-button wire:click="delete({{ $index }})">
                        x
                    </x-danger-button>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- {{ $active }} --}}
    {{ $contador }}
</div>
