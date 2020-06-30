<div x-data="{ show: false }" {{ $attributes }} x-cloak>
    <span @mouseenter="
        var x = $event.clientX;
        var y = $event.clientY;
        var newposX = x + 20;
        var newposY = y + 20;
        $refs.help.style.transform = `translate3d(${newposX}px,${newposY}px,0px)`;
        show = true;
    " @mouseleave="show = false"
          class="cursor-pointer inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium leading-4 bg-indigo-100 text-indigo-800">
      ?
    </span>

    <div class="fixed top-0 left-0 bg-white rounded-lg overflow-hidden border border-gray-400 p-4 z-50 mt-2"
         x-show="show" x-ref="help">
        <div class="md:flex">
            <div class="md:flex-shrink-0 hidden">
                <img class="rounded-lg md:w-56" src="">
            </div>
            <div class=" md:mt-0 md:ml-6 w-64 text-gray-600 font-light text-sm">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
