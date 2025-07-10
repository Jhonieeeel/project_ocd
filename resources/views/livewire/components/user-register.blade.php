<div class="h-auto w-full p-6 sm:p-2 ">
    <p class="text-xl font-semibold">Register Form</p>
    <div class="rounded-md bg-gray-50  sm:pb-4 pt-4">
        <div class="border shadow p-6 py-4 rounded">
            <form wire:submit.prevent="save">
                <div class="">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="barcode" type="text" autocomplete="off"
                        class="w-full text-orange-600" required autofocus />
                </div>
                <div class="pt-3">
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" type="text" autocomplete="off"
                        class="w-full text-orange-600" required autofocus />
                </div>
                <div class="sm:flex item-center gap-3">
                    <div class="pt-3">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" type="password" autocomplete="off"
                            class="w-full text-orange-600" required autofocus />
                    </div>
                    <div class="pt-3">
                        <x-input-label for="confirm_password" :value="__('Confirm Password')" />
                        <x-text-input id="confirm_password" type="password" autocomplete="off"
                            class="w-full text-orange-600" required autofocus />
                    </div>
                </div>
                <div class="pt-3">
                    <x-input-label for="approved_by" :value="__('Roles')" />
                    <select wire:model="userRole" id="approved_by"
                        class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm transition-all duration-200 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">

                        <option> -- Select User Role</option>
                        @foreach ($roles as $role)
                        <option value=" {{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pt-3 pb-1 text-end">
                    <button class="px-4 py-2 bg-orange-600 text-white rounded">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>