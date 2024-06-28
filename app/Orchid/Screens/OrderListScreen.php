<?php

namespace App\Orchid\Screens;

use App\Models\Order;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Link;

class OrderListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'orders' => Order::with('client')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'OrderListScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create Order')
                ->icon('plus')
                ->route('platform.order.edit')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::table('orders', [
                TD::make('id', 'ID')->sort(),
                TD::make('client.name', 'Client')->sort(),
                TD::make('status', 'Status')->sort(),
                TD::make('total', 'Total')->sort(),
                TD::make('created_at', 'Created At')->sort(),
                TD::make('updated_at', 'Updated At')->sort(),
                TD::make('Actions')
                -> render(function (Order $order) {
                    return Link::make('Редактировать')
                        ->route('platform.order.edit', [
                            'order_id' => $order->id,
                        ]);
                }),
            ]),
        ];
    }
}
