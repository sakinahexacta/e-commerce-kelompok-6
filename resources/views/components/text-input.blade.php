@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-pink-300 border-none focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
