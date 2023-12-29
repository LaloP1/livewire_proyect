<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use Livewire\Attributes\Rule;

class Formulario extends Component
{
    //Definicion de propiedades
    public $categories, $tags;

    public $posts;


    #[Rule([
        'postCreate.title' => 'required',
        'postCreate.content' => 'required',
        'postCreate.category_id'=>'required|exists:categories,id',
        'postCreate.tags'=>'required|array'
    ], [], [
        'postCreate.title'=>'titulo',
        'postCreate.content' => 'contenido',
        'postCreate.category_id'=>'categoria',
        'postCreate.tags'=>'etiqueta'
    ])]
    public $postCreate =[
        'category_id' => '',
        'title' => '',
        'content' => '',
        'tags' => []
    ];

    public $postEditId = '';

    public $open = false;
    public $postEdit = [
        'category_id' => '',
        'title' => '',
        'content' => '',
        'tags' => []
    ];

    public function mount(){
        $this->categories = Category::all();
        $this->tags = Tag::all();
        $this->posts = Post::all();
    }
    public function save(){

        //Crea una validacion para hacer los campos requeridos
        $this->validate();


        // $this->validate([
        //     'title'=>'required',
        //     'content'=>'required',
        //     'category_id'=>'required|exists:categories,id',
        //     'selectedTags'=> 'required|array'
        // ],[
        //     'title.required'=>'El campo titulo es requerido',
        // ],[
        //     'category_id'=>'categoria',
        // ]);

        // $post = Post::create([
        //     'category_id' => $this->category_id,
        //     'title' => $this->title,
        //     'content' => $this->content
        // ]);

        $post = Post::create([
            'category_id' => $this->postCreate['category_id'],
            'title' => $this->postCreate['title'],
            'content' => $this->postCreate['content']
        ]);

        $post->tags()->attach($this->postCreate['tags']);

        $this->reset(['postCreate']);
        $this->posts = Post::all();
        // dd(
        //     [
        //     'category_id' => $this->category_id,
        //     'title' => $this->title,
        //     'content' => $this->content,
        //     'tags' => $this->selectedTags,
        // ]);
    }
    public function edit($postId){
        $this->resetValidation();
        $this -> open = true;

        //Vamos a asignarle a postEditId el valor que contiene postId
        $this->postEditId = $postId;

        //busca la info a traves del id para encontrar el post a editar
        $post = Post::find($postId);

        //Dice que el nuevo dato reemplaza al dato antiguo
        $this->postEdit['category_id'] = $post->category_id;
        $this->postEdit['title']= $post->title;
        $this->postEdit['content'] = $post-> content;

        $this->postEdit['tags'] = $post->tags->pluck('id')->toArray();

    }
    public function update(){

        $this->validate([
            'postEdit.title' => 'required',
            'postEdit.content' => 'required',
            'postEdit.category_id'=>'required|exists:categories,id',
            'postEdit.tags'=>'required|array'
        ]);

        $post = Post::find($this->postEditId);
        $post->update([
            'category_id' => $this->postEdit['category_id'],
            'title' => $this->postEdit['title'],
            'content' => $this->postEdit['content']
        ]);
        $post->tags()->sync($this->postEdit['tags']);

        $this->reset(['postEditId', 'postEdit', 'open']);

        $this->posts = Post::all();
    }
    public function destroy($postId){
        //Busca el id en el Modelo
        $post = Post::find($postId);
        //Ejecuta la eliminacion
        $post->delete();
        //Refresca los post
        $this->posts = Post::all();
    }
    public function render()
    {
        return view('livewire.formulario');
    }
}
