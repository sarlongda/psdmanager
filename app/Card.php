<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Card extends Model
{

    public $fillable = ['article_id', 'title', 'sales_count', 'category_id', 'age', 'gender', 'plz', 'city', 'street'];


    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function category() {
        return $this->belongsTo('App\Category') ;
    }
}