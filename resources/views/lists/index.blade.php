<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Мои списки</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Создать список -->
                <form method="POST" action="{{ route('lists.store') }}" class="mb-6 flex gap-2">
                    @csrf
                    <input type="text" name="title" placeholder="Название списка..."
                        class="border-gray-300 rounded-md shadow-sm w-full" required>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Создать</button>
                </form>

                <ul>
                    @forelse($myLists as $list)
                        <li class="mb-2 p-3 border rounded flex justify-between items-center bg-white shadow-sm">
                            <div>
                                <a href="{{ route('lists.show', $list) }}"
                                    class="text-blue-600 font-bold text-lg hover:underline">
                                    {{ $list->title }}
                                </a>
                                <div class="text-xs text-gray-500 mt-1">
                                    Ссылка для друга: {{ route('lists.join', $list->share_token) }}
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <!-- Кнопка Удалить список -->
                                <form method="POST" action="{{ route('lists.destroy', $list) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-500">У вас пока нет списков. Создайте первый!</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>