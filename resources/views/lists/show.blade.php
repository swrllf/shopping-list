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
                    
                    <!-- Выбор категории товара -->
                    <select name="category" class="border-gray-300 rounded-md shadow-sm h-10">
                        <option value="Общее">Общее</option>
                        <option value="Молочные продукты">Молочные продукты</option>
                        <option value="Овощи и фрукты">Овощи и фрукты</option>
                        <option value="Мясо и рыба">Мясо и рыба</option>
                        <option value="Хлеб и выпечка">Хлеб и выпечка</option>
                        <option value="Бытовая химия">Бытовая химия</option>
                    </select>

                    <!-- Выбор приоритета -->
                    <select name="priority" class="border-gray-300 rounded-md shadow-sm h-10">
                        <option value="normal">🟢 Не срочно</option>
                        <option value="desired">🟡 Желательно</option>
                        <option value="urgent">🔴 Срочно</option>
                    </select>

                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Добавить</button>
                </form>

                <!-- Список товаров, сгруппированных по категориям -->
                @php
                    $groupedItems = $shoppingList->items->groupBy('category');
                @endphp

                @forelse($groupedItems as $category => $items)
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-600 mb-2 border-b pb-1">
                            📁 {{ $category }}
                        </h3>
                        <ul>
                            @foreach($items as $item)
                                <li class="flex justify-between items-center mb-1 p-2 border-b hover:bg-gray-50">
                                    <form method="POST" action="{{ route('items.toggle', $item) }}" class="flex items-center gap-2">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xl">
                                            {{ $item->is_bought ? '✅' : '⬜' }}
                                        </button>
                                        
                                        <!-- Иконка приоритета -->
                                        <span class="text-lg">
                                            @if($item->priority === 'urgent')
                                                🔴
                                            @elseif($item->priority === 'desired')
                                                🟡
                                            @else
                                                🟢
                                            @endif
                                        </span>

                                        <span class="{{ $item->is_bought ? 'line-through text-gray-400' : 'text-gray-800' }}">
                                            {{ $item->name }}
                                        </span>
                                    </form>

                                    <form method="POST" action="{{ route('items.destroy', $item) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 text-sm hover:underline">Удалить</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <li class="text-gray-500">В этом списке пока нет товаров.</li>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>