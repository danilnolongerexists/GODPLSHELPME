<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Order;
use App\Models\Client;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\Request;

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
        return $this->order->exists ? 'Edit order' : 'Creating a new order';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create product')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->order->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->order->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->order->exists),
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
    public function createOrUpdate(Request $request)
    {
        $this->order->fill($request->get('order'))->save();

        Alert::info('You have successfully created a order.');

        return redirect()->route('platform.order.list');
    }

    public function remove()
    {
        $this->order->delete();

        Alert::info('You have successfully deleted the order.');

        return redirect()->route('platform.order.list');
    }
}
