<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="inline-block min-w-full p-1.5 align-middle">
            <h3 class="text-xl pb-4 pt-2 font-semibold">User Management</h3>
            <div class="divide-y divide-gray-200 rounded-lg border border-gray-200 shadow">
                {{-- search bar --}}
                <div class="px-4 py-3 sm:flex sm:items-center sm:justify-between ">
                    <div class="relative max-w-md">
                        <div class="flex items-center gap-x-3">
                            <div>
                                <label for="hs-table-search" class="sr-only">Search</label>
                                <input type="text" name="hs-table-search" id="hs-table-search"
                                    class="shadow-2xs block w-full rounded-lg border-orange-400 px-3 py-1.5 ps-9 focus:z-10 focus:border-orange-500 focus:ring-orange-500 disabled:pointer-events-none disabled:opacity-50 sm:py-2 sm:text-sm"
                                    placeholder="Search Users">
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
                </div>
                {{-- table --}}
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-orange-500">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Super Admin</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Admin</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-50">
                                    Employee</th>

                                <th scope="col" colspan="2"
                                    class="px-6 py-3 text-end text-xs font-medium uppercase text-gray-50">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->users as $user)
                            <tr class="w-full">
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                    {{ $user->name }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                    <!-- super admin -->
                                    @if($user->hasRole('super-admin'))
                                    <input checked wire:click="superRole({{ $user->id }})" type="checkbox" class="shrink-0 mt-0.5 border-gray-500 rounded-sm text-orange-600 focus:ring-orange-500 checked:border-orange-500 disabled:opacity-50 disabled:pointer-events-none">
                                    @else
                                    <input wire:click="superRole({{ $user->id }})" type="checkbox" class="shrink-0 mt-0.5 border-gray-500 rounded-sm text-orange-600 focus:ring-orange-500 checked:border-orange-500 disabled:opacity-50 disabled:pointer-events-none">
                                    @endif
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                    <!-- super admin -->
                                    @if($user->hasRole('admin'))
                                    <input checked wire:click="adminRole({{ $user->id }})" type="checkbox" class="shrink-0 mt-0.5 border-gray-500 rounded-sm text-orange-600 focus:ring-orange-500 checked:border-orange-500 disabled:opacity-50 disabled:pointer-events-none">
                                    @else
                                    <input wire:click="adminRole({{ $user->id }})" type="checkbox" class="shrink-0 mt-0.5 border-gray-500 rounded-sm text-orange-600 focus:ring-orange-500 checked:border-orange-500 disabled:opacity-50 disabled:pointer-events-none">
                                    @endif
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium capitalize text-gray-800">
                                    <!-- super admin -->
                                    @if($user->hasRole('user'))
                                    <input checked wire:click="userRole({{ $user->id }})" type="checkbox" class="shrink-0 mt-0.5 border-gray-500 rounded-sm text-orange-600 focus:ring-orange-500 checked:border-orange-500 disabled:opacity-50 disabled:pointer-events-none">
                                    @else
                                    <input wire:click="userRole({{ $user->id }})" type="checkbox" class="shrink-0 mt-0.5 border-gray-500 rounded-sm text-orange-600 focus:ring-orange-500 checked:border-orange-500 disabled:opacity-50 disabled:pointer-events-none">
                                    @endif
                                </td>

                                <td
                                    class="items-center whitespace-nowrap px-6 py-4 text-end text-sm font-medium sm:flex sm:justify-end sm:gap-x-2 xl:gap-x-3">
                                    <button wire:click="deleteUser({{ $user->id }})" type="button"
                                        class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-xs font-semibold text-red-600 hover:text-red-800 focus:text-red-800 disabled:pointer-events-none disabled:opacity-50">Delete</button>
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
            </div>
            <div class="text-gray-700 xl:mt-6">
                <!-- pagination -->
            </div>
        </div>
    </div>
</div>