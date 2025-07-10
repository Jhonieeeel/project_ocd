 <!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>{{ config('app.name', 'Laravel') }}</title>

     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

     <!-- Scripts -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])

     @livewireStyles
 </head>

 <body class="font-sans antialiased">
     <div class="min-h-screen bg-gray-300">
         {{-- navbar --}}
         @livewire('components.navbar')

         <!-- Page Content -->
         <main class="container mx-auto w-full">
             <div class="min-h-screen sm:py-3 xl:py-6">
                 <div class="w-full rounded">
                     @if(!request()->routeIs('user-list'))
                     @livewire('components.total-cards')
                     @endif
                     {{ $slot }}
                 </div>
             </div>
         </main>
     </div>
     @livewireScripts
     <script>
         Livewire.on('print-docs', (data) => {
             const pdf = data[0].url;


             if (pdf) {
                 const win = window.open(pdf, '_blank');
                 if (win) {
                     win.onload = () => {
                         win.focus();
                         win.print();
                         console.log("Window")
                     };
                 } else {
                     alert('Popup blocked! Please allow popups for this site.');
                 }
             } else {
                 alert('PDF URL not available.');
                 console.error(data.error ?? 'Unknown error');
             }
         });
     </script>
 </body>

 </html>