<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Inventory;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;

class InventoryEditScreen extends Screen
{
    public $inventory;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Inventory $inventory): array
    {
        return [
            'inventory' => $inventory
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'InventoryEditScreen';
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
                Input::make('inventory.name')
                    ->title('Name')
                    ->placeholder('Enter inventory name')
                    ->required(),

                Input::make('inventory.quantity')
                    ->title('Quantity')
                    ->placeholder('Enter inventory quantity')
                    ->required(),

                Input::make('inventory.price')
                    ->title('Price')
                    ->placeholder('Enter inventory price')
                    ->required(),
            ])
        ];
    }
    public function save()
    {
        if (intval(request() -> route('inventory_id'))) {
            Inventory::findOrFail(request() -> route('inventory_id')) -> update(request() -> input('inventory'));
        } else {
            Inventory::create(request() -> input('inventory'));
        }

        Toast::success('Клиент успешно сохранен');
        return redirect()
            -> route('platform.inventory.list');
    }
}
