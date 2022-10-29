<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //protected $fillable = ['title', 'excerpt', 'body']; alternativa je quarder, kjer je obratno
    //zaščitiš česa nočeš not
    protected $guarded = ['id']; //ne želimo, da se id dodaja s strani uporabnika


    protected $with = ['category', 'author'];


    /* Alternativni način temu, da namesto idja
    uporabimo slug pri izbiri bloga iz baze

    Nedolgo nazaj je bil to edini način
    */
    /*public function getRouteKeyName()
    {
        return 'slug';
    }*/

    public function scopeFilter($query, array $filters) {
        $query->when($filters['search'] ?? false, fn ($query, $search) =>
        $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $search . '%' )
                ->orWhere('body', 'like', '%' . $search . '%' )));

        $query->when($filters['category'] ?? false, fn ($query, $category) =>
            $query->whereHas('category', fn($query) =>
                $query->where('slug', $category)));

        $query->when($filters['author'] ?? false, fn ($query, $author) =>
            $query->whereHas('author', fn($query) =>
                $query->where('username', $author)));
       /* težja metoda -  $query
                ->whereExists(fn($query)=>
                    $query->from('categories')
                            ->whereColumn('categories.id', 'posts.category_id')
                            ->where('categories.slug', $category)
        ));*/
    }

    public function comments() {
        //hasOne, hasMany, belongsTo, belongsToMany
        return $this->hasMany(Comment::class);
    }

    public function category() {
        //hasOne, hasMany, belongsTo, belongsToMany
        return $this->belongsTo(Category::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
