document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('excelFile');
    const entity = document.getElementById('entity');
    const previewBtn = document.getElementById('previewBtn');
    const importBtn = document.getElementById('importBtn');
    const previewArea = document.getElementById('previewArea');
    const table = document.getElementById('previewTable');
    const status = document.getElementById('validationStatus');
    const message = document.getElementById('validationMessage');

    if (!previewBtn) return;

    previewBtn.addEventListener('click', () => {
        const file = fileInput.files[0];
        if (!file) {
            alert('Pilih file terlebih dahulu.');
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            try {
                const wb = XLSX.read(e.target.result, {type:'array'});
                const ws = wb.Sheets[wb.SheetNames[0]];
                const rows = XLSX.utils.sheet_to_json(ws, {header:1, defval:''});
                if (!rows.length) throw new Error('Sheet kosong.');

                const headers = rows[0].map(v => String(v).trim());
                const required = entity.value === 'dosen' ? ['NIDN','NAMA'] : ['NIM','NAMA'];
                const missing = required.filter(x => !headers.includes(x));

                table.innerHTML = '';
                const head = document.createElement('thead');
                const tr = document.createElement('tr');
                headers.forEach(h => { const th=document.createElement('th'); th.textContent=h; tr.appendChild(th); });
                head.appendChild(tr); table.appendChild(head);

                const body=document.createElement('tbody');
                rows.slice(1,11).forEach(row=>{
                    const tr=document.createElement('tr');
                    headers.forEach((_,i)=>{const td=document.createElement('td');td.textContent=row[i]??'';tr.appendChild(td)});
                    body.appendChild(tr);
                });
                table.appendChild(body);

                previewArea.classList.remove('d-none');

                if (missing.length) {
                    status.className='badge text-bg-danger';
                    status.textContent='Tidak valid';
                    message.innerHTML='<div class="alert alert-danger mb-0">Kolom wajib tidak ditemukan: <b>'+missing.join(', ')+'</b></div>';
                    importBtn.classList.add('d-none');
                    return;
                }

                status.className='badge text-bg-success';
                status.textContent='Valid';
                message.innerHTML='<div class="alert alert-success mb-0">Struktur kolom valid. Menampilkan maksimal 10 baris pertama untuk preview.</div>';
                importBtn.classList.remove('d-none');

                // For XLSX/XLS, convert the workbook to CSV so the PHP backend
                // can process it without requiring an additional PHP spreadsheet library.
                if (!file.name.toLowerCase().endsWith('.csv')) {
                    const csv = XLSX.utils.sheet_to_csv(ws);
                    const blob = new Blob([csv], {type:'text/csv'});
                    const converted = new File([blob], 'converted-import.csv', {type:'text/csv'});
                    const dt = new DataTransfer();
                    dt.items.add(converted);
                    fileInput.files = dt.files;
                }
            } catch(err) {
                previewArea.classList.remove('d-none');
                status.className='badge text-bg-danger';
                status.textContent='Error';
                message.innerHTML='<div class="alert alert-danger mb-0">'+err.message+'</div>';
                importBtn.classList.add('d-none');
            }
        };
        reader.readAsArrayBuffer(file);
    });
});
