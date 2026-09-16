document.addEventListener('DOMContentLoaded', function () {
    console.log('App JS loaded');

    document.querySelectorAll('.alert').forEach(function (alert) {
        setTimeout(function () {
            if (window.bootstrap) {
                bootstrap.Alert.getOrCreateInstance(alert).close();
            }
        }, 5000);
    });

    if (typeof DataTable === 'undefined') {
        console.error('DataTables belum tersedia.');
        return;
    }

    console.log('DataTables version:', DataTable.version);

    const tables = document.querySelectorAll('table.data-table');
    console.log('Jumlah tabel ditemukan:', tables.length);

    tables.forEach(function (table) {
        if (DataTable.isDataTable(table)) {
            console.log('DataTables sudah aktif:', table.id);
            return;
        }

        console.log('Initializing DataTables:', table.id);

        new DataTable(table, {
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            order: [],
            ordering: true,
            searching: true,
            paging: true,
            info: true,
            autoWidth: false,
            scrollX: true,
            language: {
                search: 'Cari:',
                searchPlaceholder: 'Ketik untuk mencari...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data.',
                paginate: {
                    first: 'Awal',
                    last: 'Akhir',
                    next: '›',
                    previous: '‹'
                }
            },
	layout: {
		topStart: {
			buttons: ['excel', 'print']
		}
	},
            columnDefs: [
                {
                    targets: 'no-sort',
                    orderable: false
                }
            ]
        });

        console.log('DataTables initialized:', table.id);
    });
});
