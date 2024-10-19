<form class="bg-white py-2 flex flex-col justify-center items-center space-y-2 sticky top-0" action="/search" method="GET">
    <div class="w-full lg:w-3/4 flex shadow-md border-2 bg-white border-indigo-700 rounded-full">
        <input name="query" value="{{ request('query') }}" class="p-2 px-4 w-full rounded-s-full outline-none  font-bold" type="text" placeholder="порча аз шеър, муаллиф, мавзуъ">
        <div class="flex justify-center items-center p-2  rounded-full bg-indigo-700">
            <button type="submit">
                <img src="/assets/search-normal-1.svg" width="29" alt="">
            </button>
        </div>
    </div>


    @if(!request()->routeIs('search'))
        <div class="flex md:justify-center space-x-2 overflow-x-auto w-full">
            @foreach($tags as $tag) 
                <button class="p-2 bg-gray-100 text-gray-800 rounded-full">
                    <a href="/search?query={{ $tag->tag }}">{{ $tag->tag }}</a>
                </button>
            @endforeach
        </div>
    @endif


</form>


<div></div>