<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>مخطط الأسنان - {{ $patient->name }}</title>
<style>
body{
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(120deg, #f8f9fa, #e9ecef);
    margin:0;
    padding:0;
    display:flex;
    flex-direction:column;
    align-items:center;
}

header{
    width:100%;
    background:#007bff;
    color:white;
    padding:15px 0;
    text-align:center;
    box-shadow:0 4px 8px rgba(0,0,0,0.1);
    border-bottom-left-radius:10px;
    border-bottom-right-radius:10px;
}

header h1{
    margin:0;
    font-size:1.5rem;
    font-weight:700;
}

.dental-chart{
    background:white;
    padding:20px 10px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    margin:20px;
    width:100%;
    max-width:1000px;
    box-sizing:border-box;
}

.teeth-row{
    display:grid;
    grid-template-columns: repeat(16, 1fr);
    gap:10px;
    justify-items:center;
}

.tooth{
    width:50px;
    height:70px;
    border-radius:10px;
    background:#f1f3f5;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:flex-start;
    cursor:pointer;
    transition: all 0.3s ease;
    position: relative;
    box-shadow:0 3px 8px rgba(0,0,0,0.05);
}

.tooth img{
    width:100%;
    height:50px;
    object-fit:contain;
}

.tooth:hover{
    transform:scale(1.05);
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
}

.tooth.active, .tooth.has-procedure{
    background:#ff4d4d;
}

.tooth span{
    margin-top:3px;
    font-size:0.7rem;
    font-weight:600;
    color:#333;
}

.middle-line{
    height:3px;
    background:#dee2e6;
    margin:20px 0;
    border-radius:5px;
}

#proceduresTable{
    width:100%;
    border-collapse: collapse;
    margin-bottom:30px;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

#proceduresTable th, #proceduresTable td{
    border-bottom:1px solid #dee2e6;
    padding:10px 5px;
    text-align:center;
    font-size:0.8rem;
}

#proceduresTable th{
    background:#007bff;
    color:white;
    font-weight:600;
}

#proceduresTable tr:hover{
    background:#f1f3f5;
}

/* مودال */
#toothModal{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
    z-index:1000;
    width: 90%;
    max-width:350px;
}

#modalOverlay{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    z-index:900;
}

#toothModal h3{
    margin-bottom:10px;
    font-size:1.1rem;
    color:#007bff;
}

#toothModal div{
    margin-bottom:8px;
}

#toothModal input, #toothModal textarea{
    width:100%;
    padding:6px;
    border:1px solid #ced4da;
    border-radius:8px;
    box-sizing:border-box;
    font-size:0.9rem;
}

#toothModal button{
    padding:8px 12px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    margin-right:5px;
    font-size:0.9rem;
}

#toothModal button[type="submit"]{
    background:#007bff;
    color:white;
}

#toothModal button#closeModal{
    background:#6c757d;
    color:white;
}

/* ======== Media Queries ======== */
@media(max-width:1024px){
    .teeth-row{
        grid-template-columns: repeat(12, 1fr);
    }
}
@media(max-width:768px){

    .teeth-row{
        display:flex;
        overflow-x:auto;
        gap:10px;
        padding-bottom:10px;
    }

    .tooth{
        min-width:70px;
        height:90px;
        flex:0 0 auto;
    }

    .tooth img{
        height:65px;
    }

    .teeth-row::-webkit-scrollbar{
        height:6px;
    }

    .teeth-row::-webkit-scrollbar-thumb{
        background:#007bff;
        border-radius:10px;
    }

}
</style>
</head>
<body>

<header>
    <h1>مخطط الأسنان - {{ $patient->name }}</h1>
</header>

<div class="dental-chart">
    <!-- الفك العلوي -->
    <div class="teeth-row">
        @php
        $upper_teeth = [18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28];
        @endphp
        @foreach($upper_teeth as $tooth)
            @php
            $hasProcedure = $teethProcedures->where('tooth_number', $tooth)->count() > 0;
            @endphp
            <div class="tooth {{ $hasProcedure ? 'has-procedure' : '' }}" data-tooth="{{ $tooth }}">
                <img src="{{ asset('img/teeth/'.$tooth.'.png') }}">
                <span>{{ $tooth }}</span>
            </div>
        @endforeach
    </div>

    <div class="middle-line"></div>

    <!-- الفك السفلي -->
    <div class="teeth-row">
        @php
        $lower_teeth = [38,37,36,35,34,33,32,31,41,42,43,44,45,46,47,48];
        @endphp
        @foreach($lower_teeth as $tooth)
            @php
            $hasProcedure = $teethProcedures->where('tooth_number', $tooth)->count() > 0;
            @endphp
            <div class="tooth {{ $hasProcedure ? 'has-procedure' : '' }}" data-tooth="{{ $tooth }}">
                <img src="{{ asset('img/teeth/'.$tooth.'.png') }}">
                <span>{{ $tooth }}</span>
            </div>
        @endforeach
    </div>
