@props([
    'level' => 3,
    'model' => null,
])

<x-card class="resource-collection" title-class="h3">
    <x-slot name="title"><a href="{{ localized_route('resource-collections.show', $model) }}">{{ $model->title }}</a>
    </x-slot>
    <p><strong>{{ __('Collection') }}</strong></p>
    {!! Str::markdown($model->description) !!}
</x-card>