<?php namespace Vancoders\News\Models;

use Model;
use Vancoders\News\Models\Category;
use Illuminate\Support\Facades\DB;
use Vancoders\News\Models\Settings;
use Winter\Translate\Models\Locale;
use Faker\Factory;
use System\Models\File;

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

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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

    /**
     * @param int $quantity
     * @throws \Exception
     */

    static function createDummy(int $quantity = 1)
    {
        $i = 0;
        $faker = Factory::create();
        while($i < $quantity) {

            $category = Category::first();
            if ($category == null) {
                $name = $faker->words(rand(3,5), true);
                $category_id = Category::create([
                    'name' => $name,
                    'slug' => str_replace($name, " ", "-"),
                ])->id;
            } else {
                $category_id = $category->id;
            }
            $name = $faker->words(rand(3,5), true);
            $file = new File;
            $post = Post::create([
                'category_id' => $category_id,
                'name' => $name,
                'slug' => str_replace($name, " ", "-"),
                'author' => $faker->name,
                'subhead' => $faker->words(rand(5,10), true),
                'introduction' => $faker->sentence(rand(12,20)),
                'content' =>  $faker->paragraph(4),
                'image' =>  $file->fromUrl('https://picsum.photos/960/540'),
            ]);
            $created_post = Post::find($post->id);
            // Set translations for record
            foreach (Locale::listAvailable() as $code => $lang) {
                $created_post->translateContext($code);
                $created_post->name = $faker->words(rand(3,5), true);
                $created_post->slug = str_replace($name, " ", "-");
                $created_post->save();
            }
            $i++;
        }
    }

    static function importData() {
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

    /**
     * @return array
     */

    public function filterCategory(): array
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
