<div class="bg-white shadow overflow-hidden sm:rounded-lg bg-gray-100 mb-8" x-data="{ expand: false }">
    <div class="md:flex items-center justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
        <div class="flex flex-col">
            <h3 class="text-3xl leading-6 font-medium text-gray-900">
                @if($thickness == 0 && $system == 'None')
                    Reference - no insulation
                @else
                    {{ $thickness }} mm {{ $system }} <span
                        class="text-gray-500 font-thin text-xl">λ={{ $lambda }} W/(mK)</span>
                @endif
            </h3>
            <span class="mt-2 text-xs text-gray-500">
                This is an average of {{ $count }} simulations across {{ $stations }} weather stations.
        </span>
        </div>

        <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
            <button type="button" @click="expand = !expand" wire:click="toggleExpand"
                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4 font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-indigo-200 transition ease-in-out duration-150">
                View simulations
            </button>
        </p>
    </div>
    <div class="px-4 py-5 sm:px-6">
        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-3">
            @foreach ($types as $type => $label)
                <div class="sm:col-span-1">
                    <dt class="text-sm leading-5 font-medium text-gray-500 flex">
                        <span class="mr-2">{{ $label }}</span>
                        <x-help-text>
                            <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                                {{ $helps[$type]['header'] }}
                            </div>
                            {!! $helps[$type]['content'] !!}
                        </x-help-text>
                    </dt>
                    <dd class="mt-1 text-xl leading-5 flex flex-col">
                    <span style="color: {{ $color($type, $medians[$type]) }}; text-shadow: 1px 1px lightgray">
                        {{ $medians[$type] ?? 0 }}
                        @if (isset($reference[$type]))
                            <span class="text-gray-500 text-xs ml-1"
                                  style="text-shadow: none">ref. {{ $reference[$type] ?? 0 }}</span>
                        @endif
                    </span>
                        <small
                            class="mt-1 text-xs text-gray-500 font-light">{{ $mins[$type] ?? 0 }} &ndash; {{ $maxs[$type] ?? 0 }}</small>
                    </dd>
                </div>
            @endforeach
            <div class="hidden sm:col-span-2">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    About
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat.
                    Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia
                    proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.
                </dd>
            </div>
            <div class="hidden sm:col-span-2">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Attachments
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900">
                    <ul class="border border-gray-200 rounded-md">
                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm leading-5">
                            <div class="w-0 flex-1 flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-2 flex-1 w-0 truncate">
                  resume_back_end_developer.pdf
                </span>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="#"
                                   class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out">
                                    Download
                                </a>
                            </div>
                        </li>
                        <li class="border-t border-gray-200 pl-3 pr-4 py-3 flex items-center justify-between text-sm leading-5">
                            <div class="w-0 flex-1 flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-2 flex-1 w-0 truncate">
                  coverletter_back_end_developer.pdf
                </span>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="#"
                                   class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out">
                                    Download
                                </a>
                            </div>
                        </li>
                    </ul>
                </dd>
            </div>

            <div class="sm:col-span-3" x-show="expand" x-cloak>
                <div class="flex flex-col">
                    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div
                            class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200 max-h-128 overflow-scroll">
                            @if ($simulations == null)
                                Loading
                            @else
                                <table class="min-w-full">
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xxs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Weather Station
                                        </th>

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xxs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Wall width (mm)
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xxs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Wall Orien. (deg)
                                        </th>
                                        @foreach($types as $id => $label)
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xxs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                {{ $label }}
                                            </th>
                                        @endforeach

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xxs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            Rain-factor
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($simulations as $sim)
                                        <tr class="bg-white font-thin {{ $loop->last ? '' : 'border-b border-gray-200' }}">
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                                {{ $sim->city }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                                {{ $sim->wall_width }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                                {{ $sim->orientation }}
                                            </td>

                                            @foreach($types as $id => $label)
                                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                                    {{ $sim->{$id} }}
                                                </td>
                                            @endforeach

                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                                {{ $sim->rain }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </dl>
    </div>
</div>
