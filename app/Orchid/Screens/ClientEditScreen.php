<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Client;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\Request;

class ClientEditScreen extends Screen
{

    public $client;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Client $client): iterable
    {
        return [
            'client' => $client
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->client->exists ? 'Edit client' : 'Creating a new client';
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
                ->canSee(!$this->client->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->client->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->client->exists),
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
            Layout::rows([
                Input::make('client.name')
                    ->title('Name')
                    ->placeholder('Enter client name'),

                Input::make('client.email')
                    ->title('Email')
                    ->placeholder('Enter client email'),

                Input::make('client.phone')
                    ->title('Phone')
                    ->placeholder('Enter client phone'),

                Input::make('client.notes')
                    ->title('Notes')
                    ->placeholder('Enter additional notes'),
            ]),
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $request->validate([
            'client.name' => 'required|string|max:255',
            'client.email' => 'required|email|max:255|unique:clients,email,' . $this->client->id,
            'client.phone' => 'required|string|max:20|unique:clients,phone,' . $this->client->id,
        ]);

        try {
            $this->client->fill($request->get('client'))->save();
            Alert::info('You have successfully created or updated the client.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['client.email' => 'The email has already been taken.']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['client.phone' => 'The phone has already been taken.']);
        }

        return redirect()->route('platform.client.list');
    }

    public function remove()
    {
        $this->client->delete();

        Alert::info('You have successfully deleted the client.');

        return redirect()->route('platform.client.list');
    }

}
