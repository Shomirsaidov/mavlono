<div class="space-y-2">

    <div class="flex justify-center">
        <img src="/assets/brand/logo-horizontal.png" width="200" class="mb-4" alt="">
    </div>


    <div class="space-y-6 pb-5">


        <a href="/write" class="font-bold text-md">
            <div class="flex space-x-4 items-center hover:bg-gray-100 cursor-pointer rounded-lg p-3">
                <img src="/assets/add-square.svg" width="32" alt="">
                <div class="space-y-4 font-bold">
                    Иловаи шеър
                </div>
            </div>
        </a>


        <a href="/" class="font-bold text-md">
            <div class="flex space-x-4 items-center hover:bg-gray-100 cursor-pointer rounded-lg p-3">
                <img src="/assets/home-2.svg" width="32" alt="">
                <div class="space-y-4 font-bold">
                    Асосӣ
                </div>
            </div>
        </a>

        <a href="/home" class="font-bold text-md">
            <div class="flex space-x-4 items-center hover:bg-gray-100 cursor-pointer rounded-lg p-3">
                <img src="/assets/profile-circle.svg" width="32" alt="">
                <div class="space-y-4 font-bold">
                    Профил
                </div>
            </div>
        </a>


    </div>





    <div class="custom-scroll-container" style="overflow-y: scroll; height: 340px;">
    @foreach($poets as $poet)
        <a href="/poets/{{ $poet->name }}" class="font-bold text-md">
            <div class="flex space-x-4 items-center hover:bg-gray-100 cursor-pointer rounded-lg p-3">
                <div class="rounded-full bg-gray-600 cursor-pointer">
                        <img src="{{ $poet->avatar }}" alt="" style="width: 35px; height: 35px;" class="rounded-full">
                </div>
                <div class="space-y-4 font-bold">
                    {{ $poet->name }}
                </div>
            </div>
        </a>
    @endforeach
    </div>

    

</div>





<style>

/* width */
.custom-scroll-container::-webkit-scrollbar {
  width: 4px;
}

/* Track */
.custom-scroll-container::-webkit-scrollbar-track {
  background: #e2e2e2;
  border-radius: 120px;

}

/* Handle */
.custom-scroll-container::-webkit-scrollbar-thumb {
  background: #474787;
  border-radius: 120px;
}

/* Handle on hover */
.custom-scroll-container::-webkit-scrollbar-thumb:hover {
  background: rebeccapurplechrome;
}



/* .custom-scroll-container {
    scrollbar-width: thin;
    scrollbar-color: rgb(182, 141, 211) #f1f1f1;
}

.custom-scroll-container::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

.custom-scroll-container::-webkit-scrollbar-track {
    background: indigo;
    border-radius: 40px;
}

.custom-scroll-container::-webkit-scrollbar-thumb {
    background-color: indigo;
    border-radius: 50px;
    border: 3px solid indigo;
}

.custom-scroll-container::-webkit-scrollbar-thumb:hover {
    background-color: indigo;
} */


</style>