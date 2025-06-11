<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\TextArea;
use Laravel\Nova\Fields\Code;
use Outl1ne\MultiselectField\Multiselect;
// use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class Project extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Project>
     */
    public static $model = \App\Models\Project::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title' , 'short_description'
    ];



    // public function __construct()
    // {
    //     // Now this is legal—calling database_path() inside a method.
    //     $this->getTechOptions() = database_path('tech_options.json');
    // }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            // ID::make()->sortable(),
            Text::make('Title','title')->rules('required'),
            Image::make('Logo','logo')->creationRules('required'),
            Image::make('Image','image')->creationRules('required'),
            Image::make('Background Image','image_1')->creationRules('required'),
            Code::make('Description','description')->rules('required'),
            TextArea::make('Short Description','short_description')->rules('required'),

            Multiselect::make('Technologies Used', 'technologies')
            // 1) Load existing options from JSON
            ->options($this->loadTechOptions())
            ->taggable()
            ->saveAsJSON()
            ->onlyOnForms()
            ->placeholder('Select or type to add a skill')
            ->fillUsing(function (NovaRequest $request, $model, $attribute, $requestAttribute) {
                // Nova will send an array of selected values (strings)
                $selected = $request->get($requestAttribute, []);

                // Load current JSON from disk
                $allOptions = json_decode(file_get_contents($this->gettechoptions()) ?: '[]', true) ?: [];

                // Detect any items in $selected that are NOT already in $allOptions
                $newTags = array_values(array_diff($selected, array_keys($allOptions)));

                if (! empty($newTags)) {
                    // For each new tag, append to the JSON file’s array
                    foreach ($newTags as $tag) {
                        // Use the tag itself as both key and label; adjust if you want a separate label
                        $allOptions[$tag] = $tag;
                    }
                    // Write back the combined array to disk with pretty-print
                    file_put_contents($this->gettechoptions(), json_encode($allOptions, JSON_PRETTY_PRINT));
                }

                // Finally, assign the full $selected array to the model attribute.
                // Because ->saveAsJSON() is set, Eloquent will serialize it to JSON
                $model->$attribute = $selected;
            }),
            URL::make('URL','url'),
        ];
    }

    // private $techOptionsPath;
    protected function getTechOptions(): string {
        return database_path('tech_options.json');
    }
    protected function loadTechOptions(): array
    {
        if (! file_exists(filename: $this->getTechOptions())) return [];

        $raw = file_get_contents($this->getTechOptions());
        $arr = json_decode($raw, true);
        return is_array($arr) ? $arr : [];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
 * Build an "index" query for the given resource.
 *
 * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
 * @param  \Illuminate\Database\Eloquent\Builder  $query
 * @return \Illuminate\Database\Eloquent\Builder
 */
public static $indexDefaultOrder = [
    'created_at' => 'desc'
];    

public static function indexQuery(NovaRequest $request, $query)
{
    if (empty($request->get('orderBy'))) {
        $query->getQuery()->orders = [];
        return $query->orderBy(key(static::$indexDefaultOrder), reset(static::$indexDefaultOrder));
    }
    return $query;
}

}
