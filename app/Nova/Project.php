<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\TextArea;
use Laravel\Nova\Fields\Code;
use Outl1ne\MultiselectField\Multiselect;
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
            Code::make('Description','description')->rules('required'),
            TextArea::make('Short Description','short_description')->rules('required'),
            MultiSelect::make('Technologies Used', 'technologies')->options([
                'HTML' => 'HTML',
                'Laravel' => 'Laravel',
                'Laravel Nova' => 'Laravel Nova',
                'JavaScript' => 'JavaScript',
                'AlpineJS' => 'AlpineJS',
                'ReactJS' => 'ReactJS',
                'Inertia' => 'Inertia',
                'PHP' => 'PHP',
                'JQuery' => 'JQuery',
                'AJAX' => 'AJAX',
                'Axios' => 'Axios',
                'Livewire' => 'Livewire',
                'Stripe' => 'Stripe',
                'LDAP Authentication' => 'LDAP Authentication',
                'CSS' => 'CSS',
                'TailwindCSS' => 'TailwindCSS',
            ])->rules('required'),
            URL::make('URL','url'),
        ];
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
