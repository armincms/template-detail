<?php

namespace Armincms\TemplateDetail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Armincms\Concerns\IntractsWithMedia; 
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Cviebrock\EloquentSluggable\Sluggable; 

class TemplateDetail extends Model implements HasMedia
{
    use SoftDeletes, IntractsWithMedia, sluggable;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'json'
    ]; 

    protected $medias = [
        'image' => [    
            'disk'     => 'armin.image',
            'schemas'  => [
                '*',
            ],
        ], 

        'pattern' => [  
            'disk'     => 'armin.image',
            'schemas'  => [
                '*',
            ],
        ], 

        'slider' => [  
        	'multiple' => true,
            'disk'     => 'armin.image',
            'schemas'  => [
                '*',
            ],
        ], 

        'custom_font' => [  
            'multiple' => true,
            'disk'     => 'armin.image',
            'schemas'  => [],
        ], 
    ];  

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot(); 

        static::saving(function($model) {
            if(request()->isMethod('post')) {
                $model->changeMedias();
            }
        }); 

        self::saved(function($model) {
            $model->all()->toFile(__DIR__.'/../config/config.php'); 
            \Artisan::call('config:cache');
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    { 
        return [
            'name' => [
                'source' => 'label'
            ]
        ];  
    }

    public function changeMedias()
    { 
        $this->medias = collect($this->medias)->transform(function($media) {
            $media['multiple'] = true;

            return $media;
        });
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    } 

    public function details()
    {
        switch ($group = $this->group()) {
            case 'image':
            case 'pattern':
                return $this->getFirstMediaUrl($group);
                break;

            case 'slider': 
            case 'custom_font':  
                return $this->getMedia($group)->map->getUrl();
                break;
            
            default:
                return $this->flexible($group);
                break;
        }   
    }

    public function flexible(string $group, string $attribute = null)
    {
        return data_get(
            collect($this->config)->where('layout', $group)->first(), 
            'attributes'.($attribute ? ".{$attribute}" : '')
        ); 
    }  

    public function group()
    {
        return static::groups()->keys()->first(function($group) { 
            return ! is_null($this->flexible($group));
        });
    }


    public static function groups()
    {
        return collect([
            'color'   => __('Color'),
            'svg'     => __('SVG'),
            'pattern' => __('Pattern'),
            'image'   => __('Image'),
            'slider'  => __('Slider'),
            'class'   => __('Class'),
            'google_font'    => __('Google Font'),
            'custom_font'    => __('Custom Font'),
        ]);
    }
}
