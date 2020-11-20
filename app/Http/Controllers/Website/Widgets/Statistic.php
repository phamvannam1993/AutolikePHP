<?php

namespace App\Http\Controllers\Website\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Statistic extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'user' => null
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return view('website.widgets.statistic', [
            'user' => $this->config['user'],
        ]);
    }
}
