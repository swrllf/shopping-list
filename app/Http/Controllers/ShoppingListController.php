<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingListController extends Controller
{
    public function destroy(ShoppingList $shoppingList)
    {
        // Проверка владельца (чужой список удалить нельзя)
        if ($shoppingList->user_id !== Auth::id()) {
            abort(404);
        }
        $shoppingList->delete();
        return redirect()->route('lists.index');
    }
    // Пункт 2: Показываем только свои списки или те, куда пригласили
    public function index()
    {
        // Берем списки только текущего пользователя
        $myLists = \App\Models\ShoppingList::where('user_id', auth()->id())->get();

        return view('lists.index', compact('myLists'));
    }


    // Пункт 2 и 5: Проверка владельца при просмотре
        // Пункт 2 и 5: Проверка владельца при просмотре
    public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'color' => 'required|string|max:7',
        'category' => 'required|string|max:255',
    ]);
    
    // Владелец берется из сессии, а не из формы!
    Auth::user()->shoppingLists()->create($data);

    return redirect()->route('lists.index');
}

    // Приглашение по ссылке
    public function join($token)
    {
        $list = ShoppingList::where('share_token', $token)->firstOrFail();

        // В реальном приложении тут нужно писать в таблицу "участники".
        // Для простоты мы просто дадим доступ к просмотру (через сессию).
        session()->push('joined_lists', $list->id);

        return redirect()->route('lists.show', $list)->with('success', 'Вы присоединились к списку!');
    }

        // Страница для админа: видеть все списки
    public function adminIndex()
    {
        // Если это не админ - выдаем 403 (Доступ запрещен)
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        // Админ видит все списки всех пользователей
        $allLists = \App\Models\ShoppingList::with('user')->get();
        
        return view('lists.admin', compact('allLists'));
    }

    public function toggleAdminView()
{
    // ИСПОЛЬЗУЕМ isRealAdmin(), чтобы разрешить возврат из режима пользователя
    if (!Auth::user()->isRealAdmin()) {
        abort(403);
    }

    if (session()->has('view_as_user')) {
        session()->forget('view_as_user');
    } else {
        session()->put('view_as_user', true);
    }

    return back();
}
public function show(ShoppingList $shoppingList)
{
    // Если это не владелец И не админ - выдаем 404
    if ($shoppingList->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
        abort(404);
    }

    return view('lists.show', compact('shoppingList'));
}
}