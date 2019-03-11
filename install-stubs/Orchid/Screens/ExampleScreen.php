<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Orchid\Layouts\Examples\RowExample;
use App\Orchid\Layouts\Examples\TableExample;
use App\Orchid\Layouts\Examples\MetricsExample;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartPieExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use Orchid\Platform\Notifications\DashboardNotification;

class ExampleScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Example Screen';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Sample Screen Components';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'charts'  => [
                [
                    'name'   => 'Some Data',
                    'values' => [25, 40, 30, 35, 8, 52, 17],
                ],
                [
                    'name'   => 'Another Set',
                    'values' => [25, 50, -10, 15, 18, 32, 27],
                ],
                [
                    'name'   => 'Yet Another',
                    'values' => [15, 20, -3, -15, 58, 12, -17],
                ],
                [
                    'name'   => 'And Last',
                    'values' => [10, 33, -8, -3, 70, 20, -34],
                ],
            ],
            'table'   => [
                new Repository(['product_id' => 'prod-100', 'name' => 'Desk', 'price' => 10.24, 'created_at' => '01.01.2020']),
                new Repository(['product_id' => 'prod-200', 'name' => 'Chair', 'price' => 65.9, 'created_at' => '01.01.2020']),
                new Repository(['product_id' => 'prod-300', 'name' => 'Computer', 'price' => 754.2, 'created_at' => '01.01.2020']),
                new Repository(['product_id' => 'prod-400', 'name' => 'Pen', 'price' => 0.1, 'created_at' => '01.01.2020']),
                new Repository(['product_id' => 'prod-400', 'name' => 'Brush', 'price' => 0.15, 'created_at' => '01.01.2020']),

            ],
            'metrics' => [
                ['keyValue' => number_format(6851, 0), 'keyDiff' => 10.08],
                ['keyValue' => number_format(24668, 0), 'keyDiff' => -30.76],
                ['keyValue' => number_format(65661, 2), 'keyDiff' => 3.84],
                ['keyValue' => number_format(10000, 0), 'keyDiff' => -169.54],
                ['keyValue' => number_format(1454887.12, 2), 'keyDiff' => 0.2],
            ],
            'place'   => [
                'lat' => 37.181244855427394,
                'lng' => -3.6021993309259415,
            ],
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [

            Link::name('Example Button')
                ->method('example')
                ->icon('icon-bag'),

            Link::name('Example Modals')
                ->modal('exampleModal')
                ->title('Example Modals')
                ->icon('icon-full-screen'),

            Link::name('Example Group Button')
                ->icon('icon-folder-alt')
                ->group([

                    Link::name('Example Button')
                        ->method('example')
                        ->icon('icon-bag'),

                    Link::name('Example Button')
                        ->method('example')
                        ->icon('icon-bag'),

                    Link::name('Example Button')
                        ->method('example')
                        ->icon('icon-bag'),

                    Link::name('Example Button')
                        ->method('example')
                        ->icon('icon-bag'),

                    Link::name('Example Button')
                        ->method('example')
                        ->icon('icon-bag'),
                ]),

        ];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function layout(): array
    {
        return [

            MetricsExample::class,
            ChartLineExample::class,

            Layouts::columns([
                ChartPieExample::class,
                ChartBarExample::class,
            ]),

            Layouts::tabs([
                'Example Tab Table' => TableExample::class,
                'Example Tab Rows'  => RowExample::class,
            ]),

            Layouts::modals([
                'exampleModal' => Layouts::rows([
                    Input::make('user.password')
                        ->type('test')
                        ->title(__('Example'))
                        ->placeholder(__('Example')),
                ]),
            ]),

        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function example()
    {
        Alert::warning('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel vulputate mi.');

        Auth::user()->notify(new DashboardNotification([
            'title'   => 'Hello Word',
            'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'action'  => 'http://orchid.software',
            'type'    => DashboardNotification::INFO,
        ]));

        return back();
    }
}
