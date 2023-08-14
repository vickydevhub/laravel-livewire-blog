<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post as Posts;

class Post extends Component
{
    public $posts, $title, $content, $postId, $updatePost = false, $addPost = false;
 
    /**
     * delete action listener
     */
    protected $listeners = [
        'deletePostListner'=>'deletePost'
    ];
 
    /**
     * List of add/edit form rules
     */
    protected $rules = [
        'title' => 'required',
        'content' => 'required'
    ];
 
    /**
     * Resetting all inputted fields
     * @return void
     */
    public function resetFields(){
        $this->title = '';
        $this->content = '';
    }
 
    /**
     * Render the post data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->posts = Posts::select('id', 'title', 'content')->get();
        return view('livewire.post');
    }
 
    /**
     * Open Create Post form
     * @return void
     */
    public function addPost()
    {
        $this->resetFields();
        $this->addPost = true;
        $this->updatePost = false;
    }
     /**
      * store the post data in the posts table
      * @return void
      */
    public function storePost()
    {
        $this->validate();
        try {
            Posts::create([
                'title' => $this->title,
                'content' => $this->content
            ]);
            session()->flash('success','Post Created Successfully!!');
            $this->resetFields();
            $this->addPost = false;
        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!');
        }
    }
 
    /**
     * show selected post data in edit post form
     * @param mixed $id
     * @return void
     */
    public function editPost($id){
        try {
            $post = Posts::findOrFail($id);
            if( !$post) {
                session()->flash('error','Post not found');
            } else {
                $this->title = $post->title;
                $this->content = $post->content;
                $this->postId = $post->id;
                $this->updatePost = true;
                $this->addPost = false;
            }
        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!');
        }
 
    }
 
    /**
     * update post data
     * @return void
     */
    public function updatePost()
    {
        $this->validate();
        try {
            Posts::whereId($this->postId)->update([
                'title' => $this->title,
                'content' => $this->content
            ]);
            session()->flash('success','Post Updated Successfully!!');
            $this->resetFields();
            $this->updatePost = false;
        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }
 
    /**
     * Cancel Add/Edit form and redirect to post listing page
     * @return void
     */
    public function cancelPost()
    {
        $this->addPost = false;
        $this->updatePost = false;
        $this->resetFields();
    }
 
    /**
     * delete selected post data from the posts table
     * @param mixed $id
     * @return void
     */
    public function deletePost($id)
    {
        try{
            Posts::find($id)->delete();
            session()->flash('success',"Post Deleted Successfully!");
        }catch(\Exception $e){
            session()->flash('error',"Something went wrong!!");
        }
    }
}
