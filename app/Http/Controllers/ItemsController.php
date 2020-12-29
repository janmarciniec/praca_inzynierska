<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Mail\DeleteItemMail;
use App\Mail\TransferItemMail;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;

class ItemsController extends Controller
{
    public function create()
    {
        $this->authorize('create', Item::class);

        $categories = Category::all();

        $location = auth()->user()->address->city;

        return view('items.create', compact('categories', 'location'));
    }

    public function store()
    {
        $data = request()->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:255'],
            'location' => ['max:255'],
            'category_id' => '',
            'image' => ['required', 'image'],
        ]);

        //zapisze w storage/app/public/uploads
        $imagePath = request('image')->store('uploads','public');

        //zapisze miniaturkę w storage/app/public/uploads/thumbnails
        $thumbnailPath = request('image')->store('uploads/thumbnails','public');
        //$thumbnail = Image::make(public_path("storage/{$thumbnailPath}"))->fit(216, 156);
       // $thumbnail->save();

        //\App\Item::create($data); - nie doda user_id
        auth()->user()->items()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'location' => $data['location'],
            'category_id' => $data['category_id'],
            'image' => substr($imagePath, 8),
        ]);

        $notification = array(
                    'message' => 'Ogłoszenie zostało opublikowane',
                    'alert-type' => 'success'
                );

        return redirect()->route('user.index')->with($notification);
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $this->authorize('update', $item);

        $categories = Category::all();

        return view('items.edit', compact('item', 'categories'));
    }

    public function transfer(Item $item)
    {
        $this->authorize('transfer', $item);

        $categories = Category::all();

        return view('items.transfer', compact('item', 'categories'));
    }

    public function update(Item $item)
    {
        //administrator może tylko edytować kategorię
        if(auth()->user()->username != 'admin')
        {
            $data = request()->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'min:10', 'max:2000'],
                'location' => ['max:100'],
                'category_id' => '',
                'image' => '',
            ]);

            //jeśli użytkownik wybrał nowe zdjęcie
            if(request('image'))
            {
                //zapisze w storage/app/public/uploads
                $imagePath = request('image')->store('uploads','public');

                //zapisze miniaturkę w storage/app/public/uploads/thumbnails
                $thumbnailPath = request('image')->store('uploads/thumbnails','public');
                $thumbnail = Image::make(public_path("storage/{$thumbnailPath}"))->fit(216, 156);
                $thumbnail->save();

                $imageArray = ['image' => substr($imagePath, 8)];
            }

            $item->update(array_merge(
                        $data,
                        $imageArray ?? []
                    ));

            $notification = array(
                    'message' => 'Ogłoszenie zostało zaktualizowane',
                    'alert-type' => 'success'
                );
        }
        else
        {
            $data = request()->validate([
                'category_id' => '',
            ]);

            $item->update($data);

            //wysłanie maila do użytkownika, jeśli administrator przeniósł ogłoszenie do innej kategorii
            Mail::to($item->user->email)->send(new TransferItemMail($item));
            $notification = array(
                    'message' => 'Ogłoszenie zostało przeniesione',
                    'alert-type' => 'success'
                );
        }

        return redirect()->route('item.show', $item)->with($notification);
    }

    public function buy(Item $item)
    {
        $this->authorize('buy', $item);

        //user_id doda się automatycznie
        auth()->user()->transactions()->create([
            'item_id' => $item->id,
        ]);

        return view('items.buy', compact('item'));
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        //jeśli admin usunął ogłoszenie, zostanie wysłany mail do użytkownika, który je dodał
        if(auth()->user()->username == 'admin')
        {
            Mail::to($item->user->email)->send(new DeleteItemMail($item));
        }

        return redirect()->route('user.index');
    }

    public function restore(Item $item)
    {
        $this->authorize('restore', $item);

        //zabranie tokena sprzedawcy
        $seller = $item->user;
        $seller->tokens-=1;
        $seller->save();

        //zwrócenie tokena kupującemu
        if($item->transaction->user != null) {
            $buyer = $item->transaction->user;
            $buyer->tokens += 1;
            $buyer->save();
        }
        $item->transaction->delete();
        $item->availability = 1;
        $item->save();

        $notification = array(
                    'message' => 'Ogłoszenie zostało przywrócone do sprzedaży',
                    'alert-type' => 'success'
                );

        return redirect()->route('user.index')->with($notification);
    }
}
