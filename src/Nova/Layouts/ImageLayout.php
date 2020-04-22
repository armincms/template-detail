<?php

namespace Armincms\TemplateDetail\Nova\Layouts;
 
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Spatie\MediaLibrary\MediaRepository;
use Armincms\Nova\Fields\Images;
use Armincms\TemplateDetail\TemplateDetail;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Ebess\AdvancedNovaMediaLibrary\Fields\Media;


class ImageLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'image';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Image';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make(__('Image'), 'image') 
                ->rules('required')
                ->required(),
        ];
    }  

    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('pattern')->singleFile();
        $this->addMediaCollection('slider');
        $this->addMediaCollection('custom_font');
    } 
}