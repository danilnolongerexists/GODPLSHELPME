<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Inventory;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

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
        return $this->inventory->exists ? 'Edit inventory' : 'Creating a new inventory';
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
                ->canSee(!$this->inventory->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->inventory->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->inventory->exists),
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
    public function createOrUpdate(Request $request)
    {
        $this->inventory->fill($request->get('inventory'))->save();

        Alert::info('You have successfully created a inventory.');

        return redirect()->route('platform.inventory.list');
    }

    public function remove()
    {
        $this->inventory->delete();

        Alert::info('You have successfully deleted the inventory.');

        return redirect()->route('platform.inventory.list');
    }
}
