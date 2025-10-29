<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('История платежей') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if($payments->isEmpty())
                    <p class="text-gray-500">Платежей пока нет.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Дата</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Сумма</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Валюта</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Статус</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($payments as $payment)
                            <tr>
                                <td class="px-4 py-2">{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                                <td class="px-4 py-2">${{ number_format($payment->amount, 2) }}</td>
                                <td class="px-4 py-2">{{ strtoupper($payment->currency) }}</td>
                                <td class="px-4 py-2">
                                    @if($payment->status === 'succeeded')
                                        <span class="text-green-600 font-semibold">Успешно</span>
                                    @else
                                        <span class="text-gray-500">{{ ucfirst($payment->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
