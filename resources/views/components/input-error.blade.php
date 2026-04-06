@props(['messages'])

{{--
    Seguridad: El HTML de los mensajes de error proviene del backend (no del usuario),
    por lo que es seguro renderizarlo con {!! $message !!} para permitir enlaces y formato.
--}}

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{!! $message !!}</li>
        @endforeach
    </ul>
@endif
