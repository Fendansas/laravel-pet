<div>
    <label class="block text-sm font-medium">Имя*</label>
    <input type="text" name="name" class="w-full border rounded p-2"
           value="{{ old('name', $participant->name ?? '') }}" required>
</div>

<div>
    <label class="block text-sm font-medium">Email</label>
    <input type="email" name="email" class="w-full border rounded p-2"
           value="{{ old('email', $participant->email ?? '') }}">
</div>

<div>
    <label class="block text-sm font-medium">Телефон</label>
    <input type="text" name="phone" class="w-full border rounded p-2"
           value="{{ old('phone', $participant->phone ?? '') }}">
</div>

<div>
    <label class="block text-sm font-medium">Должность</label>
    <input type="text" name="position" class="w-full border rounded p-2"
           value="{{ old('position', $participant->position ?? '') }}">
</div>

<div>
    <label class="block text-sm font-medium">Заметки</label>
    <textarea name="notes" class="w-full border rounded p-2">{{ old('notes', $participant->notes ?? '') }}</textarea>
</div>
