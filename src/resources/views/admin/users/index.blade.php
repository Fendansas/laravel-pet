<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список пользователей') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        @php
                                function sortLink($field, $label) {
                                    $isCurrent = request('sort') === $field;
                                    $direction = request('direction') === 'asc' ? 'desc' : 'asc';
                                    $icon = $isCurrent
                                        ? (request('direction') === 'asc' ? '↑' : '↓')
                                        : '';
                                    return '<a href="'.request()->fullUrlWithQuery(['sort' => $field, 'direction' => $direction]).'">'.$label.' '.$icon.'</a>';
                                }
                        @endphp
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Аватар</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">{!! sortLink('name', 'Имя') !!}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">{!! sortLink('email', 'Email') !!}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Роль</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">{!! sortLink('phone', 'Телефон') !!}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">{!! sortLink('last_login_at', 'Последний вход') !!}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">{!! sortLink('country', 'Страна') !!}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">{!! sortLink('city', 'Город') !!}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Язык</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Действия</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <form method="GET" action="{{ route('admin.users.index') }}">
                                <td><input type="text" name="id" value="{{ request('id') }}" class="w-20 border rounded p-1"></td>
                                <td></td>
                                <td><input type="text" name="name" value="{{ request('name') }}" class="w-full border rounded p-1"></td>
                                <td><input type="text" name="email" value="{{ request('email') }}" class="w-full border rounded p-1"></td>
                                <td></td>
                                <td><input type="text" name="phone" value="{{ request('phone') }}" class="w-full border rounded p-1"></td>
                                <td></td>
                                <td><input type="text" name="country" value="{{ request('country') }}" class="w-full border rounded p-1"></td>
                                <td><input type="text" name="city" value="{{ request('city') }}" class="w-full border rounded p-1"></td>
                                <td><input type="text" name="language" value="{{ request('language') }}" class="w-full border rounded p-1" ></td>
                                <td>
                                    <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded">🔍</button>
                                </td>
                            </form>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ $user->profile->avatarUrl }}" alt="avatar" class="w-10 h-10 rounded-full">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->role }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->last_login_at?->format('d.m.Y H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->profile->country ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->profile->city ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->profile->language ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <x-link-button href="{{ route('admin.users.show', $user->id) }}">show</x-link-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
