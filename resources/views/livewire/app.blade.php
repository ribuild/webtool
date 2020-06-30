<div class="h-screen flex overflow-hidden bg-white">
    <!-- Off-canvas menu for mobile -->
    <div class="lg:hidden">
        <div class="fixed inset-0 flex z-40">
            <div class="fixed z-50 bg-gray-100 flex flex-col w-screen h-screen justify-center items-center p-10 md:p-48" x-data="{ show: true }" x-show="show">
                <h3 class="text-xl leading-6 font-thin text-gray-900">
                    <div class="flex-shrink-0 px-4">
                        <img src="/logo.png" class="w-24">
                    </div>
                    Insulation Calculation Tool
                    <small class="relative ml-0 text-xs text-red-400" style="
                        top: -5px;
                    ">beta</small>
                </h3>

                <p class="mt-10 font-thin">
                    The RIBuild Insulation Calculation Tool is not optimized for small screen devices,
                    we hope you’ll open the tool on a device with a larger screen.
                    We apologize for the inconvenience.
                </p>
            </div>
        </div>
    </div>

    <div class="hidden lg:flex fixed z-50 bg-gray-100 flex flex-col w-screen h-screen justify-center items-center p-64" x-data="{ show: true }" x-show="show">
        <h3 class="text-xl leading-6 font-thin text-gray-900">
            <div class="flex-shrink-0 px-4">
                <img src="/logo.png" class="w-24">
            </div>
            Insulation Calculation Tool
            <small class="relative ml-0 text-xs text-red-400" style="
                top: -5px;
            ">beta</small>
        </h3>

        <p class="mb-4">1) The present version of the RIBuild Insulation Calculation Tool is a beta version, not fully developed. It is based on numerous pre-calculated simulations of the hygrothermal conditions (temperature, relative humidity, etc.) in internally insulated solid walls made of brick masonry or natural stone, situated at different locations in the RIBuild countries (Belgium, Denmark, Germany, Italy, Latvia, Sweden and Switzerland). The simulations are based on the simulation tool DELPHIN and uses a probabilistic approach to represent the variation in e.g. material properties and outdoor climate, thereby indicating the risk of applying a certain solution.</p>

        <p class="mb-4">2) Based on User input (location, orientation, wall type and thickness) the Insulation Calculation Tool selects possible solutions among the precalculated ones. The table presents different output options and average values (in bold) for various parameters. Further, it gives minimum and maximum values (small font size). Average values, minimum and maximum are based on a number of simulations (indicated at right). 
