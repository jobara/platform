<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        @include('partials.head')
    </head>
    <body>
        @include('layouts.banner')

        <!-- Main Content -->
        <main>
            <article class="wrapper flow" itemscope itemtype="https://schema.org/{{ $itemtype ?? 'WebPage' }}">
                <!-- Page Heading -->
                <header class="flow">
                    {{ $header }}
                </header>

                <!-- Page Content -->
                <div class="content flow">
                    {{ $slot }}
                </div>
            </article>
        </main>
    </body>
</html>
