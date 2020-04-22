<?php

namespace Armincms\TemplateDetail\Nova\Layouts;
 
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Spatie\MediaLibrary\MediaRepository;
use Armincms\Nova\Fields\Files;
use Armincms\TemplateDetail\TemplateDetail;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Ebess\AdvancedNovaMediaLibrary\Fields\Media;


class FontLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'custom_font';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Custom Font';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Files::make(__('Font File'), 'custom_font') 
                ->multiple()
                ->required() 
                ->rules(['required', function($attribute, $value, $fail) {
                    collect($value)->every(function($file) use ($fail) {
                        if(! is_object($file)) {
                            return true;
                        }

                        if(! in_array($file->getClientOriginalExtension(), $this->getValidFonts())) {
                            $fail("Invalid Font {$file->getClientOriginalName()}");
                        } 
                    }); 
                }]),
        ];
    }  

    public function registerMediaCollections()
    { 
        $this->addMediaCollection('custom_font');
    } 

    public function getValidFonts()
    {
        return [
            'ttf', 'eot', 'woff', 'woff2', 'svg', 'otf'
        ];
    }
}