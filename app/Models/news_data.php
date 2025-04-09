<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news_data extends Model
{
    use HasFactory;

    protected $table = 'news_data'; 

    protected $fillable = ['title', 'link', 'description', 'published_at', 'image_url'];
}
