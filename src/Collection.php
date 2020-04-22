<?php 

namespace Armincms\TemplateDetail;

use Illuminate\Database\Eloquent\Collection as DatabaseCollection;


class Collection extends DatabaseCollection
{
    public function toFile(string $path)
    {  
    	ob_start();  
    	var_export($this->groupedDetails()->mapWithKeys(function($grouped, $group) {
    		$data = $grouped->map(function($model) use ($group) { 
	    		$transformer = "transform" . studly_case($group); 

	    		return $this->{$transformer}($model);
	    	})->keyBy('name')->toArray();


    		return [str_plural($group) => $data];
    	})->toArray());
  

    	\File::put($path, '<?php return ' .ob_get_clean(). ';'); 
    }

    public function groupedDetails()
    {
        return $this->groupBy(function($model) {
            return $model->group();
        });
    }

    public function transformColor($detail)
    {    
        return [
            'name'      => $detail->name,
            'title'     => $detail->label ?: $detail->name,
            'hex'       => $detail->details(),
            'code'      => $detail->details(),
            'colorName' => $detail->name,
            'rgb'       => null,
        ];
    }

    public function transformCustomFont($detail)
    { 
        return [
            'font-type' => 'internal',
            'name'      => $detail->name,
            'title'     => $detail->label ?: $detail->name,
            'fonts' => collect($detail->details())->map(function($relativeURL) {
                return url($relativeURL);
            })->all(),
        ];
    }

    public function transformGoogleFont($detail)
    {
        return [
            'font-type' => 'google', 
            'title'     => $detail->label ?: $detail->name,
            'category'  => data_get($detail->details(), 'group'),
            'name'  => data_get($detail->details(), 'font'),
        ]; 
    }

    public function transformSvg($svg)
    { 
    	return [
    		'name'  => $svg->name,
    		'title' => $svg->title,
    		'svg'   => $svg->details()
    	];
    }

    public function transformPattern($pattern)
    { 
    	return [
    		'name'  => $pattern->name,
    		'title' => $pattern->title,
    		'src'   => $pattern->details(),
    	];
    }

    public function transformImage($image)
    { 
    	return $this->transformPattern($image);
    }

    public function transformSlider($slider)
    {    
    	return [
    		'name'  => $slider->name,
    		'title' => $slider->title,
    		'images'=> $slider->details()->all(),
    	];
    }

    public function transformClass($class)
    { 
    	return [
    		'name' 	=> $class->name,
    		'title' => $class->title,
    		'css' 	=> $class->details(),
    	];
    } 
}