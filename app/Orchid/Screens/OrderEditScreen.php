<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Order;
use App\Models\Client;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;

class OrderEditScreen extends Screen
{

    public $order;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Order $order): array
    {
        return [
            'order' => $order
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'OrderEditScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Save')
                ->icon('check')
                ->method('save'),
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
            Layout::rows([
                Select::make('order.client_id')
                    ->title('Client')
                    ->fromModel(Client::class, 'name')
                    ->required(),

                Input::make('order.status')
                    ->title('Status')
                    ->placeholder('Enter order status')
                    ->required(),

                Input::make('order.total')
                    ->title('Total')
                    ->placeholder('Enter order total')
                    ->required(),
            ])
        ];
    }
    public function save()
    {
        if (intval(request() -> route('order_id'))) {
            Order::findOrFail(request() -> route('order_id')) -> update(request() -> input('order'));
        } else {
            Order::create(request() -> input('order'));
        }

        Toast::success('Заказ успешно сохранен');
        return redirect()
            -> route('platform.order.list');
    }
}
