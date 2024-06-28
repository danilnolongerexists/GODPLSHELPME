<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Client;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Link;

class ClientListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'clients' => Client::all()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Клиенты';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create Client')
                ->icon('plus')
                ->route('platform.client.edit')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('clients', [
                TD::make('name', __('Name'))
                    ->sort()
                    ->render(function (Client $client) {
                        return Link::make($client->name)
                            ->route('platform.client.edit', $client);
                    }),
                TD::make('email', 'Email')->sort(),
                TD::make('phone', 'Phone')->sort(),
                TD::make('notes', 'Notes')->sort(),
            ]),
        ];
    }
}
