<?php

namespace Armincms\TemplateDetail\Nova;
     
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\File; 
use Laravel\Nova\Fields\Code; 
use Laravel\Nova\Fields\Select; 
use Laravel\Nova\Fields\Image; 
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Textarea; 
use OwenMelbz\RadioField\RadioButton;
use Timothyasp\Color\Color; 
use Whitecube\NovaFlexibleContent\Flexible;


class TemplateDetail extends Resource
{ 
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\TemplateDetail\\TemplateDetail';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'label';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'label', 'name'
    ]; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    { 
        return [
            ID::make('ID')->sortable(),

            Text::make(__('Title'), 'label')
                ->required()
                ->rules('required'),

            Text::make(__('Name'), 'name')
                ->nullable()
                ->rules('nullable', 'alpha-dash'),

            Text::make(__('Group'), function() {
                return $this->resource::groups()->get($this->resource->group()); 
            })->onlyOnIndex(),

            Flexible::make(__('Detail'), 'config')
                ->addLayout(__('Color'), 'color',  [
                    Color::make(__('Pick an color'), 'color')
                        ->rules('required')
                        ->required(), 
                ])
                ->addLayout(__('SVG'), 'svg', [
                    Code::make(__('Write SVG code here'), 'svg')
                        ->language('javascript')
                        ->rules('required')
                        ->required(), 
                ])
                ->addLayout(__('Class'), 'class', [
                    Code::make(__('Write CSS here'), 'css')
                        ->language('css')
                        ->rules('required')
                        ->required(),
                ])
                ->addLayout(__('Google Font'), 'google_font', [
                    Select::make(__('Group'), 'group')
                        ->options([
                            'serif'       => 'Serif',
                            'sans-serif'  => 'Sans Serif',
                            'display'     => 'Display',
                            'handwriting' => 'Handwriting',
                            'monospace'   => 'Monospace',
                            'sorting'     => 'Sorting',
                        ])
                        ->required()
                        ->rules('required')
                        ->default('serif'),

                    Text::make(__('Font Name'), 'font') 
                        ->rules('required')
                        ->required(),
                ]) 
                ->addLayout(Layouts\FontLayout::class)
                ->addLayout(Layouts\ImageLayout::class)
                ->addLayout(Layouts\SliderLayout::class)
                ->addLayout(Layouts\PatternLayout::class) 
                ->button(__('Add Detail'))
                ->rules('required')
                ->required()
                ->limit(), 
        ];
    } 
}
