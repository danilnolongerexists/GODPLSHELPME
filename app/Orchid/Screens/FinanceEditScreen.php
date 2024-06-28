<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Finance;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

class FinanceEditScreen extends Screen
{
    public $finance;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Finance $finance): array
    {
        return [
            'finance' => $finance
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->finance->exists ? 'Edit finance' : 'Creating a new finance';
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
                ->canSee(!$this->finance->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->finance->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->finance->exists),
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
                Input::make('finance.amount')
                    ->title('Amount')
                    ->placeholder('Enter finance amount')
                    ->required(),

                Input::make('finance.type')
                    ->title('Type')
                    ->placeholder('Enter finance type')
                    ->required(),

                Input::make('finance.description')
                    ->title('Description')
                    ->placeholder('Enter finance description'),
            ])
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->finance->fill($request->get('finance'))->save();

        Alert::info('You have successfully created a finance.');

        return redirect()->route('platform.finance.list');
    }

    public function remove()
    {
        $this->finance->delete();

        Alert::info('You have successfully deleted the finance.');

        return redirect()->route('platform.finance.list');
    }
}
