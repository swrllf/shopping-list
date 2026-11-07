<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ShoppingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // Пункт 2 и 5: Добавляем товар только в свой список
    public function store(Request $request, ShoppingList $shoppingList)
    {
        if ($shoppingList->user_id !== Auth::id()) {
            abort(404);
        }

        $data = $request->validate(['name' => 'required|string|max:255']);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'priority' => 'required|string|in:normal,desired,urgent', // Новая строка
        ]);
        $shoppingList->items()->create($data);

        return back();
    }

    // Отметить "куплено"
    public function toggle(Item $item)
    {
        // Проверка владельца через связь
        if ($item->shoppingList->user_id !== Auth::id()) {
            abort(404);
        }

        $item->update(['is_bought' => !$item->is_bought]);
        return back();
    }

    // Удалить
    public function destroy(Item $item)
    {
        if ($item->shoppingList->user_id !== Auth::id()) {
            abort(404);
        }
        $item->delete();
        return back();
    }
}