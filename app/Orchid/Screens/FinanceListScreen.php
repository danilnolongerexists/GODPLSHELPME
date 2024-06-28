<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Finance;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Link;

class FinanceListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'finances' => Finance::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'FinanceListScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create Finance')
                ->icon('plus')
                ->route('platform.finance.edit')
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
            Layout::table('finances', [
                TD::make('id', 'ID')->sort(),
                TD::make('amount', 'Amount')->sort(),
                TD::make('type', 'Type')->sort(),
                TD::make('description', 'Description')->sort(),
                TD::make('created_at', 'Created At')->sort(),
                TD::make('updated_at', 'Updated At')->sort(),
                TD::make('Actions')
                -> render(function (Finance $finance) {
                    return Link::make('Редактировать')
                        ->route('platform.finance.edit', [
                            'finance_id' => $finance->id,
                        ]);
                }),
            ]),
        ];
    }
}
