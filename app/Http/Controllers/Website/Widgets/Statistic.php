<?php

namespace App\Http\Controllers\Website\Widgets;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Arrilot\Widgets\AbstractWidget;

class Statistic extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'number_user' => 0,
        'number_transaction' => 0,
        'number_service' => 0,
        'total_transaction_value' => 0
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $this->config['number_user'] = User::count();
        $this->config['number_transaction'] = Transaction::where('status', Transaction::STATUS_COMPLETED)->count();
        $this->config['number_service'] = Service::where('status', Service::STATUS_ACTIVE)->count();
        $this->config['total_transaction_value'] = Transaction::where('status', Transaction::STATUS_COMPLETED)->sum('value');
        return view('website.widgets.statistic', [
            'number_user' => $this->config['number_user'],
            'number_transaction' => $this->config['number_transaction'],
            'number_service' => $this->config['number_service'],
            'total_transaction_value' => $this->config['total_transaction_value']
        ]);
    }
}
