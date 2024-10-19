

@if(request()->path() !== 'ai')
<a href="/ai">
    <button class="rounded-full p-6 borde-2 bg-indigo-700 border-4 font-black text-lg text-white btn " style="position: fixed; bottom: 30px; right: 100px;">
        <img src="/assets/magicpen.svg" width="30" alt="">
    </button>
</a>
@endif

<style>

    .btn:hover {
        box-shadow: 1px 1px 10px indigo;
    }
</style>