</div>

<!-- جدول الإجراءات -->
<h2>سجل إجراءات الأسنان السابقة</h2>
<table id="proceduresTable">
    <thead>
        <tr>
            <th>رقم السن</th>
            <th>الإجراء الحالي</th>
            <th>ملاحظات</th>
            <th>الإجراء المخطط</th>
            <th>ملاحظات الزيارة القادمة</th>
            <th>طول العصب (w/l)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teethProcedures as $proc)
        <tr>
            <td>{{ $proc->tooth_number }}</td>
            <td>{{ $proc->procedure }}</td>
            <td>{{ $proc->notes }}</td>
            <td>{{ $proc->next_procedure }}</td>
            <td>{{ $proc->next_notes }}</td>
            <td>{{ $proc->w_l }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- المودال -->
<div id="modalOverlay"></div>
<div id="toothModal">
    <h3>تعديل الإجراء - سن: <span id="modalToothNumber"></span></h3>
    <form id="toothForm">
        <input type="hidden" name="tooth_number" id="formToothNumber">
        <div>
            <label>الإجراء الحالي:</label>
            <input type="text" name="procedure" id="formProcedure">
        </div>
        <div>
            <label>ملاحظات الإجراء الحالي:</label>
            <textarea name="notes" id="formNotes"></textarea>
        </div>
        <div>
            <label>الإجراء المخطط للزيارة القادمة:</label>
            <input type="text" name="next_procedure" id="formNextProcedure">
        </div>
        <div>
            <label>ملاحظات الزيارة القادمة:</label>
            <textarea name="next_notes" id="formNextNotes"></textarea>
        </div>
        <div>
            <label>طول العصب (w/l):</label>
            <input type="text" name="w_l" id="formWL">
        </div>
        <button type="submit">حفظ</button>
        <button type="button" id="closeModal">إغلاق</button>
    </form>
</div>

<script>
let teeth = document.querySelectorAll(".tooth");
let modal = document.getElementById("toothModal");
let overlay = document.getElementById("modalOverlay");
let closeModal = document.getElementById("closeModal");
let form = document.getElementById("toothForm");
let existing = @json($teethProcedures->keyBy('tooth_number'));

teeth.forEach(t => {
    t.addEventListener("click", () => {
        let toothNum = t.getAttribute('data-tooth');
        document.getElementById('modalToothNumber').textContent = toothNum;
        document.getElementById('formToothNumber').value = toothNum;

        if(existing[toothNum]){
            document.getElementById('formProcedure').value = existing[toothNum].procedure || '';
            document.getElementById('formNotes').value = existing[toothNum].notes || '';
            document.getElementById('formNextProcedure').value = existing[toothNum].next_procedure || '';
            document.getElementById('formNextNotes').value = existing[toothNum].next_notes || '';
            document.getElementById('formWL').value = existing[toothNum].w_l || '';
        } else {
            form.reset();
            document.getElementById('formToothNumber').value = toothNum;
        }

        modal.style.display = 'block';
        overlay.style.display = 'block';
    });
});

closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
    overlay.style.display = 'none';
});

form.addEventListener('submit', function(e){
    e.preventDefault();
    let formData = new FormData(form);
    let data = Object.fromEntries(formData.entries());

    fetch("/teeth/{{ $patient->id }}/update", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if(res.success){
            existing[data.tooth_number] = res.teethProcedure;
            modal.style.display = 'none';
            overlay.style.display = 'none';
            document.querySelector(`.tooth[data-tooth="${data.tooth_number}"]`).classList.add('has-procedure');

            let tbody = document.querySelector('#proceduresTable tbody');
            let row = `<tr>
                <td>${res.teethProcedure.tooth_number}</td>
                <td>${res.teethProcedure.procedure}</td>
                <td>${res.teethProcedure.notes}</td>
                <td>${res.teethProcedure.next_procedure}</td>
                <td>${res.teethProcedure.next_notes}</td>
                <td>${res.teethProcedure.w_l}</td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
        }
    });
});
</script>
</body>
</html>