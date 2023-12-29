<div>
    <div class="bg-white shadow rounded-lg p-6 mb-[15px]">
        <form wire:submit="save">
            <div class="mb-4">
                <x-label>
                    Nombre
                </x-label>
                <x-input class="w-full"
                wire:model="title" />
                <x-input-error for="title"></x-input-error>
            </div>
            <div class="mb-4">
                <x-label>
                    Contenido
                 </x-label>
                <x-textarea class="w-full"
                wire:model="content">
                </x-textarea>
                <x-input-error for="content"></x-input-error>
            </div>
            <div class="mb-4 w-full">
                <x-label>
                    Categorias
                </x-label>
                    <x-select class="w-full"
                    wire:model="category_id">
                        <option value="" disabled>Seleccione una categoria</option>
                        @foreach ($categories as $category )
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </x-select>
                    <x-input-error for="category_id"></x-input-error>
            </div>
            <div class="mb-4 ">
                <x-label>
                    Etiquetas
                </x-label>

                <ul>
                    @foreach ($tags as $tag )
                        <li>
                            <label>
                                <x-checkbox wire:model="selectedTags" value="{{ $tag->id }}" />
                                {{ $tag->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
                <x-input-error for="selectedTags"></x-input-error>
            </div>
            <div class="flex justify-end">
                <x-button>
                    Crear
                </x-button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6 ">
        <ul class="list-disc list-inside space-y-2">
            @foreach ($posts as $post)
            <li class="flex justify-between"
            {{-- se utiliza para optimizar el rendimiento de Livewire al gestionar listas dinámicas y garantizar que Livewire pueda realizar actualizaciones eficientes al seguir los cambios en elementos específicos de la interfaz de usuario--}}
            wire:key="post-{{ $post->id }}">
                {{ $post->title }}
                <div>
                    <x-button wire:click="edit({{ $post->id }})">
                        Editar
                    </x-button>
                    <x-danger-button wire:click="destroy({{ $post->id }})">
                        Eliminar
                    </x-danger-button>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- Formulario de edicion --}}
    <form wire:submit="update">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar el Post
            </x-slot>
            <x-slot name="content">
                    <div class="mb-4">
                        <x-label>
                            Nombre
                        </x-label>
                        <x-input class="w-full"
                        {{-- Estoy sincronizando el contenido de postEdit con el formulario input --}}
                        wire:model="postEdit.title"
                        />
                    </div>
                    <div class="mb-4">
                        <x-label>
                            Contenido
                        </x-label>
                        <x-textarea class="w-full"
                        wire:model="postEdit.content"
                        ></x-textarea>
                    </div>
                    <div class="mb-4 w-full">
                        <x-label>
                            Categorias
                        </x-label>
                            <x-select class="w-full"
                            wire:model="postEdit.category_id">
                                <option value="" disabled>Seleccione una categoria</option>
                                @foreach ($categories as $category )
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </x-select>
                    </div>
                    <div class="mb-4 ">
                        <x-label>
                            Etiquetas
                        </x-label>

                        <ul>
                            @foreach ($tags as $tag )
                                <li>
                                    <label>
                                        <x-checkbox wire:model="postEdit.tags" value="{{ $tag->id }}" />
                                        {{ $tag->name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button
                    class=" mr-3"
                    wire:click="$set('open', false)">
                        Cancelar
                    </x-danger-button>
                    <x-button>
                        Editar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </form>

</div>
