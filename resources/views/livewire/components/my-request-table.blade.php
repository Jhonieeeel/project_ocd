<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="inline-block min-w-full p-1.5 align-middle">
            <h3 class="text-md pb-4 pt-2 font-semibold">My Requests</h3>
            <div class="divide-y divide-gray-200 rounded-lg border border-gray-200 shadow">
                {{-- search bar --}}
                <div class="px-4 py-3 sm:flex sm:items-center sm:justify-between">
                    <div class="relative max-w-xs">
                        <label for="hs-table-search" class="sr-only">Search</label>
                        <input type="text" name="hs-table-search" id="hs-table-search"
                            class="shadow-2xs block w-full rounded-lg border-orange-400 px-3 py-1.5 ps-9 focus:z-10 focus:border-orange-500 focus:ring-orange-500 disabled:pointer-events-none disabled:opacity-50 sm:py-2 sm:text-sm"
                            placeholder="Search for items">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center  ps-3">
                            <svg class="size-4 text-orange-400" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                    </div>

                    <a href="{{ route('stocks') }}"
                        class="relative hidden p-2 transition-all duration-300 hover:text-orange-500 sm:flex sm:items-center sm:gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-box-icon lucide-box">
                            <path
                                d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                            <path d="m3.3 7 8.7 5 8.7-5" />
                            <path d="M12 22V12" />
                        </svg>

                        <!-- Label Text -->
                        <span class="hidden text-sm sm:block">View Stocks</span>
                    </a>
                </div>
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
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Barcode</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Item Description</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Quantity</th>

                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Requested by</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Approved by</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Issued by</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Received by</th>
                                <th scope="col" colspan="2"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->requests as $request)
                            <tr class="w-full">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                    {{ $request->stock->barcode }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                    {{ $request->stock->supply->item_description }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                    {{ $request->requested_quantity }}
                                </td>

                                <td
                                    class="{{ $request->user_id === auth()->id() ? 'text-gray-800' : 'text-gray-400' }} whitespace-nowrap px-6 py-4 text-sm">
                                    {{ $request->user_id === auth()->id() ? 'You' : $request->requestedBy?->name ?? 'Unknown' }}
                                </td>

                                <td
                                    class="{{ $request->approved_by ? 'text-gray-800' : 'text-gray-400' }} whitespace-nowrap px-6 py-4 text-sm">
                                    {{ $request->approvedBy ? $request->approvedBy->name : 'Pending' }}
                                </td>

                                <td
                                    class="{{ $request->issued_by ? 'text-gray-800' : 'text-gray-400' }} whitespace-nowrap px-6 py-4 text-sm">
                                    {{ $request->issuedBy ? $request->issuedBy->name : 'Pending' }}
                                </td>

                                <td
                                    class="{{ $request->received_by ? 'text-gray-800' : 'text-gray-400' }} whitespace-nowrap px-6 py-4 text-sm">
                                    {{ $request->receivedBy ? $request->receivedBy->name : 'Pending' }}
                                </td>

                                <td colspan="2"
                                    class="items-center whitespace-nowrap px-6 py-4 text-end text-sm font-medium sm:flex sm:justify-start sm:gap-x-2 xl:gap-x-3">
                                    <button wire:click="selectEdit({{ $request }})"
                                        class="text-green-600 hover:text-green-800">
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $request }})" type="button" class="text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="py-3 text-center text-sm text-gray-500">You have no requested
                                    items
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
                {{ $this->requests->links() }}
            </div>
        </div>
        <div x-cloak x-data="{ show: false }" x-transition x-show="show" x-on:open-edit-modal.window="show = true;"
            x-on:close-edit-modal.window="show = false" class="fixed inset-0 z-50">
            <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

            <!-- Modal Content -->
            <div
                class="fixed left-1/2 top-10 w-full max-w-lg -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:px-9 sm:py-6 xl:p-4">
                <h4 class="text-lg font-semibold">Edit Request</h4>
                {{-- forms --}}
                <form class="mt-4">
                    <div class="space-y-4">
                        <input type="hidden" wire:model="stock_id" />
                        <input type="hidden" wire:model="user_id" />
                        <div class="w-full items-center gap-x-3 bg-green-100 p-4 sm:flex xl:gap-x-6">
                            <div class="">
                                <small class="text-xs text-gray-500">Item Description</small>
                                <p class="text-lg font-semibold capitalize text-gray-800">
                                    {{ $selectedEdit->stock?->supply->item_description }}
                                </p>
                            </div>
                            <div class="">
                                <small class="text-xs text-gray-500">Requested Quantity</small>
                                <p class="text-lg font-semibold capitalize text-gray-800">
                                    {{ $selectedEdit->requested_quantity }}
                                </p>
                            </div>
                        </div>
                        <div class="sm:pb-2">
                            <small for="requested_quantity" class="block pb-2 text-xs text-gray-400">Request Qty</small>
                            <input type="number" wire:model="requested_quantity" placeholder="0" min=0
                                max={{ $selectedEdit->item_quantity }} id="requested_quantity"
                                class="sm:w-54 rounded border-gray-400 focus:border-orange-500 focus:ring-orange-500 sm:h-10">
                            <x-input-error :messages="$errors->get('requested_quantity')" class="mt-2" />
                            @error('requested_quantity')
                            <span class="block text-sm text-red-500 sm:mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <hr>
                    </div>
                    <div class="justify-end py-3 sm:flex sm:items-center sm:gap-3">
                        <button type="button" x-on:click="$dispatch('close-edit-modal')"
                            class="text-sm text-red-600 px-4 py-2 rounded border-red-600 border  hover:font-medium hover:bg-red-600 hover:text-gray-100 transition-all duration-300">Cancel</button>
                        <button wire:click="update"
                            class="text-sm bg-green-600 transition-all duration-300  rounded px-4 py-2 text-gray-100 hover:bg-green-800">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>