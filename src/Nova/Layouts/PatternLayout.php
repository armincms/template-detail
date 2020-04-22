<?php

namespace Armincms\TemplateDetail\Nova\Layouts; 

use Armincms\Nova\Fields\Images;

class PatternLayout extends ImageLayout 
{  
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'pattern';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Pattern Image';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make(__('Pattern'), 'pattern')
                ->rules('required')
                ->required(),
        ];
    }  
}