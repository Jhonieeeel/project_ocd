<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="inline-block min-w-full p-1.5 align-middle">
            <h3 class="text-md pb-4 pt-2 font-semibold">Stock List</h3>
            <div class="divide-y divide-gray-200 rounded-lg border border-gray-200">
                {{-- search bar --}}
                <div class="px-4 py-3 sm:flex sm:items-center sm:justify-between">
                    <div class="relative max-w-xs">
                        <label for="hs-table-search" class="sr-only">Search</label>
                        <input type="text" wire:model.live.debounce.300ms="stockSearch" name="hs-table-search" id="hs-table-search"
                            class="shadow-2xs block w-full rounded-lg border-gray-400 px-3 py-1.5 ps-9 focus:z-10 focus:border-orange-500 focus:ring-orange-500 disabled:pointer-events-none disabled:opacity-50 sm:py-2 sm:text-sm"
                            placeholder="Search item description">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="{{ route('my-request-list') }}"
                        class="relative hidden p-2 transition-all duration-300 hover:text-orange-500 sm:flex sm:items-center sm:gap-x-2">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-archive-icon lucide-archive">
                            <rect width="20" height="5" x="2" y="3" rx="1" />
                            <path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8" />
                            <path d="M10 12h4" />
                        </svg>

                        <!-- Label Text -->
                        <span class="hidden text-sm sm:block">My Requests</span>

                        <!-- Notification Circle -->
                        <span
                            class="absolute left-5 top-0 inline-flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-semibold text-white">
                            {{ $requests }}
                        </span>
                    </a>

                </div>
                {{-- table --}}
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-orange-500">
                            <tr>
                                {{-- <th scope="col" class="px-4 py-3 pe-0">
                                    <div class="flex h-5 items-center">
                                        <input id="hs-table-search-checkbox-all" type="checkbox"
                                            class="rounded-sm border-gray-200 text-blue-600 focus:ring-blue-500">
                                        <label for="hs-table-search-checkbox-all" class="sr-only">Checkbox</label>
                                    </div>
                                </th> --}}
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Stock Barcode</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Item Description</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Stock Quantity</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Stock Price</th>
                                <th scope="col" colspan="2"
                                    class="px-6 py-3 text-end text-xs font-medium uppercase text-gray-50">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->stocks as $stock)
                            <tr class="w-full">
                                {{-- <td class="py-3 ps-4">
                                    <div class="flex h-5 items-center">
                                        <input id="hs-table-search-checkbox-1" type="checkbox"
                                            class="rounded-sm border-gray-200 text-blue-600 focus:ring-blue-500">
                                        <label for="hs-table-search-checkbox-1" class="sr-only">Checkbox</label>
                                    </div>
                                </td> --}}
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-xs font-medium capitalize text-gray-800">
                                    {{ $stock->barcode }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-xs capitalize text-gray-800">
                                    {{ $stock->supply->item_description }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-xs text-gray-800">
                                    {{ $stock->item_quantity }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-xs text-gray-800">
                                    ₱{{ number_format($stock->item_price, 2) }}
                                </td>
                                <td
                                    class="items-center whitespace-nowrap px-6 py-4 text-end text-xs font-medium sm:flex sm:justify-end sm:gap-x-2 xl:gap-x-3">
                                    <button wire:click="addRequest({{ $stock->id }})"
                                        class="text-green-600 hover:text-green-800">
                                        Request

                                    </button>
                                    @if (auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                    <button wire:click="selectEditStock({{ $stock }})"
                                        class="text-orange-600 text-xs hover:text-orange-800">
                                        Edit
                                    </button>

                                    <button type="button"
                                        class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-xs font-semibold text-red-600 hover:text-red-800 focus:text-red-800 disabled:pointer-events-none disabled:opacity-50">Delete</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-3 text-center text-sm text-gray-500">No stocks added
                                    yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- pagination --}}

            </div>
            <div class="text-gray-700 xl:mt-6">
                {{ $this->stocks->links() }}
            </div>
        </div>
    </div>

    {{-- add request modal --}}
    <div x-cloak x-data="{ show: false }" x-transition x-show="show" x-on:open-modal.window="show = true;"
        x-on:close-modal.window="show = false" class="fixed inset-0 z-50">
        <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

        <!-- Modal Content -->
        <div
            class="fixed left-1/2 top-10 w-full max-w-lg -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:px-9 sm:py-6">
            <h4 class="text-xl font-semibold">Add Request</h4>
            {{-- forms --}}
            <form wire:submit="saveRequest" class="mt-4 space-y-2">
                <input type="hidden" wire:model="withdrawForm.stock_id" />
                <input type="hidden" wire:model="withdrawForm.user_id" />
                <div class="sm:flex sm:items-center sm:justify-start sm:gap-6">
                    <div>
                        <small class="text-xs text-gray-400">Item Description</small>
                        <p class="text-lg capitalize text-gray-800">
                            {{ $selectedStock?->supply->item_description ?? '' }}
                        </p>
                    </div>
                    <div>
                        <small class="text-xs text-gray-400">Quantity</small>
                        <p class="text-lg capitalize text-gray-800">{{ $selectedStock?->item_quantity ?? '' }}</p>
                    </div>
                    <div>
                        <small class="text-xs text-gray-400">Price</small>
                        <p class="text-lg capitalize text-gray-800">
                            {{ $selectedStock?->item_price ?? '' }}
                        </p>
                    </div>
                </div>
                <div class="sm:pb-2">
                    <small for="witdrawForm.requested_quantity" class="block pb-2 text-xs text-gray-400">Request
                        Quantity</small>
                    <input type="number" wire:model="withdrawForm.requested_quantity" placeholder="0" min=0
                        max={{ $selectedStock?->item_quantity ?? '' }} id="requested_quantity"
                        class="sm:w-54 rounded border-gray-400 focus:border-orange-500 focus:ring-orange-500 sm:h-10">
                    <x-input-error :messages="$errors->get('witdrawForm.requested_quantity')" class="mt-2" />
                    @error('witdrawForm.requested_quantity')
                    <span class="block text-sm text-red-500 sm:mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <hr>
                <div class="justify-end sm:flex sm:items-center sm:gap-x-3">
                    <button x-on:click="$dispatch('close-modal')"
                        class="text-sm px-4 py-2 text-red-600 rounded hover:text-gray-200 hover:bg-red-500 border border-red-600 hover:font-medium ">Cancel</button>
                    <button class="text-sm px-4 py-2 rounded bg-green-600 hover:bg-green-800 text-white hover:font-medium ">Request</button>
                </div>
            </form>
        </div>
    </div>

    {{-- edit modal --}}
    <div x-cloak x-data="{ show: false }" x-transition x-show="show" x-on:open-edit-modal.window="show = true;"
        x-on:close-edit-modal.window="show = false" class="fixed inset-0 z-50">
        <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

        <!-- Modal Content -->
        <div
            class="fixed left-1/2 top-10 w-full max-w-md -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:px-5 sm:py-9 xl:max-w-lg">
            <div class="sm:flex items-center gap-x-3">
                <h4 class="text-xl font-semibold">Edit Stock</h4>
                @if(session('edited'))
                <p class="text-sm text-green-600">{{ session('edited') }}</p>
                @endif
            </div>

            {{-- forms --}}
            <form wire:submit.prevent="editStock" class="mt-4 space-y-2">
                <input type="hidden" wire:model="stockForm.supply_id" />
                @error('stockForm.supply_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- inputs --}}
                <div>
                    <x-input-label for="barcode" :value="__('Barcode')" />
                    <x-text-input id="barcode" type="text" wire:model="stockForm.barcode" autocomplete="off"
                        class="w-full text-orange-600" required autofocus />
                    @error('stockForm.barcode')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:flex sm:items-center sm:gap-x-2">
                    <div>
                        <x-input-label for="item_quantity" :value="__('Item Quantity')" />
                        <x-text-input id="item_quantity" type="number" wire:model="stockForm.item_quantity"
                            class="w-full text-orange-600" required autofocus />
                        @error('stockForm.item_quantity')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-input-label for="item_price" :value="__('Item Price')" />
                        <x-text-input step="0.01" id="item_price" type="number"
                            wire:model="stockForm.item_price" class="w-full text-orange-600" required autofocus />
                        @error('stockForm.item_price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <x-input-label for="expiration" :value="__('Expiration')" />
                    <x-text-input id="expiration" type="text" autocomplete="off"
                        wire:model="stockForm.expiration" class="w-full text-orange-600" required autofocus />
                    @error('stockForm.expiration')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <x-text-input id="remarks" type="text" autocomplete="off" wire:model="stockForm.remarks"
                        class="w-full text-orange-600" required autofocus />
                    @error('stockForm.remarks')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:flex sm:items-center sm:justify-end sm:gap-x-3">
                    <button @click="$dispatch('close-edit-modal')"
                        class="mt-4 px-4 py-2 border border-red-600 rounded hover:bg-red-600 text-red-600 hover:text-white text-sm transition-all duration-300 hover:font-medium">
                        Close
                    </button>
                    <button type="submit" class="mt-4  px-4 py-2 rounded text-sm transition-all duration-300 bg-green-600 hover:bg-green-800 text-white hover:font-medium">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>