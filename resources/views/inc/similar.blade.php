@if(count($similars) > 0) 
<ul class="space-y-4">
    <h1 class="text-xl font-bold my-4">Монанди ин </h1>
    @foreach ($similars as $poem)
        <li class="p-4 bg-gray-50 border border-gray-200 rounded-md shadow-sm">
            <div class="flex space-x-4 items-center mb-4">
                <div class="rounded-full bg-gray-600 cursor-pointer">
                    <a href="/{{ $poem->poet->name }}">
                        <img src="{{ $poem->poet->avatar }}" alt="" style="width: 35px; height: 35px;" class="rounded-full">
                    </a>
                </div>
                <div class="space-y-4">
                    <a href="/poets/{{ $poem->poet->name }}" class="font-bold text-lg">{{ $poem->poet->name }}</a> 
                </div>
            </div>
            <p class="text-gray-700 whitespace-pre-line">{!! Str::limit($poem->content, 150) !!}</p>
            <a href="{{ route('poems.show', $poem->id) }}" class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                {{ __('Муфассал') }}
            </a>

            <div class="my-8 flex space-x-3 items-center">
                <div class="likes">
                    @if(Auth::check() && $poem->likes->contains('user_id', Auth::user()->id)) 
                        <img src="/assets/heart-fill.svg" alt="Liked" class="liked">
                    @else
                        <img src="/assets/heart-disabled.svg" alt="Not Liked">
                    @endif
                </div>
                <div class="like_amount ms-2">{{ count($poem->likes) }}</div>
            </div>
        </li>
    @endforeach
</ul>
@endif

@if(count($thispoet) > 0)
<ul class="space-y-4">
    <h1 class="text-xl font-bold my-4">Аз ин муаллиф </h1>
    @foreach ($thispoet as $poem)
        <a href="{{ '/poems/'.$poem->id }}" class="font-bold text-md">
                <div class="mb-2 flex justify-between items-center space-x-4 bg-gray-50 border-b-4 border-l-4 cursor-pointer rounded-lg p-3">
                    
                    <div class="space-y-4 font-bold">
                        @if ($poem)
                            {{ explode('<br>', $poem->content)[0] ?? 'No content available' }}
                        @else
                            No content available
                        @endif
                    </div>

                    <div class="flex items-center space-x-3">
                        <img src="/assets/heart-fill.svg" alt="">
                        <div>
                            {{ $poem ? count($poem->likes) : 0 }}
                        </div>
                    </div>
                </div>
            </a>    
    @endforeach
</ul>



@endif