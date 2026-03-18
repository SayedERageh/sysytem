<x-filament::page>
    @php
        $doctors = \App\Models\Doctor::take(3)->get();
    @endphp

    {{-- كروت الدكاترة --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        @foreach ($doctors as $doctor)
            <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4 hover:shadow-xl transition">
                {{-- صورة الدكتور --}}
                <img 
                    src="{{ $doctor->image ? asset($doctor->image) : 'https://via.placeholder.com/100' }}"
                    class="w-16 h-16 rounded-full object-cover"
                >

                <div class="flex-1">
                    <div class="font-bold text-lg">
                        👨‍⚕️ {{ $doctor->name }}
                    </div>

                    <div class="text-sm text-gray-500">
                        @if($doctor->working_hours)
                            {{ collect($doctor->working_hours)->take(2)->map(fn($h,$d)=>"$d: $h")->implode(' | ') }}
                        @else
                            لا توجد مواعيد
                        @endif
                    </div>

                    <a href="#" class="text-primary-600 text-sm mt-1 block">احجز الآن</a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- الكاليندر --}}

</x-filament::page>