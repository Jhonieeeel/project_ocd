<div class="h-auto w-full p-6 sm:p-3">
    @if (auth()->user()->hasAnyRole(['super-admin', 'admin']))
        <p class="py-3 text-2xl font-bold">Users Request list</p>
    @else
        <p class="py-3 text-2xl font-bold">My Request list</p>
    @endif
    <div class="rounded-md bg-gray-50 p-6">
        @livewire('components.request-table', ['lazy' => true])
    </div>
</div>

