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
                    @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
                        <a href="{{ route('my-request-list') }}"
                            class="relative hidden transition-all duration-300 p-2 sm:flex sm:items-center sm:gap-x-2 hover:text-orange-500">
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
                                class="absolute top-0 left-5 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold text-white bg-red-500 rounded-full">
                                {{ $requests }}
                            </span>
                        </a>
                    @else
                        <a href="{{ route('my-request-list') }}"
                            class="relative hidden transition-all duration-300  p-2 sm:flex sm:items-center sm:gap-x-2 hover:text-orange-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-archive-icon lucide-archive">
                                <rect width="20" height="5" x="2" y="3" rx="1" />
                                <path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8" />
                                <path d="M10 12h4" />
                            </svg>

                            <!-- Label Text -->
                            <span class="hidden text-sm  sm:block">My Requests</span>
                            <span
                                class="absolute top-0 left-5 inline-flex items-center justify-center w-5 h-5 text-xs font-semibold text-white bg-red-500 rounded-full">
                                {{ auth()->user()->withdraw()->count() }}
                            </span>
                        </a>
                    @endif
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
                                @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
                                    <th scope="col" colspan="2"
                                        class="px-6 py-3 text-end text-xs font-medium uppercase text-gray-50">
                                        Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->requests as $request)
                                <tr class="w-full">
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                        {{ $request->stock->barcode }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                        {{ $request->stock->supply->item_description }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800">
                                        {{ $request->requested_quantity }}
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
                                    @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
                                        <td
                                            class="items-center whitespace-nowrap px-6 py-4 text-end text-sm font-medium sm:flex sm:justify-end sm:gap-x-2 xl:gap-x-3">

                                            <button wire:click="viewRequest({{ $request }})" type="button"
                                                class="text-green-600 hover:text-green-800">
                                                View
                                            </button>
                                            <button wire:click="click" {{ $request->status ? '' : 'disabled' }}
                                                class="{{ $request->status ? 'text-orange-600 hover:text-orange-800' : 'text-gray-400 cursor-not-allowed' }}">Print</button>

                                            <!-- <button wire:click="delete({{ $request }})" type="button"
                                        class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-sm font-semibold text-red-600 hover:text-red-800 focus:text-red-800 disabled:pointer-events-none disabled:opacity-50">Delete</button> -->
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-3 text-center text-sm text-gray-500">No requested items
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
        <div x-cloak x-data="{ show: false }" x-transition x-show="show" x-on:open-modal.window="show = true;"
            x-on:close-modal.window="show = false" class="fixed inset-0 z-50">
            <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

            <!-- Modal Content -->
            <div class="fixed left-1/2 top-10 w-full max-w-2xl -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:p-9">

                <div class="sm:flex justify-between">
                    <h4 class="text-xl font-semibold">Confirm Request</h4>
                    <button @click="$dispatch('close-modal')"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-x-icon lucide-x">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg></button>
                </div>
                {{-- forms --}}
                <form wire:submit.prevent="update" class="mt-4 space-y-2">
                    <input type="hidden" wire:model="withdrawForm.stock_id" value="{{ $selectedRequest->id }}">
                    <div class="sm:flex items-center gap-3">
                        <div>
                            <x-input-label for="ris" :value="__('RIS No.')" />
                            <x-text-input id="ris" type="text" wire:model="withdrawForm.ris" class="w-full"
                                required autofocus />
                            <x-input-error :messages="$errors->get('withdrawForm.ris')" class="mt-2 text-xs" />
                        </div>
                        <div>
                            <x-input-label for="item_quantity" :value="__('Item Quantity')" />
                            <x-text-input id="item_quantity" type="number"
                                wire:model="withdrawForm.requested_quantity" class="w-full" required autofocus />
                            @error('withdrawForm.requested_quantity')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- req, approve, issue, receive --}}
                    <div class="sm:grid grid-cols-2 items-center gap-3 w-full">
                        <div class="w-full">
                            <x-input-label for="approved_by" :value="__('Approved By')" />
                            <select wire:model.live.debounce.300ms="withdrawForm.approved_by" id="approved_by"
                                required
                                class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                                @if ($approverName)
                                    <option disabled value="{{ $withdrawForm->approved_by }}">{{ $approverName }}
                                    </option>
                                    @foreach ($this->approveUsers as $admin)
                                        @if ($admin->hasAnyRole(['super-admin', 'admin']))
                                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option> -- Select Approver -- </option>
                                    @foreach ($this->approveUsers as $admin)
                                        @if ($admin->hasAnyRole(['super-admin', 'admin']))
                                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="w-full">
                            <x-input-label for="issued_by" :value="__('Issued By')" />
                            <select wire:model.live.debounce.300ms="withdrawForm.issued_by" id="approved_by" required
                                class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                                <option value=""> -- Select Issueance -- </option>
                                @foreach ($this->issueanceUsers as $user)
                                    @if ($user->hasAnyRole(['super-admin', 'admin']))
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full col-span-2">
                            <x-input-label class="text-center" for="requestAndReceive" :value="__('Request by/Receive by')" />
                            <select wire:model.live.debounce.300ms="withdrawForm.requested_by" id="requestAndReceive"
                                required
                                class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 focus:outline-none">
                                <option value=""> -- Select User -- </option>
                                @foreach ($this->requestAndReceive as $withdraw)
                                    <option value="{{ $withdraw->requested_by }}">
                                        {{ $withdraw->requestedBy->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- remarks --}}
                    <div>
                        <x-input-label for="remarks" :value="__('Remarks')" />
                        <x-text-input id="remarks" type="text" wire:model="withdrawForm.remarks" class="w-full"
                            required autofocus />
                        <x-input-error :messages="$errors->get('withdrawForm.remarks')" class="mt-2" />
                    </div>
                    {{-- buttons --}}
                    <div class="sm:flex sm:justify-end sm:items-center sm:gap-x-5">
                        <button wire:click="delete({{ $selectedRequest }})"
                            class="mt-4 text-sm text-red-500 hover:font-medium">Delete</button>
                        <button type="submit" class="mt-4 text-sm text-green-600 hover:font-medium">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

