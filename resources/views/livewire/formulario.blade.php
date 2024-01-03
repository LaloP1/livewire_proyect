<div>
    <div class="bg-white shadow rounded-lg p-6 mb-[15px]">

        @if($postCreate->image)

            <img class="mb-4" src="{{ $postCreate->image->temporaryUrl() }}" alt="">

        @endif

        <form wire:submit="save">
            <div class="mb-4">
                <x-label>
                    Nombre
                </x-label>
                <x-input class="w-full"
                wire:model="postCreate.title" />
                <x-input-error for="postCreate.title"></x-input-error>
            </div>
            <div class="mb-4">
                <x-label>
                    Contenido
                 </x-label>
                <x-textarea class="w-full"
                wire:model="postCreate.content">
                </x-textarea>
                <x-input-error for="postCreate.content"></x-input-error>
            </div>
            <div class="mb-4 w-full">
                <x-label>
                    Categorias
                </x-label>
                    <x-select class="w-full"
                    wire:model.live="postCreate.category_id">
                        <option value="" disabled>Seleccione una categoria</option>
                        @foreach ($categories as $category )
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </x-select>
                    <x-input-error for="postCreate.category_id"></x-input-error>
            </div>

            <div class="mb-4">
                <x-label>
                    Imagen
                </x-label>

                <div
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                    <input
                    type="file"
                    wire:model="postCreate.image"
                    wire:key="{{ $postCreate->imageKey }}" />

                    <!-- Progress Bar -->
                    <div x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>
            </div>

            <div class="mb-4 ">
                <x-label>
                    Etiquetas
                </x-label>

                <ul>
                    @foreach ($tags as $tag )
                        <li>
                            <label>
                                <x-checkbox wire:model="postCreate.tags" value="{{ $tag->id }}" />
                                {{ $tag->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
                <x-input-error for="postCreate.tags"></x-input-error>
            </div>
            <div class="flex justify-end">
                <x-button>
                    Crear
                </x-button>
            </div>
        </form>

        <div class="justify-between" wire:loading.delay>
            <div>
                Hola
            </div>
            <div>
                Mundo
            </div>
        </div>
        {{-- <div wire:loading wire:target="save">
            Procesando ...
        </div> --}}

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
        <div class="mt-4">
            {{ $posts->links('vendor.livewire.simple-tailwind') }}
        </div>
    </div>

    {{-- Formulario de edicion --}}
    <form wire:submit="update">
        <x-dialog-modal wire:model="postEdit.open">
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
                        wire:model.live="postEdit.title"
                        />
                        <x-input-error for="postEdit.title"></x-input-error>
                    </div>
                    <div class="mb-4">
                        <x-label>
                            Contenido
                        </x-label>
                        <x-textarea class="w-full"
                        wire:model="postEdit.content"
                        ></x-textarea>
                        <x-input-error for="postEdit.content"></x-input-error>
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
                            <x-input-error for="postEdit.category_id"></x-input-error>
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
                        <x-input-error for="postEdit.tags"></x-input-error>
                    </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button
                    class=" mr-3"
                    wire:click="$set('postEdit.open', false)">
                        Cancelar
                    </x-danger-button>
                    <x-button>
                        Editar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </form>

    @push('js')
        <script>
            // Le estoy diciendo que se ejecute cuando livewire este actualizado
            // documment.addEventListener('livewire:initialized', function(){
                Livewire.on('post-updated', function(comment){
                    console.log(comment[0]);
                });
            // });
        </script>
    @endpush

</div>
