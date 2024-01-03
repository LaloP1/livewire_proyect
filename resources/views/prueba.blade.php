<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Prueba
        </h2>
    </x-slot>
    @persist('player')
    <audio src="{{ asset('audio/Recording.m4a') }}" controls></audio>
    @endpersist

    <script>
        console.log('hola de prueba');
    </script>
</x-app-layout>
