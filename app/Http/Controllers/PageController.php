<?php
namespace App\Http\Controllers;
 use App\Models\{Article,Category};
 
 class PageController extends Controller {
    public function home(){
        return view('pages.home',['featured'=>Article::with('category')
        ->where('is_featured',true)
        ->first(),'latest'=>Article::with('category')
        ->latest('published_at')->take(6)->get()]);}
        
    public function news(){
        return $this->listing('Actualités',Article::with('category')
        ->where('type','article'));}
        
    public function videos(){
        return $this->listing('Vidéos',Article::with('category')
        ->where('type','video'));}
        
    public function magazines(){
        return $this->listing('Magazines',Article::with('category')
        ->where('type','magazine'));}
        
    public function business(){
            return $this->listing('Sport & Business',Article::with('category')
            ->whereHas('category',fn($q)=>$q
            ->where('slug','sport-business')));}
    
    public function category(Category $category){
        return view('pages.list',
        ['title'=>$category->name,
        'description'=>$category->description,
        'articles'=>$category->articles()->latest('published_at')
        ->paginate(12)]);}
        
    private function listing($title,$q){
        return view('pages.list',
        ['title'=>$title,'articles'=>$q->
        latest('published_at')->paginate(12)]);}}