<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="inline-block min-w-full p-1.5 align-middle">
            <h3 class="pb-4 pt-2 text-2xl font-semibold">Request List</h3>
            <div class="divide-y divide-gray-200 rounded-lg border border-gray-200">
                {{-- search bar --}}
                <div class="px-4 py-3 sm:flex sm:items-center sm:justify-between">
                    <div class="relative max-w-xs">
                        <label for="hs-table-search" class="sr-only">Search</label>
                        <input type="text" name="hs-table-search" id="hs-table-search"
                            class="shadow-2xs block w-full rounded-lg border-orange-400 px-3 py-1.5 ps-9 focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 sm:py-2 sm:text-sm"
                            placeholder="Search for items">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <svg class="size-4 text-orange-400" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                    </div>
                    @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
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
                    @else
                        <a href="{{ route('my-request-list') }}"
                            class="relative hidden p-2 transition-all duration-300 hover:text-orange-500 sm:flex sm:items-center sm:gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-archive-icon lucide-archive">
                                <rect width="20" height="5" x="2" y="3" rx="1" />
                                <path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8" />
                                <path d="M10 12h4" />
                            </svg>

                            <!-- Label Text -->
                            <span class="hidden text-sm sm:block">My Requests</span>
                            <span
                                class="absolute left-5 top-0 inline-flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-semibold text-white">
                                {{ auth()->user()->withdraw()->count() }}
                            </span>
                        </a>
                    @endif
                </div>
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-orange-500">
                            <tr>
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
                                        class="whitespace-nowrap px-6 py-4 text-xs font-medium capitalize text-gray-800">
                                        {{ $request->stock->barcode }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-xs font-medium capitalize text-gray-800">
                                        {{ $request->stock->supply->item_description }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-xs text-gray-800">
                                        {{ $request->requested_quantity }}
                                    </td>

                                    <td
                                        class="{{ $request->requestedBy ? 'text-gray-800' : 'text-orange-400' }} whitespace-nowrap px-6 py-4 text-xs">
                                        {{-- {{ $request->requested_by === auth()->id() ? 'You' : $request->requestedBy?->name }} --}}
                                        {{ $request->requestedBy?->name ?? 'Pending' }}

                                    </td>
                                    <td
                                        class="{{ $request->approvedBy ? 'text-gray-800' : 'text-orange-400' }} whitespace-nowrap px-6 py-4 text-xs">
                                        {{ $request->approvedBy?->name ?? 'Pending' }}
                                    </td>
                                    <td
                                        class="{{ $request->issuedBy ? 'text-gray-800' : 'text-orange-400' }} whitespace-nowrap px-6 py-4 text-xs">
                                        {{ $request->issuedBy?->name ?? 'Pending' }}
                                    </td>
                                    <td
                                        class="{{ $request->receivedBy ? 'text-gray-800' : 'text-orange-400' }} whitespace-nowrap px-6 py-4 text-xs">
                                        {{ $request->receivedBy?->name ?? 'Pending' }}
                                    </td>
                                    @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
                                        <td
                                            class="items-center whitespace-nowrap px-6 py-4 text-end text-sm font-medium sm:flex sm:justify-end sm:gap-x-2 xl:gap-x-3">

                                            <button wire:click="viewRequest({{ $request }})" type="button"
                                                class="text-gray-600 hover:text-gray-800">
                                                View
                                            </button>
                                            <button wire:click="success({{ $request->id }})"
                                                {{ $request->status ? '' : 'disabled' }}
                                                class="{{ $request->status ? 'text-green-600 hover:text-green-800' : 'text-green-200 cursor-not-allowed' }}">Confirm</button>
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

        <!-- edit request -->
        <div x-cloak x-data="{ show: false }" x-transition x-show="show" x-on:open-modal.window="show = true;"
            x-on:close-modal.window="show = false" class="fixed inset-0 z-50">
            <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

            <!-- Modal Content -->
            <div class="fixed left-1/2 top-10 w-full max-w-2xl -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:p-9">

                <div class="justify-between sm:flex">
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
                    <input type="hidden" wire:model="withdrawForm.stock_id">
                    <input type="hidden" wire:model="withdrawForm.status">
                    <input type="hidden" wire:model="withdrawForm.approved_date">
                    <input type="hidden" wire:model="withdrawForm.issued_date">
                    <input type="hidden" wire:model="withdrawForm.requested_date">
                    <input type="hidden" wire:model="withdrawForm.received_date">
                    <div class="w-full items-center gap-3 sm:flex">
                        <div class="w-full">
                            <x-input-label for="ris" :value="__('RIS No.')" />
                            <x-text-input id="ris" type="text" wire:model="withdrawForm.ris" class="w-full"
                                required autofocus />
                            <x-input-error :messages="$errors->get('withdrawForm.ris')" class="mt-2 text-xs" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="item_quantity" :value="__('Item Quantity')" />
                            <x-text-input id="item_quantity" type="number"
                                wire:model="withdrawForm.requested_quantity" class="w-full" required autofocus />
                            @error('withdrawForm.requested_quantity')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- req, approve, issue, receive --}}
                    <div class="w-full items-center gap-3 sm:grid sm:grid-cols-2">
                        <div class="w-full">
                            <x-input-label for="approved_by" :value="__('Approved By')" />
                            <select wire:model="withdrawForm.approved_by" id="approved_by"
                                class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">

                                <option value="">-- Select Approver --</option>
                                @foreach ($this->approveUsers as $admin)
                                    @if ($admin->hasAnyRole(['super-admin', 'admin']))
                                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                    @endif
                                @endforeach
                            </select>

                        </div>
                        <div class="w-full">
                            <x-input-label for="issued_by" :value="__('Issued By')" />
                            <select wire:model="withdrawForm.issued_by" id="approved_by"
                                class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                                <option value=""> -- Select Issueance -- </option>
                                @foreach ($this->issueanceUsers as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full">
                            <x-input-label class="text-center" for="user_roles" :value="__('Select Role for Receiver')" />
                            <select wire:model.live.debounce.300ms="roles" id="requestAndReceive" required
                                class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                                <option value=""> -- Select Role -- </option>
                                @foreach ($this->userRoles as $role)
                                    <option class="capitalize" value="{{ $role->name }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full">
                            <x-input-label class="text-center" for="received_b6" :value="__('Receive by')" />
                            <select wire:model.live.debounce.300ms="withdrawForm.received_by" id="requestAndReceive"
                                required
                                class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                                <option value=""> -- Select User -- </option>
                                @foreach ($this->receivers as $user)
                                    <option class="capitalize" value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
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
                    <div class="sm:flex sm:items-center sm:justify-end sm:gap-x-5">
                        <button wire:click="delete({{ $selectedRequest }})"
                            class="mt-4 rounded bg-red-500 px-4 py-2 text-sm text-white hover:bg-red-800 hover:font-medium">Delete</button>
                        <button type="submit"
                            class="mt-4 rounded bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-800 hover:font-medium">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- confirming request -->
        <div x-cloak x-data="{ show: false }" x-show="show" x-on:open-confirm-modal.window="show = true"
            x-on:close-confirm-modal.window="show = false" class="fixed inset-0 z-50">
            <!-- gray background -->
            <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

            <!-- modal content -->
            <div class="fixed left-1/2 top-10 w-full max-w-2xl -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:p-9">
                <div></div>
            </div>
        </div>

        <!-- success modal -->
        <div x-cloak x-data="{ show: false }" x-show="show" x-on:open-success-modal.window="show = true"
            x-on:close-success-modal.window="show = false" class="fixed inset-0 z-50">
            <!-- gray background -->
            <div x-on:click="show = false" class="fixed inset-0 bg-gray-300 opacity-50"></div>

            <!-- modal content -->
            <div class="fixed left-1/2 top-10 w-full max-w-sm -translate-x-1/2 rounded bg-white p-4 shadow-lg sm:p-9">
                <div class="flex-col items-center justify-center space-y-4 sm:flex">
                    <div class="rounded-full bg-green-100 p-4">
                        <div class="rounded-full bg-green-600 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-check-icon lucide-check">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-center">
                        <small class="text-orange-400">Confirmed Request</small>
                        <h3 class="text-xl font-semibold">{{ $printWithdraw?->stock->supply->item_description }}</h3>

                    </div>
                    <hr>
                    <div class="mt-2 w-full justify-between sm:flex">
                        <div class="space-y-2 text-start">
                            <p class="text-sm text-orange-400">Barcode:</p>
                            <p class="text-sm text-orange-400">Approved By:</p>
                            <p class="text-sm text-orange-400">Issued By:</p>
                            <p class="text-sm text-orange-400">Requested Qty:</p>
                        </div>
                        <div class="space-y-2 text-end">
                            <p class="text-sm text-gray-600">
                                {{ $printWithdraw?->stock->barcode }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $printWithdraw?->approvedBy->name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $printWithdraw?->issuedBy->name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $printWithdraw?->requested_quantity }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-2 w-full justify-between sm:flex">
                        <div class="space-y-2 text-start">
                            <p class="text-sm text-orange-400">Requested By:</p>
                            <p class="text-sm text-orange-400">Received By:</p>

                        </div>
                        <div class="space-y-2 text-end">
                            <p class="text-sm text-gray-600">
                                {{ $printWithdraw?->requestedBy->name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $printWithdraw?->receivedBy->name }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-2 w-full">
                        @if (session('printed_created'))
                            <div class="items-center justify-center gap-x-4 sm:flex">
                                <p class="px-4 text-xs text-green-600">{{ session('printed_created') }}</p>
                                <button wire:click="printRIS({{ $printWithdraw?->id }})"
                                    class="rounded bg-green-600 px-4 py-2 text-xs font-medium text-white transition-all duration-300 hover:bg-green-800">Get
                                    Printed RIS</button>
                            </div>
                        @else
                            <div class="justify-center sm:flex">
                                <button wire:click="printRIS({{ $printWithdraw?->id }})"
                                    class="rounded bg-green-600 px-4 py-2 text-xs font-medium text-white transition-all duration-300 hover:bg-green-800">Get
                                    Printed RIS</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

