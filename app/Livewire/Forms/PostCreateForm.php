<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;
use App\Models\Post;


class PostCreateForm extends Form
{
    #[Rule('required')]
    public $title;

    #[Rule('required')]
    public $content;

    //exists:categories,id: Esta regla valida si el valor proporcionado para $category_id existe en la tabla de la base de datos llamada "categories" en la columna "id". En otras palabras, se asegura de que el valor proporcionado sea un ID válido de una categoría existente en la base de datos.
    #[Rule('required|exists:categories,id')]
    public $category_id = '';

    //En este caso, se está definiendo la propiedad $tags con la regla required|array. Esto significa que $tags es un campo obligatorio y debe ser un array. Si estás trabajando con formularios que requieren múltiples valores para un solo campo (como etiquetas), utilizar un array es una forma común de manejarlos
    #[Rule('required|array')]
    public $tags = [];

    #[Rule('nullable|image|max:1024')]
    public $image;

    public $imageKey;

    public function save(){
        //Crea una validacion para hacer los campos requeridos
        // Accede a la instancia del objeto y ejecuta el método de validación
        $this->validate();

        $post = Post::create(
            $this->only('title','content','category_id')
        );


        //Asociamos los valores de postCreate con post
        $post->tags()->attach($this->tags);

        if($this->image){
            $post->image_path = $this->image->store('posts');
            $post->save();
        }

        //Accedemos al objeto y reseteamos los valores
        $this->reset();

        $this->imageKey = rand();
    }
}
