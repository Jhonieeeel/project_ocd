<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="inline-block min-w-full p-1.5 align-middle">
            <div class="divide-y divide-gray-200 rounded-lg border border-gray-200">
                {{-- search bar --}}
                <div class="px-4 py-3 sm:flex sm:items-center sm:justify-between ">
                    <div class="relative max-w-md">
                        <div class="flex items-center gap-x-3">
                            <div>
                                <label for="hs-table-search" class="sr-only">Search</label>
                                <input type="text" name="hs-table-search" id="hs-table-search"
                                    class="shadow-2xs block w-full rounded-lg border-gray-400 px-3 py-1.5 ps-9 focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 sm:py-2 sm:text-sm"
                                    placeholder="Search for items">
                            </div>
                            <div class="sm:flex items-center gap-x-3">
                                <button x-data x-on:click='$dispatch("open-supply-form")' type="button"
                                    class="text-sm bg-green-500 px-3 py-2 hover:bg-green-600 transition-all duration-200 text-white rounded shadow-sm">
                                    Add Supply
                                </button>
                            </div>
                        </div>
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="hidden text-xs text-gray-400 sm:block">Some Filter Dropdown here</p>
                    </div>
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
                                    Item Description</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    category</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Unit</th>

                                <th scope="col" colspan="2"
                                    class="px-6 py-3 text-end text-xs font-medium uppercase text-gray-50">
                                    Action</th>

                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->supplies as $supply)
                                <tr class="w-full">
                                    {{-- <td class="py-3 ps-4">
                                      <div class="flex h-5 items-center">
                                          <input id="hs-table-search-checkbox-1" type="checkbox"
                                              class="rounded-sm border-gray-200 text-blue-600 focus:ring-blue-500">
                                          <label for="hs-table-search-checkbox-1" class="sr-only">Checkbox</label>
                                      </div>
                                  </td> --}}
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                        {{ $supply->item_description }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                        {{ $supply->category }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 capitalize text-sm text-gray-800">
                                        {{ $supply->unit }}
                                    </td>
                                    <td
                                        class="items-center whitespace-nowrap px-6 py-4 text-end text-sm font-medium sm:flex sm:justify-end sm:gap-x-2 xl:gap-x-3">

                                        <button wire:click="addStock({{ $supply }})"
                                            class="text-green-600 hover:text-green-800">Add to Stock</button>

                                        <button type="button"
                                            class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-sm font-semibold text-red-600 hover:text-red-800 focus:text-red-800 disabled:pointer-events-none disabled:opacity-50">Delete</button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3 text-center text-sm text-gray-500">No supplies yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- pagination --}}
            </div>
            <div class="text-gray-700 xl:mt-6">
                {{ $this->supplies->links() }}
            </div>
        </div>
    </div>

    {{-- ADD SUPPLY --}}
    <div x-cloak x-data="{
        supply_form: false
    }" x-show="supply_form" x-transition
        x-on:open-supply-form.window="supply_form = true;" class="fixed inset-0 z-50">
        <div x-on:click="supply_form = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>
        <div
            class="fixed left-1/2 top-10 w-full max-w-lg -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:px-5 sm:py-9">

            <div class="sm:flex sm:items-center gap-x-3">
                <h4 class="text-xl font-semibold">Add Supply</h4>
                @if (session('status'))
                    <p class="text-green-400 text-sm">{{ session('status') }}</p>
                @endif
            </div>
            {{-- forms --}}
            <form wire:submit.prevent="saveSupply" class="mt-4 space-y-4">
                <div>
                    <x-input-label for="item_description" :value="__('Item Description')" />
                    <x-text-input id="item_description" wire:model="supplyForm.item_description" type="text"
                        class="w-full capitalize" required autofocus />
                    @error('supplyForm.item_description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:flex w-full gap-4 mt-4">
                    {{-- Category --}}
                    <div class="flex flex-col w-full">
                        <x-input-label for="category" :value="__('Category')" />
                        <select id="category" required wire:model="supplyForm.category"
                            class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                            @endforeach

                        </select>
                        @error('supplyForm.category')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Unit --}}
                    <div class="flex flex-col w-full">
                        <x-input-label for="unit" :value="__('Unit')" />
                        <select id="unit" required wire:model="supplyForm.unit"
                            class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                            <option value="">-- Select Unit --</option>
                            @foreach ($units as $uom)
                                <option value="{{ $uom }}">{{ ucfirst($uom) }}</option>
                            @endforeach
                        </select>
                        @error('supplyForm.unit')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <x-input-label for="image" :value="__('Image item ( Optional )')" />
                    <input type="file" wire:model="supplyForm.image"
                        class="w-full p-2 border rounded focus:ring-orange-500" id="image">
                    @error('supplyForm.image')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:my-5 sm:flex justify-end items-center">
                    <button class="mt-4 text-sm text-green-600 hover:font-medium">Add Stock</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ADD TO STOCK --}}
    @if ($selectedSupply)
        <div x-cloak x-data="{ show: false }" x-transition x-show="show" x-on:open-modal.window="show = true;"
            x-on:close-modal.window="show = false" class="fixed inset-0 z-50">
            <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

            <!-- Modal Content -->
            <div
                class="fixed left-1/2 top-10 w-full max-w-md -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:px-5 sm:py-9 xl:max-w-lg">
                <h4 class="pb-4 text-xl font-semibold">Add Stock</h4>

                {{-- forms --}}
                <form wire:submit.prevent="saveStock" class="mt-4 space-y-2">
                    <input type="hidden" wire:model="stockForm.supply_id" />
                    @error('stockForm.supply_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="items-center justify-between rounded border border-green-500 bg-green-200 p-4 sm:flex">
                        <div>
                            <small class="text-xs text-gray-600">Item Description</small>
                            <p class="text-lg font-semibold text-gray-800">{{ $selectedSupply->item_description }}</p>
                        </div>
                        <div>
                            <small class="text-xs text-gray-600">Category</small>
                            <p class="text-lg font-semibold text-gray-800">{{ $selectedSupply->category }}</p>
                        </div>
                        <div>
                            <small class="text-xs text-gray-600">Unit</small>
                            <p class="text-lg font-semibold capitalize text-gray-800">{{ $selectedSupply->unit }}</p>
                        </div>
                    </div>
                    {{-- inputs --}}
                    <div>
                        <x-input-label for="barcode" :value="__('Barcode')" />
                        <x-text-input id="barcode" type="text" wire:model="stockForm.barcode"
                            autocomplete="off" class="w-full" required autofocus />
                        @error('stockForm.barcode')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:flex sm:items-center sm:gap-x-2">
                        <div>
                            <x-input-label for="item_quantity" :value="__('Item Quantity')" />
                            <x-text-input id="item_quantity" type="number" wire:model="stockForm.item_quantity"
                                class="w-full" required autofocus />
                            @error('stockForm.item_quantity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-input-label for="item_price" :value="__('Item Price')" />
                            <x-text-input step="0.01" id="item_price" type="number"
                                wire:model="stockForm.item_price" class="w-full" required autofocus />
                            @error('stockForm.item_price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <x-input-label for="expiration" :value="__('Expiration')" />
                        <x-text-input id="expiration" type="text" autocomplete="off"
                            wire:model="stockForm.expiration" class="w-full" required autofocus />
                        @error('stockForm.expiration')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-input-label for="remarks" :value="__('Remarks')" />
                        <x-text-input id="remarks" type="text" autocomplete="off"
                            wire:model="stockForm.remarks" class="w-full" required autofocus />
                        @error('stockForm.remarks')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:flex sm:items-center sm:justify-end sm:gap-x-5">
                        <button @click="$dispatch('close-modal')" class="mt-4 text-sm text-red-500 hover:font-medium">
                            Close
                        </button>
                        <button type="submit" class="mt-4 text-sm text-green-600 hover:font-medium">
                            Add Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>

