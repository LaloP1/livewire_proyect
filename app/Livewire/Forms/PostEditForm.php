<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostEditForm extends Form
{
    public $postEditId = '';

    public $open = false;

    #[Rule('required|min:3')]
    public $title;

    #[Rule('required')]
    public $content;

    //exists:categories,id: Esta regla valida si el valor proporcionado para $category_id existe en la tabla de la base de datos llamada "categories" en la columna "id". En otras palabras, se asegura de que el valor proporcionado sea un ID válido de una categoría existente en la base de datos.
    #[Rule('required|exists:categories,id')]
    public $category_id = '';

    //En este caso, se está definiendo la propiedad $tags con la regla required|array. Esto significa que $tags es un campo obligatorio y debe ser un array. Si estás trabajando con formularios que requieren múltiples valores para un solo campo (como etiquetas), utilizar un array es una forma común de manejarlos
    #[Rule('required|array')]
    public $tags = [];

    public function edit($postId){
        $this -> open = true;

        //Vamos a asignarle a postEditId el valor que contiene postId
        $this->postEditId = $postId;

        //busca la info a traves del id para encontrar el post a editar
        $post = Post::find($postId);

        //Dice que el nuevo dato reemplaza al dato antiguo
        $this->category_id = $post->category_id;
        $this->title= $post->title;
        $this->content = $post-> content;

        $this->tags = $post->tags->pluck('id')->toArray();

    }
    public function update(){
        $this->validate();
        $post = Post::find($this->postEditId);
        $post->update(
            $this->only('category_id', 'title', 'content')
        );
        $post->tags()->sync($this->tags);

        $this->reset(['postEditId', 'postEdit', 'open']);
    }
}
