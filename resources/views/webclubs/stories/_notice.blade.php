@if(session('message'))
    <div role="status" class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4 text-green-900">{{ session('message') }}</div>
@endif
@if($errors->any())
    <div role="alert" class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4 text-red-900">
        <p class="font-semibold">Revisa los datos del formulario:</p>
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
