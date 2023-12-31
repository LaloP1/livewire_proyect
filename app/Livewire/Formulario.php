<?php

namespace App\Livewire;

use App\Livewire\Forms\PostCreateForm;
use App\Livewire\Forms\PostEditForm;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[ Lazy ]
class Formulario extends Component
{

    use WithFileUploads;
    use WithPagination;

    //Definicion de propiedades
    public $categories, $tags;

    //postCreate es una variable que actuara como instancia del FormObject
    //En pocas palabras se está declarando una propiedad llamada $postCreate y se está indicando que su tipo es PostCreateForm.
    //Esto significa que se espera que la variable $postCreate contenga una instancia de la clase PostCreateForm o de una clase que herede de PostCreateForm.
    public PostCreateForm $postCreate;

    public PostEditForm $postEdit;

    #[Url(as: 'buscar')]
    public $search = '';

    //ciclo de vida de un componente
    public function mount(){
        $this->categories = Category::all();
        $this->tags = Tag::all();
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

        $this->resetPage(pageName: 'pagePosts');

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
        $this->dispatch('post-updated', 'Articulo actualizado');
    }

    public function destroy($postId){
        //Busca el id en el Modelo
        $post = Post::find($postId);
        //Ejecuta la eliminacion
        $post->delete();
        //Refresca los post
        $this->dispatch('post-deleted', 'Articulo eliminado');

    }

    public function placeholder(){
        return view('livewire.placeholders.skeleton');
    }
    public function render()
    {
        $posts = Post::orderBy('id', 'desc')
        ->when($this->search, function($query){
            $query->where('title', 'like', '%' . $this->search . '%');
        })
        ->paginate(5, pageName: 'pagePosts');
        return view('livewire.formulario', compact('posts'));
    }
}
