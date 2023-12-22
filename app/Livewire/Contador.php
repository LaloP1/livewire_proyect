<?php

namespace App\Livewire;

use Livewire\Component;

class Contador extends Component
{
    public $contador = 0;
    public function restar(){
        $this->contador = $this->contador - 1;
    }

    // Aqui estoy recibiendo una variable que contiene ese parametro
    public function sumar($valor){
        $this->contador += $valor;
    }
    public function render()
    {
        return view('livewire.contador');
    }
}
