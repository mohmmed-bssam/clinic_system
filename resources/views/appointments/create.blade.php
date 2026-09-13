<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Book an appointment</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('status') === 'appointment-created')
                <div class="mb-4 rounded-md bg-green-50 p-4 text-green-700">Your appointment request was created
                    successfully.</div>
            @endif
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor</label>
                        <select id="doctor_id" name="doctor_id" class="mt-1 block w-full rounded-md border-gray-300"
                            required>
                            <option value="">Choose a doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>
                                    {{ $doctor->name }}{{ $doctor->department ? ' - ' . $doctor->department->name : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="appointment_at" class="block text-sm font-medium text-gray-700">Date and
                            time</label>
                        <input id="appointment_at" name="appointment_at" type="datetime-local"
                            value="{{ old('appointment_at') }}" class="mt-1 block w-full rounded-md border-gray-300"
                            required>
                        @error('appointment_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-white">Request
                        appointment</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
