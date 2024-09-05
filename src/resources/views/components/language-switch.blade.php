<form action="{{ route('language.switch') }}" method="POST" class="inline-block">
    @csrf
    <label>
        <select name="language" onchange="this.form.submit()" class="p-2 rounded bg-gray-100 text-gray-800">
            <option value="en" {{ app()->getLocale() ==='en' ? 'selected' : '' }}>English</option>
            <option value="de" {{ app()->getLocale() ==='de' ? 'selected' : '' }}>Deutsch</option>
        </select>
    </label>
</form>
