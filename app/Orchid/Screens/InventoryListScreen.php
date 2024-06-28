<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Inventory;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Link;

class InventoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'inventories' => Inventory::all()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'InventoryListScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create Inventory')
                ->icon('plus')
                ->route('platform.inventory.edit')
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
            Layout::table('inventories', [
                TD::make('name', __('Name'))
                    ->sort()
                    ->render(function (Inventory $inventory) {
                        return Link::make($inventory->name)
                            ->route('platform.inventory.edit', $inventory);
                    }),
                TD::make('quantity', 'Quantity')->sort(),
                TD::make('price', 'Price')->sort(),
            ]),
        ];
    }
}