At present, the Insulation Calculation Tool covers not all locations and orientations, wall designs, insulation systems, etc. Therefore, depending on the User input, it might happen, that no solutions are suggested. To get results you can broaden your search, e.g. by selecting the town instead of the specific address, by choosing a wider interval of orientation or wall thickness or by choosing another combination of internal and external plaster. Further, the Insulation Calculation Tool covers not all failure modes, as research within RIBuild concluded that not in all cases, models representing a specific failure mode (e.g. frost) were sufficiently reliable. This has to be taken into consideration when using the Insulation Calculation Tool. In its present state it cannot be used as a stand-alone tool when deciding what solution to choose when insulating a historic building internally.</p>

        <p class="mb-4">3) For any contractual and legal claims, RIBuild’s liability shall be limited to wrongful intent and gross negligence. No claim of liability will be accepted if the use of the Insulation Calculation Tool violates any third-party industrial property rights or copyrights or any use that causes damage to third parties, unless the rights of third parties are known, or unknown as a result of gross negligence or if they are fraudulently concealed. At the effective date hereof, RIBuild knows no such rights. RIBuild shall inform the User immediately if any conflicting third-party rights become known to RIBuild, and provide the User with any information necessary for the defense against such claims and support him insofar as no conflicting interests of RIBuild exist.</p>

        <p class="mb-12">4) RIBuild is an EU-funded 5½-year project ending on 30 June 2020. The project consortium ceases to exist as an entity after this date, and the members of the consortium, single or united, cannot be held liable for any claims after the completion of the project.</p>

        <p class="mb-3 font-thin">Yes, I have understood under which limitations the RIBuild insulation calculation tool can be used</p>
        <button @click="show = false" class="py-2 px-4 shadow leading-4 font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-indigo-200 transition ease-in-out duration-150">
        Continue
        </button>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-100 border-r border-gray-200 bg-gray-100">
            <div class="h-0 flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <nav class="flex-1 px-2 bg-gray-100">
                    {{--                <form>--}}

                    <span
                        class="group flex items-center px-2 py-2 leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                        <svg
                            class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                            fill="currentColor" fill="none" viewBox="0 0 20 20">
                            <polygon id="Rectangle-535" points="0 0 20 8 12 12 10 20"></polygon>
                        </svg>
                        Location
                        <x-help-text class="ml-2">
                            <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                                Location
                            </div>
                            Enter the address or city name where your building is located. The geographical location of your building address will be presented on the map below. 

                        </x-help-text>
                    </span>
                    <div class="mt-1 rounded-md shadow-sm mx-1">
                        <input id="address" placeholder="Enter building address"
                               class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                               wire:model.debounce.500ms="address"
                        />
                    </div>

                    <div class="mt-4 h-40 mx-2" id="map" wire:ignore>
                    </div>

                    @if ($minDistance)
                        <span class="flex items-center justify-center text-gray-400 text-sm">
                            Closest weather station {{ number_format($minDistance / 1000, 1) }} km
                        </span>
                    @endif


                    <span
                        class="mt-4 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                    <div class="flex w-full items-center justify-between">
                        <div class="flex">
                            <svg
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                                fill="currentColor" viewBox="0 0 300 300">
                                <g><line
                                        style="" x1="128" y1="0" x2="127.999" y2="256" fill="none"></line><line style=""
                                                                                                                x1="0"
                                                                                                                y1="128"
                                                                                                                x2="256"
                                                                                                                y2="128"
                                                                                                                fill="none"></line></g><g><circle
                                        style="" cx="129.5" cy="129.677" r="112.5" fill="none" stroke="currentColor"
                                        stroke-width="25"
                                        stroke-dasharray="90 30"></circle><circle cx="129" cy="128.485" r="38"></circle></g>
                            </svg>

                            Distance to Weather stations
                            <x-help-text class="ml-2">
                                <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                                    Distance to Weather stations
                                </div>
                                Move the slider to increase or decrease the ‘selection’ radius. The weather stations within the radius will be used. Weather data is used for the hygrothermal simulations.
                            </x-help-text>
                        </div>
                        <small class="text-xs text-gray-800">{{ $stations }}km</small>
                    </div>

                </span>

                    <div class="flex flex-col px-4 ml-4 my-3">
                        <div class="flex items-center mb-2">
                            <input
                                type="range"
                                x-ref="input"
                                step="10"
                                min="10"
                                max="500"
                                class="w-full"
                                wire:model="stations"
                            >
                        </div>
                    </div>


                    <span
                        class="mt-4 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                    <svg
                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                        fill="currentColor" viewBox="0 0 20 20">
                        <g id="Page-1" stroke="none" stroke-width="1" fill-rule="evenodd">
							<g id="icon-shape">
								<path
                                    d="M0,8.00585866 C0,6.89805351 0.897060126,6 2.00585866,6 L11.9941413,6 C13.1019465,6 14,6.89706013 14,8.00585866 L14,17.9941413 C14,19.1019465 13.1029399,20 11.9941413,20 L2.00585866,20 C0.898053512,20 0,19.1029399 0,17.9941413 L0,8.00585866 L0,8.00585866 Z M6,8 L2,8 L2,18 L12,18 L12,14 L15,14 L15,12 L18,12 L18,2 L8,2 L8,5 L6,5 L6,8 L12,8 L12,14 L17.9941413,14 C19.1029399,14 20,13.1019465 20,11.9941413 L20,2.00585866 C20,0.897060126 19.1019465,0 17.9941413,0 L8.00585866,0 C6.89706013,0 6,0.898053512 6,2.00585866 L6,8 Z"
                                    id="Combined-Shape"></path>
							</g>
						</g>
                    </svg>
                    Wall material
                    <x-help-text class="ml-2">
                        <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                            Wall material
                        </div>
                        Select whether material used for the building facades (external walls) is brick (masonry) or stone (sandstone, limestone, granite, etc.).
                    </x-help-text>
                </span>

                    <div class="flex flex-col px-4 ml-4 my-3">
                        <div class="flex items-center mb-2">
                            <input id="material_brick" value="brick" name="material" type="radio"
                                   class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                   wire:model="material"/>
                            <label for="material_brick" class="ml-3">
                                <span class="block text-sm leading-5 font-medium text-gray-700">Brick</span>
                            </label>
                        </div>
                        <div class="flex items-center mb-2">
                            <input id="material_stone" value="natural_stones" name="material" type="radio"
                                   class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                   wire:model="material"/>
                            <label for="material_stone" class="ml-3">
                                <span class="block text-sm leading-5 font-medium text-gray-700">Stone</span>
                            </label>
                        </div>
                    </div>


                    <span
                        class="mt-4 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                    <div class="flex w-full items-center justify-between">
                        <div class="flex">
                            <svg
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                                fill="currentColor" viewBox="0 0 20 20">
                                <g id="Page-1" stroke-width="1" fill-rule="evenodd">
                                    <g id="icon-shape">
                                        <path
                                            d="M0,0 L20,0 L20,5 L0,5 L0,0 Z M0,7 L20,7 L20,11 L0,11 L0,7 Z M0,13 L20,13 L20,16 L0,16 L0,13 Z M0,18 L20,18 L20,20 L0,20 L0,18 Z"
                                            id="Combined-Shape"></path>
                                    </g>
                                </g>
                            </svg>
                            Wall thickness
                            <x-help-text class="ml-2">
                                <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                                    Wall thickness
                                </div>
                                Thickness of the existing external wall ranging between 100 and 900 mm. You can use the slider to narrow the interval between minimum and maximum thickness to be considered. If the thickness of the wall is not well defined, a wide interval is recommended.
                            </x-help-text>
                        </div>
                        <small class="text-xs text-gray-800">{{ str_replace(',', ' - ', $thickness) }}</small>
                    </div>

                </span>

                    <div class="flex flex-col px-4 ml-4 my-3">
                        <x-double-range :step="10" :min="$wallThickness['min']" :max="$wallThickness['max']"
                                        :value="$thickness"
                                        :model="'thickness'"
                        >
                        </x-double-range>
                    </div>


                    <span
                        class="mt-4 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                    <div class="flex w-full items-center justify-between">
                        <div class="flex">
                            <svg
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                                fill="currentColor" viewBox="0 0 20 20">
                                <g id="Page-1" stroke-width="1" fill-rule="evenodd">
                                    <g id="icon-shape">
                                        <path
                                            d="M14.6568542,15.6568542 C13.209139,17.1045695 11.209139,18 9,18 C4.581722,18 1,14.418278 1,10 C1,5.581722 4.581722,2 9,2 C13.418278,2 17,5.581722 17,10 L15,10 C15,6.6862915 12.3137085,4 9,4 C5.6862915,4 3,6.6862915 3,10 C3,13.3137085 5.6862915,16 9,16 C10.6568542,16 12.1568542,15.3284271 13.2426407,14.2426407 L14.6568542,15.6568542 L14.6568542,15.6568542 Z M12,10 L20,10 L16,14 L12,10 L12,10 Z"
                                            id="Combined-Shape"></path>
                                    </g>
                                </g>
                            </svg>
                            Wall orientation
                            <x-help-text class="ml-2">
                                <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                                    Wall orientation
                                </div>
                                Geographical orientation (facing) of the external wall. North is 0 and south is 180 degrees. Use the slider to specify the orientation.
                            </x-help-text>
                        </div>
                            <small class="text-sm text-gray-800">{{ str_replace(',', ' - ', $orientation) }}</small>
                    </div>

                </span>

                    <div class="flex flex-col px-4 ml-4 my-3">
                        <x-double-range :step="10" :min="$wallOrientation['min']" :max="$wallOrientation['max']"
                                        :value="$orientation"
                                        :model="'orientation'"
                        >
                        </x-double-range>
                        <small class="text-xs text-gray-500 italic">North is 0, south is 180.</small>
                    </div>


                    <span
                        class="mt-4 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                        <svg
                            class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                            fill="currentColor" viewBox="0 0 20 20">
                            <g id="Page-1" stroke-width="1" fill-rule="evenodd">
                                <g id="icon-shape">
                                    <path
                                        d="M1,1 L3,1 L3,19 L1,19 L1,1 Z M5,1 L7,1 L7,3 L5,3 L5,1 Z M5,9 L7,9 L7,11 L5,11 L5,9 Z M5,17 L7,17 L7,19 L5,19 L5,17 Z M9,1 L11,1 L11,3 L9,3 L9,1 Z M9,5 L11,5 L11,7 L9,7 L9,5 Z M9,9 L11,9 L11,11 L9,11 L9,9 Z M9,13 L11,13 L11,15 L9,15 L9,13 Z M9,17 L11,17 L11,19 L9,19 L9,17 Z M13,1 L15,1 L15,3 L13,3 L13,1 Z M13,9 L15,9 L15,11 L13,11 L13,9 Z M13,17 L15,17 L15,19 L13,19 L13,17 Z M17,1 L19,1 L19,3 L17,3 L17,1 Z M17,5 L19,5 L19,7 L17,7 L17,5 Z M17,9 L19,9 L19,11 L17,11 L17,9 Z M17,13 L19,13 L19,15 L17,15 L17,13 Z M17,17 L19,17 L19,19 L17,19 L17,17 Z"
                                        id="Combined-Shape"></path>
                                </g>
                            </g>
                        </svg>
                        Plaster
                        <x-help-text class="ml-2">
                            <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                                Plaster
                            </div>
                            Indicate by ticking on/off whether the existing wall includes 10-20 mm protective or decorative layer (plaster or mortar) internally or externally. As default, the wall includes plaster both internally and externally.
                        </x-help-text>
                    </span>

                    <div class="flex flex-col px-4 ml-4 my-3">
                        @foreach(['internal', 'external'] as $label)
                            <div class="flex items-center mb-2">
                                <input id="plaster{{$label}}" value="1" name="{{$label}}" type="checkbox"
                                       class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                       wire:model="{{$label}}"/>
                                <label for="plaster{{$label}}" class="ml-3">
                                    <span
                                        class="block text-sm leading-5 font-medium text-gray-700">{{ ucfirst($label) }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <span
                        class="mt-4 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                    <svg
                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                        fill="currentColor" viewBox="0 0 20 20">
                        <g id="Page-1" stroke-width="1" fill-rule="evenodd">
							<g id="icon-shape">
								<path
                                    d="M6,6 L2.00585866,6 C0.897060126,6 0,6.89805351 0,8.00585866 L0,17.9941413 C0,19.1029399 0.898053512,20 2.00585866,20 L11.9941413,20 C13.1029399,20 14,19.1019465 14,17.9941413 L14,14 L15,14 L15,12 L18,12 L18,2 L8,2 L8,5 L6,5 L6,6 L11.9941413,6 C13.1019465,6 14,6.89706013 14,8.00585866 L14,14 L17.9941413,14 C19.1029399,14 20,13.1019465 20,11.9941413 L20,2.00585866 C20,0.897060126 19.1019465,0 17.9941413,0 L8.00585866,0 C6.89706013,0 6,0.898053512 6,2.00585866 L6,6 Z M6,8 L2,8 L2,18 L12,18 L12,14 L11.5029293,14 L12,14 L12,8 L6,8 L6,8.49707067 L6,8 Z M6,12 L4,12 L4,14 L6,14 L6,16 L8,16 L8,14 L10,14 L10,12 L8,12 L8,10 L6,10 L6,12 Z"
                                    id="Combined-Shape"></path>
							</g>
						</g>
                    </svg>
                    Insulation system
                    <x-help-text class="ml-2">
                        <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                            Insulation system
                        </div>
                        SSelect by ticking on/off the types of insulation system to be considered by the web tool when presenting solutions. As default all systems are included, including a reference wall with no insulation.
                    </x-help-text>
                </span>

                    <div class="flex flex-col px-4 ml-4 my-3">
                        @foreach($insulationSystems as $id => $label)
                            <div class="flex items-center mb-2">
                                <input id="insulation{{$id}}" value="{{$id}}" name="insulation" type="checkbox"
                                       class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                       wire:model.lazy="insulation"/>
                                <label for="insulation{{$id}}" class="ml-3">
                                    <span class="block text-sm leading-5 font-medium text-gray-700">{{ $label }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>


                    <span
                        class="mt-4 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                    <svg
                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                        fill="currentColor" viewBox="0 0 20 20">
                        <g id="Page-1" stroke-width="1" fill-rule="evenodd">
                            <g id="icon-shape">
                                <path
                                    d="M0,0 L20,0 L20,5 L0,5 L0,0 Z M0,7 L20,7 L20,11 L0,11 L0,7 Z M0,13 L20,13 L20,16 L0,16 L0,13 Z M0,18 L20,18 L20,20 L0,20 L0,18 Z"
                                    id="Combined-Shape"></path>
                            </g>
                        </g>
                    </svg>
                    Insulation thickness
                    <x-help-text class="ml-2">
                        <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                            Insulation system
                        </div>
                        Thickness of the insulation system. The slider can be used to limit the number of output by narrowing the thickness of the internal insulation system to be applied, within the range of 10 - 150 mm.
                    </x-help-text>
                </span>

                    <div class="flex flex-col px-4 ml-4 my-3">
                        <label class="text-sm text-gray-600 flex justify-between" for="insulationThickness">
                            <span>Thickness</span>
                            <small
                                class="text-sm text-gray-800">{{ str_replace(',', ' - ', $insulationThickness) }}</small>
                        </label>
                        <x-double-range :step="10" :min="10" :max="150"
                                        :value="$insulationThickness"
                                        :model="'insulationThickness'"
                        >
                        </x-double-range>
                    </div>


                    <span
                        class="mt-4 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                    <svg
                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150"
                        stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Priority
                    <x-help-text class="ml-2">
                        <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">
                            Priority
                        </div>
                        By moving the sliders, you can prioritize between the output parameters, which affect the order in which solutions are presented. “Low” (left position) and “high” (right position) represent the priority (importance) of a parameter, not the size. As default, all output parameters are given the same priority (medium).
                    </x-help-text>
                </span>

                    @foreach ($types as $id => $label)
                        <div class="flex flex-col px-4 ml-4 my-3">
                            <label class="text-sm text-gray-600 flex justify-between" for="range{{$id}}">
                                <span>{{ $label }}</span>
                                <small class="text-sm text-gray-800">
                                    {{ $$id > 66 ? 'High' : ($$id > 33 ? 'Medium' : 'Low') }}
                                </small>
                            </label>
                            <input id="range{{$id}}" type="range" step="1" min="0" max="100" wire:model="{{ $id }}">
                        </div>
                    @endforeach
                    {{--                </form>--}}

                </nav>
            </div>
        </div>
    </div>
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3">
            <button
                class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150"
                aria-label="Open sidebar">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        <main class="flex-1 relative z-0 overflow-y-auto pt-2 pb-6 focus:outline-none md:py-6" tabindex="0">
            <div class="max-w-7xl px-4 sm:px-6 md:px-8 mx-4" x-data="{ expand: true }">
                <div class="bg-white overflow-hidden sm:rounded-lg mb-8" x-show="expand">
                    <div class="md:flex items-center justify-between px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-xl leading-6 font-thin text-gray-900">
                            <div class="flex-shrink-0 px-4">
                                <img src="/logo.png" class="w-24">
                            </div>
                            Insulation Calculation Tool
                            <small class="relative ml-0 text-xs text-red-400" style="
                                top: -5px;
                            ">beta</small>
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                            <button type="button" @click="expand = false"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4 font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-indigo-200 transition ease-in-out duration-150">
                                Hide introduction
                            </button>
                        </p>
                    </div>
                    <div class="px-4 py-5 sm:px-6 text-gray-800">
                        <p>
                        The table presents different output options and mean values (in bold) for various parameters. Further it gives minimum and maximum values (small font size).  Average  values, minimum and maximum are based on a number of simulations (indicated at right) made to handle the variation in material properties and climate.
                        </p>
                        <p>
                        If no results are shown, based on your input (location, wall type etc.), the web tool at present does not contain any simulations with the chosen combination. To get results you can broaden your search, e.g. by selecting a town instead of a specific address, by choosing a wider interval of orientation or wall thickness or by choosing another combination of internal and external plaster
                        </p>
                    </div>
                </div>

                <h1 class="px-6 flex items-center text-2xl font-semibold text-gray-900 flex justify-between mb-4">
                    <small class="text-xs text-gray-400">({{$resultCount}} aggregations out of {{$totalCount}})</small>
                    <span class="text-xs text-gray-500 cursor-pointer bg-gray-100 px-2.5 py-1.5 rounded leading-4"
                          x-show="!expand" @click="expand = true" x-cloak>show introduction</span>
                </h1>
            </div>
            <div class="max-w-7xl px-4 sm:px-6 md:px-8 mx-4 relative min-h-screen mb-24">

                @if ($resultCount > 33)
                    <h2 class="flex flex-col items-center justify-center h-full text-2xl h-screen">
                        Please narrow your search further.
                        <small class="block">
                            Your search found <strong>{{ $resultCount }}</strong> results.
                            You need to narrow it to max <strong>33</strong>.
                        </small>
                    </h2>
                @elseif ($resultCount == 0)
                    <h2 class="flex flex-col items-center justify-center h-full text-2xl h-screen">
                        Please expand your search.
                        <small class="block">
                            Your search found <strong>no</strong> results.
                        </small>
                    </h2>
                @else
                    @foreach($results as $idx => $result)
                        @livewire('search-result', compact('result', 'reference'), key($result->_key . $stations .
                        !!$reference))
                    @endforeach
                @endif

                <div class="flex text-baseline flex-shrink-0 text-gray-500 absolute bottom-0 mt-24 -mb-24">
                    <img src="eu.png" class="w-16">
                    <p class="pl-1 leading-tight" style="font-size: 0.7rem;">
                        This project has received funding from the European Union’s<br>
                        Horizon 2020 research and innovation programme under<br>
                        grant agreement No 637268
                    </p>
                </div>

            </div>
        </main>
    </div>
</div>
