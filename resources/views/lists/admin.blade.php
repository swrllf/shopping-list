<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Все списки (Админ-панель)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2">Название списка</th>
                            <th class="p-2">Владелец</th>
                            <th class="p-2">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allLists as $list)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 font-bold" style="color: {{ $list->color }};">
                                    {{ $list->title }}
                                </td>
                                <td class="p-2">{{ $list->user->name }} ({{ $list->user->email }})</td>
                                <td class="p-2">
                                    <a href="{{ route('lists.show', $list) }}" class="text-blue-500 underline">
                                        Открыть
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>