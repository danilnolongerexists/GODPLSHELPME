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
            'inventories' => Inventory::paginate()
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
                TD::make('id', 'ID')->sort(),
                TD::make('name', 'Name')->sort(),
                TD::make('quantity', 'Quantity')->sort(),
                TD::make('price', 'Price')->sort(),
                TD::make('created_at', 'Created At')->sort(),
                TD::make('updated_at', 'Updated At')->sort(),
                TD::make('Actions')
                -> render(function (Inventory $inventory) {
                    return Link::make('Редактировать')
                        ->route('platform.inventory.edit', [
                            'inventiry_id' => $inventory->id,
                        ]);
                }),
            ]),
        ];
    }
}
