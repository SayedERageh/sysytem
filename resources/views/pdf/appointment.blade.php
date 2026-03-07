<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>روشتة علاجية - {{ $appointment->patient->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        @media print {
            #print-button {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Print Button -->
    <div class="text-center my-6">
        <button id="print-button" onclick="window.print()" 
            class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-900 transition font-bold">
            طباعة الروشتة
        </button>
    </div>

    <!-- Container -->
    <div class="max-w-5xl mx-auto bg-white p-8 shadow-xl rounded-xl">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center border-b-4 border-blue-700 pb-4 mb-6">
            <img src="{{ asset('img/logo.jpg') }}" alt="شعار العيادة" class="w-28 h-auto mb-4 md:mb-0">
            <div class="text-right">
                <h2 class="text-3xl font-bold text-blue-700">عيادات أسنان مصر</h2>
                <p class="text-gray-700 mt-1">فروعنا: الدقي - فيصل - المهندسين - أكتوبر - حدائق الأهرام</p>
                <p class="text-gray-700">التجمع الخامس - مدينة نصر</p>
                <p class="text-gray-700 mt-1">📞 لخدمة العملاء: 01022558536</p>
            </div>
        </div>

        <!-- Patient Info -->
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-8 shadow-md">
            <h3 class="text-center text-blue-700 font-bold text-xl mb-5 border-b-2 border-blue-700 pb-2">
                بيانات المريض
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800">
                <div class="space-y-2">
                    <p><span class="font-semibold">اسم المريض:</span> {{ $appointment->patient->name }}</p>
                    <p><span class="font-semibold">تاريخ الميلاد:</span> {{ $appointment->patient->birthdate ?? '-' }}</p>
                    <p><span class="font-semibold">رقم الهاتف:</span> {{ $appointment->patient->phone ?? '-' }}</p>
                    <p><span class="font-semibold">رقم الملف:</span> {{ $appointment->patient->file_number ?? '-' }}</p>
                </div>
                <div class="space-y-2">
                    <p><span class="font-semibold">رقم التأمين:</span> {{ $appointment->patient->insurance_number ?? '-' }}</p>
                    <p><span class="font-semibold">شركة التأمين:</span> {{ $appointment->patient->company->name ?? '-' }}</p>
                    <p><span class="font-semibold">العمر:</span> {{ $appointment->patient->age ?? '-' }}</p>
                    <p><span class="font-semibold">المبلغ المتبقي:</span> {{ number_format($appointment->patient->remaining_amount, 2) }} EGP</p>
                </div>
            </div>
        </div>

        <!-- Appointment / Payment Table -->
        <div class="overflow-x-auto mb-8 shadow-md rounded-lg">
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="border px-4 py-3">الخدمة / الحجز</th>
                        <th class="border px-4 py-3">الطبيب</th>
                        <th class="border px-4 py-3">المدفوع (EGP)</th>
                        <th class="border px-4 py-3">المتبقي (EGP)</th>
                    </tr>
                </thead>
                <tbody class="text-center bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-4 py-2">{{ $appointment->service_name }}</td>
                        <td class="border px-4 py-2">{{ $appointment->doctor->name }}</td>
                        <td class="border px-4 py-2">{{ number_format($appointment->paid, 2) }}</td>
                        <td class="border px-4 py-2">{{ number_format($appointment->remaining, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer / Contact Info -->
        <div class="bg-blue-700 text-white rounded-b-xl p-6 text-center text-sm space-y-2">
            <p>📱 <strong>واتساب:</strong> <a href="https://wa.me/201120112231" target="_blank" class="underline text-white">01120112231</a></p>
            <p>📞 <strong>اتصال مباشر:</strong> 01022558536</p>
            <p>🔵 <strong>فيسبوك:</strong> اسنان مصر دكتور باسم لاشين</p>
            <p class="mt-2 font-bold text-lg">90 مليون ضحكة</p>
        </div>

    </div>

</body>
</html>