<style>
    .bg-green-600{
        background-color: green;
    }
    .bg-green-600:hover{
        background-color: #2f4b03;
    }

</style>
<button {{ $attributes->merge([
    'type' => 'button',
    'class' =>
        'inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
