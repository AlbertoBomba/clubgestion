<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label for="author_name" class="block font-semibold mb-2">Tu nombre público</label>
        <input id="author_name" name="author_name" value="{{ old('author_name') }}" required maxlength="100" autocomplete="name" class="w-full rounded-lg border-gray-300">
    </div>
    <div>
        <label for="author_email" class="block font-semibold mb-2">Correo electrónico (no se publicará)</label>
        <input id="author_email" name="author_email" type="email" value="{{ old('author_email') }}" required maxlength="255" autocomplete="email" class="w-full rounded-lg border-gray-300">
    </div>
</div>
<div hidden aria-hidden="true">
    <label for="website">Deja este campo vacío</label>
    <input id="website" name="website" tabindex="-1" autocomplete="off">
</div>
