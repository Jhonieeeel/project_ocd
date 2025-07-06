<div class="grid-rows-auto mb-1 grid grid-cols-1 gap-4 p-6 sm:mb-3 sm:grid-cols-3 sm:p-3">
    <a href="{{ route('dashboard') }}" class="rounded-md bg-gray-50 p-2">
        <div class="sm:justfiy-start flex items-center gap-6 p-6 sm:gap-3 sm:p-4">
            <div class="rounded-full bg-green-200 p-6 sm:p-2">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-green-500 sm:size-12" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-package-icon lucide-package">
                        <path
                            d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                        <path d="M12 22V12" />
                        <polyline points="3.29 7 12 12 20.71 7" />
                        <path d="m7.5 4.27 9 5.15" />
                    </svg>
                </span>
            </div>
            <div class="items-start sm:flex sm:flex-col">
                <p class="text-md text-gray-500 sm:text-sm">
                    Total Supplies
                </p>
                <p class="text-4xl font-semibold sm:text-2xl">
                    {{ $supplies }}
                </p>
            </div>
        </div>
    </a>

    <div class="rounded-md bg-gray-50 p-2">
        <div class="sm:justfiy-start flex items-center gap-6 p-6 sm:gap-3 sm:p-4">
            <div class="rounded-full bg-red-200 p-6 sm:p-2">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-red-500 sm:size-12" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-package-icon lucide-package">
                        <path
                            d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                        <path d="M12 22V12" />
                        <polyline points="3.29 7 12 12 20.71 7" />
                        <path d="m7.5 4.27 9 5.15" />
                    </svg>
                </span>
            </div>
            <div class="items-start sm:flex sm:flex-col">
                <p class="text-md text-gray-500 sm:text-sm">
                    Total Stocks
                </p>
                <p class="text-4xl font-semibold sm:text-2xl">
                    {{ $stocks }}
                </p>
            </div>
        </div>
    </div>
    <div class="rounded-md bg-gray-50 p-2">
        <div class="sm:justfiy-start flex items-center gap-6 p-6 sm:gap-3 sm:p-4">
            <div class="rounded-full bg-orange-200 p-6 sm:p-2">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-orange-500 sm:size-12" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-package-icon lucide-package">
                        <path
                            d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                        <path d="M12 22V12" />
                        <polyline points="3.29 7 12 12 20.71 7" />
                        <path d="m7.5 4.27 9 5.15" />
                    </svg>
                </span>
            </div>
            <div class="items-start sm:flex sm:flex-col">
                <p class="text-md text-gray-500 sm:text-sm">
                    Total Approved Request
                </p>
                <p class="text-4xl font-semibold sm:text-2xl">
                    0 </p>
            </div>
        </div>
    </div>
</div>

