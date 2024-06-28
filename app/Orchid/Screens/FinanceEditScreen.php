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
        return 'FinanceEditScreen';
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

    public function save()
    {
        if (intval(request() -> route('finance_id'))) {
            Finance::findOrFail(request() -> route('finance_id')) -> update(request() -> input('finance'));
        } else {
            Finance::create(request() -> input('finance'));
        }

        Toast::success('Заказ успешно сохранен');
        return redirect()
            -> route('platform.finance.list');
    }
}
