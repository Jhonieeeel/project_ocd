<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="inline-block min-w-full p-1.5 align-middle">
            <div class="divide-y divide-gray-200 rounded-lg border border-gray-200">
                {{-- search bar --}}
                <div class="px-4 py-3 sm:flex sm:items-center sm:justify-between">
                    <div class="relative max-w-xs">
                        <label for="hs-table-search" class="sr-only">Search</label>
                        <input type="text" name="hs-table-search" id="hs-table-search"
                            class="shadow-2xs block w-full rounded-lg border-gray-400 px-3 py-1.5 ps-9 focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 sm:py-2 sm:text-sm"
                            placeholder="Search for items">
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
                                    Barcode</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Item Description</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Quantity</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Price</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Requested by</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Approved by</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Issued by</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Received by</th>
                                <th scope="col" colspan="2"
                                    class="px-6 py-3 text-end text-xs font-medium uppercase text-gray-50">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->requests as $request)
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
                                        {{ $request->stock->barcode }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                        {{ $request->stock->supply->item_description }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                        {{ $request->stock->item_quantity }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                        {{ $request->stock->item_price }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm {{ $request->requestedBy ? 'text-gray-800' : 'text-gray-400' }}">
                                        {{ auth()->user()->id === $request->requestedBy->name ? 'You' : $request->requestedBy->name }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm {{ $request->approvedBy ? 'text-gray-800' : 'text-gray-400' }}">
                                        {{ $request->approvedBy ? $request->approvedBy->name : 'Pending' }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm {{ $request->issuedBy ? 'text-gray-800' : 'text-gray-400' }}">
                                        {{ $request->issuedBy ? $request->issuedBy->name : 'Pending' }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm {{ $request->receivedBy ? 'text-gray-800' : 'text-gray-400' }}">
                                        {{ $request->receivedBy ? $request->receivedBy->name : 'Pending' }}
                                    </td>
                                    <td
                                        class="items-center whitespace-nowrap px-6 py-4 text-end text-sm font-medium sm:flex sm:justify-end sm:gap-x-2 xl:gap-x-3">
                                        @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
                                            <button x-data wire:click="viewRequest({{ $request }})" type="button"
                                                class="text-green-600 hover:text-green-800">
                                                Confirm
                                            </button>
                                        @endif
                                        <button wire:click="delete({{ $request }})" type="button"
                                            class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-sm font-semibold text-red-600 hover:text-red-800 focus:text-red-800 disabled:pointer-events-none disabled:opacity-50">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-3 text-center text-sm text-gray-500">No requested items
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
    </div>

    <div x-cloak x-data="{ show: false }" x-transition x-show="show" x-on:open-modal.window="show = true;
    "
        x-on:close-modal.window="show = false" class="fixed inset-0 z-50">
        <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

        <!-- Modal Content -->
        <div class="fixed left-1/2 top-10 w-full max-w-lg -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:p-9">

            <h4 class="text-xl font-semibold">Confirm Request</h4>
            {{-- forms --}}
            <form wire:submit.prevent="save" class="mt-4 space-y-2">
                <div>
                    <x-input-label for="ris" :value="__('RIS No.')" />
                    <x-text-input id="ris" type="text" class="w-full" required autofocus />
                    <x-input-error :messages="$errors->get('ris')" class="mt-2" />
                </div>
                <div class="sm:grid grid-cols-2 items-center gap-3">
                    <div class="w-full">
                        <x-input-label for="approved_by" :value="__('Approved By')" />
                        <select wire:model.live="approver_id" id="approved_by" name="approved_by" required
                            class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                            <option value="">Select Approver</option>
                            @foreach ($this->superAdmins as $user)
                                @if ($user->hasAnyRole(['super-admin', 'admin']))
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>

                    </div>
                    <div class="w-full">
                        <x-input-label for="issued_by" :value="__('Issued By')" />
                        <select wire:model.live.debounce.300ms="issueance_id" id="approved_by" required
                            class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                            <option value="">Select Issueance</option>
                            @foreach ($this->admins as $user)
                                @if ($user->hasAnyRole(['super-admin', 'admin']))
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <x-input-label for="requested_by" :value="__('Requested By')" />
                        <x-text-input id="requested_by" type="text" wire:model="requestedUser" class="w-full"
                            required autofocus />
                    </div>
                    <div class="w-full">
                        <x-input-label for="received_by" :value="__('Received By')" />
                        <x-text-input id="received_by" type="text" wire:model="receivedUser" class="w-full"
                            required autofocus />
                    </div>
                </div>
                <div>
                    <x-input-label for="remarks" :value="__('Remarks')" />
                    <x-text-input id="remarks" type="text" name="remarks" class="w-full" required autofocus />
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                </div>
                <div class="sm:flex sm:justify-end sm:items-center sm:gap-x-5">
                    <button @click="$dispatch('close-modal')"
                        class="mt-4 text-sm text-red-500 hover:font-medium">Close</button>
                    <button class="mt-4 text-sm text-green-600 hover:font-medium  ">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>

