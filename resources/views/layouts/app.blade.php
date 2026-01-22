<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SocialApp') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/social.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#13111c] text-gray-100">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="pb-20 sm:pb-0">
                {{ $slot }}
            </main>
        </div>

        <!-- Like functionality script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle like forms with AJAX
                document.querySelectorAll('.like-form').forEach(form => {
                    form.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        
                        const btn = this.querySelector('.like-btn');
                        const svg = btn.querySelector('svg');
                        
                        try {
                            const response = await fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            });
                            
                            const data = await response.json();
                            
                            if (data.liked) {
                                btn.classList.remove('text-gray-300');
                                btn.classList.add('text-pink-500');
                                svg.setAttribute('fill', 'currentColor');
                            } else {
                                btn.classList.remove('text-pink-500');
                                btn.classList.add('text-gray-300');
                                svg.setAttribute('fill', 'none');
                            }
                            
                            // Update likes count if present
                            const likesCount = this.closest('article, .post-card')?.querySelector('.likes-count');
                            if (likesCount) {
                                likesCount.textContent = data.count + ' ' + (data.count === 1 ? 'like' : 'likes');
                            }
                        } catch (error) {
                            // Fallback to regular form submission if AJAX fails
                            this.submit();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
