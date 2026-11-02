<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Список: {{ $shoppingList->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Добавить товар -->
                <form method="POST" action="{{ route('items.store', $shoppingList) }}" class="mb-6 flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Что купить?" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Добавить</button>
                </form>

                <!-- Список товаров -->
                <ul>
                    @foreach($shoppingList->items as $item)
                        <li class="flex justify-between items-center mb-2 p-2 border-b">
                            <form method="POST" action="{{ route('items.toggle', $item) }}" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-xl">
                                    {{ $item->is_bought ? '✅' : '⬜' }}
                                </button>
                                <span class="{{ $item->is_bought ? 'line-through text-gray-400' : '' }}">
                                    {{ $item->name }}
                                </span>
                            </form>

                            <form method="POST" action="{{ route('items.destroy', $item) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500">Удалить</button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6">
                    <a href="{{ route('lists.index') }}" class="text-gray-500 underline">← Назад к спискам</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>