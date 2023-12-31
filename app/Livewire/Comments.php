<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Comments extends Component
{
    public $comments = [];

    #[On('post-created')]
    public function addComment($comment){
        //array_unshift agrega un nuevo elemento al inicio del array
        //Tiene dos partes el array, y el elemento que vamos a agregarle
        array_unshift($this->comments, $comment);
    }

    #[On('post-updated')]
    public function updateComment($comment){
        array_unshift($this->comments, $comment);
    }
    #[On('post-deleted')]
    public function deleteComment($comment){
        array_unshift($this->comments, $comment);
    }
    public function render()
    {
        return view('livewire.comments');
    }
}
