<?php

namespace Armincms\TemplateDetail\Nova\Layouts; 

use Armincms\Nova\Fields\Images;

class SliderLayout extends ImageLayout 
{  
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'slider';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Slide Image';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make(__('Slider'), 'slider')
                ->multiple(true)
                ->rules('required')
                ->required(),
        ];
    }  
}