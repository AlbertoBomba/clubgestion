@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-silver focus:border-primary focus:ring-primary rounded-md shadow-sm']) !!}>
