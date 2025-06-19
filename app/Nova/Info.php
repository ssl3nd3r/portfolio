<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;
use App\Nova\Traits\OnlyEditMode;

class Info extends Resource
{
    use OnlyEditMode;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Info>
     */
    public static $model = \App\Models\Info::class;

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
        'id',
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
            Text::make('Name','name')->rules('required'),
            Text::make('Position','position')->rules('required'),
            Code::make('Bio', 'bio')->rules('required'),
            URL::make('LinkedIn', 'linkedin')->rules('required'),
            URL::make('GitHub', 'github')->rules('required'),
            Email::make('Email', 'email')->rules('required'),
            File::make('Resume', 'resume')->creationRules('required'),
            Flexible::make('Main Competencies', 'competencies')
            ->addLayout('Skill', 'skill', [
                Text::make('Title')->rules('required'),
                Image::make('Logo')
                    ->disk('public')
                    ->preview(fn($value, $disk) => $value ? asset('storage/' . $value) : null)
                    ->thumbnail(fn($value, $disk) => $value ? asset('storage/' . $value) : null)
                    ->creationRules('required')
            ])->rules('required'),
        ];
    }

    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            Text::make('Title' , function(){
                return 'Personal Information';
            })
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

    public static function label() {
        return 'Info';
    }

    public static function singularLabel() {
        return 'Personal Information';
    }
}
