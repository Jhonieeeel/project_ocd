<div class="h-auto w-full p-6 sm:p-2 ">
    <p class="text-md font-medium">Register Form</p>
    <div class="rounded-md bg-gray-50  sm:pb-4 pt-4">
        <div class="border shadow p-6 py-4 rounded">
            <form wire:submit.prevent="save" class="space-y-3">
                <div class="">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="barcode" wire:model="userForm.name" type="text" autocomplete="off"
                        class="w-full text-gray-600" required autofocus />
                </div>
                <div class="pt-3">
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" wire:model="userForm.email" type="text" autocomplete="off"
                        class="w-full text-gray-600" required autofocus />
                </div>
                <div class="sm:flex items-center gap-3">
                    <div class="w-full">
                        <x-input-label for="email" :value="__('Division')" />
                        <select wire:model="userDivision" id="approved_by"
                            class="w-full rounded border border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">

                            <option> -- Select Divison</option>
                            @foreach ($divisions as $division)
                            <option value="{{ $division }}">{{ $division }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <x-input-label for="email" :value="__('Office')" />
                        <select wire:model="userDivision" id="approved_by"
                            class="w-full rounded border border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">

                            <option> -- Select Office -- </option>
                            @foreach ($offices as $office)
                            <option value=" {{ $office }}">{{ $office }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="sm:flex items-center justify-between gap-x-3">
                    <div class="pt-3 w-full">
                        <x-input-label for="approved_by" :value="__('Roles')" />
                        <select wire:model="userRole" id="approved_by"
                            class="w-full rounded border border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">

                            <option> -- Select User Role -- </option>
                            @foreach ($roles as $role)
                            <option value=" {{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="pt-3 pb-1 text-end">
                    <button class="px-4 py-2 bg-orange-600 text-white rounded">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>