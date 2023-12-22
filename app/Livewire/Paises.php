<?php

namespace App\Livewire;

use Livewire\Component;

class Paises extends Component
{
    public $paises = [
        'Argentina',
        'Peru',
        'Mexico',
    ];
    public $pais;
    public $active;
    public $contador = 0;

    public function save(){
        array_push($this->paises, $this->pais);
        $this->reset('pais');
    }
    public function delete($index){
            unset($this->paises[$index]);
            // Reindexar el array después de eliminar un elemento
            $this->paises = array_values($this->paises);
    }
    public function changeActive($pais){
        $this->active = $pais;
    }
    public function increment(){
        $this->contador++;
    }
    public function render()
    {
        return view('livewire.paises');
    }
}
