<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Пополнение баланса') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ваш балданс: {{$balance}} </h3>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Введите сумму для пополнения</h3>

                <input type="number" id="amount"
                       placeholder="Сумма ($)"
                       class="w-full border-gray-300 rounded-md shadow-sm mb-3 focus:ring focus:ring-blue-200"/>

{{--                <button id="payButton"--}}
{{--                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">--}}
{{--                    Оплатить--}}
{{--                </button>--}}
                <x-success-button id="payButton" >
                    {{ __('Оплатить') }}
                </x-success-button>

                <div id="card-element" class="mt-4"></div>
                <div id="payment-message" class="mt-3 text-green-600"></div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const payButton = document.getElementById('payButton');
        let card;

        document.addEventListener('DOMContentLoaded', () => {
            const elements = stripe.elements();
            card = elements.create('card');
            card.mount('#card-element');
        });

        payButton.addEventListener('click', async () => {
            const amount = document.getElementById('amount').value;
            if (!amount || amount <= 0) {
                alert('Введите сумму для пополнения');
                return;
            }

            const res = await fetch('{{ url("/stripe/create-payment-intent") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ amount })
            });

            const data = await res.json();
            const clientSecret = data.clientSecret;

            const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: { card: card }
            });

            if (error) {
                alert(error.message);
            } else if (paymentIntent.status === 'succeeded') {
                document.getElementById('payment-message').innerText = '✅ Оплата успешна! Баланс будет обновлён.';
            }
        });
    </script>
</x-app-layout>
