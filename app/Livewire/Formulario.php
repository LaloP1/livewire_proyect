<?php

namespace App\Livewire;

use App\Livewire\Forms\PostCreateForm;
use App\Livewire\Forms\PostEditForm;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Formulario extends Component
{
    //Definicion de propiedades
    public $categories, $tags;

    public $posts;

    //postCreate es una variable que actuara como instancia del FormObject
    //En pocas palabras se está declarando una propiedad llamada $postCreate y se está indicando que su tipo es PostCreateForm.
    //Esto significa que se espera que la variable $postCreate contenga una instancia de la clase PostCreateForm o de una clase que herede de PostCreateForm.
    public PostCreateForm $postCreate;

    public PostEditForm $postEdit;

    //ciclo de vida de un componente
    public function mount(){
        $this->categories = Category::all();
        $this->tags = Tag::all();
        $this->posts = Post::all();
    }

    public function updating($property, $value){
        if($property == 'postCreate.category_id'){
            if($value > 3){
                throw new \Exception("No puedes seleccionar este valor");
            }
        }
    }
    public function updated($property, $value){
    }
    public function hydrate(){

    }
    public function dehydrate(){

    }
    public function save(){
        $this->postCreate->save();
        $this->posts = Post::all();

        //Emitimos un evento
        //Informamos que se esta ejecuntando un evento
        $this->dispatch('post-created', 'Nuevo articulo creado');
    }
    public function edit($postId){
        $this->resetValidation();
        $this->postEdit->edit($postId);
    }
    public function update(){
        $this->postEdit->update();
        $this->posts = Post::all();
        $this->dispatch('post-updated', 'Articulo actualizado');
    }

    public function destroy($postId){
        //Busca el id en el Modelo
        $post = Post::find($postId);
        //Ejecuta la eliminacion
        $post->delete();
        //Refresca los post
        $this->posts = Post::all();
        $this->dispatch('post-deleted', 'Articulo eliminado');

    }

    public function render()
    {
        return view('livewire.formulario');
    }
}
