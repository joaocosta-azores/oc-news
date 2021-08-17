<?php namespace Vancoders\News\Models;

use Model;
use Vancoders\News\Models\Category;
use Illuminate\Support\Facades\DB;
use Vancoders\News\Models\Settings;

/**
 * Model
 */
class Post extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    public $implement = ['Winter.Translate.Behaviors.TranslatableModel'];

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'vancoders_news_posts';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Translatable fields
     */
    public $translatable = [
        'name',
        ['slug', 'index' => true],
        'subhead',
        'introduction',
        'content'
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    public function getCategoryIdOptions() {
        return Category::lists('name', 'id');
    }

    public $hasOne = [
        'post_category' => [
            'Vancoders\News\Models\Category',
            'key' => 'id',
            'otherKey' => 'category_id'
        ]
    ];

    public function importFromOldDatabase() {
        $oldrecords = Db::connection('oldmysql')->select('select title, content, timestamp,  datetime, file_name, relative_path, author, pubtype_id from publication INNER JOIN publication_pubtype ON publication.id = publication_pubtype.publication_id limit 60');
        foreach($oldrecords as $record) {
            $post = new Post;
            $post->name = $record->title;
            $post->slug = str_slug($record->title, "-");
            $post->content = $record->content;
            $post->author = $record->author;
            $post->created_at = $record->datetime;
            $post->updated_at = $record->timestamp;
            if($record->pubtype_id == 1) {
                $post->category_id = Category::where('slug', 'noticias')->first()->id;
            } else if($record->pubtype_id == 2) {
                $post->category_id = Category::where('slug', 'desporto')->first()->id;
            } else {
                continue;
            }
            $post->image = realpath (base_path('../public/assets/upload/')) . '/' . $record->relative_path . 'large/' . $record->file_name;
            $post->save();
        }
    }

    public function filterCategory()
    {
        $result = [];

        foreach (Category::where('status', 1)->orderBy('name', 'asc')->get()->all() as $item) {
            $result[$item->id] = $item->name;
        }

        return $result;
    }

    public function filterFields($fields, $context = null)
    {
            $fields->subhead->hidden = !Settings::get('subhead', true);
    }
}
