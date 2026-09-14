document.addEventListener('DOMContentLoaded', function () {

    console.log('App JS loaded');

    // =========================
    // Bootstrap Alert
    // =========================
    document.querySelectorAll('.alert').forEach(function (alert) {

        setTimeout(function () {

            if (window.bootstrap) {
                bootstrap.Alert
                    .getOrCreateInstance(alert)
                    .close();
            }

        }, 5000);

    });


    // =========================
    // DataTables
    // =========================

    if (typeof DataTable === 'undefined') {

        console.error('DataTables belum tersedia.');

        return;
    }


    console.log(
        'DataTables version:',
        DataTable.version
    );


    const configs = [

        {
            id: '#dosenTable',
            empty: 'Belum ada data dosen.'
        },

        {
            id: '#mahasiswaTable',
            empty: 'Belum ada data mahasiswa.'
        }

    ];


    configs.forEach(function (config) {

        const table = document.querySelector(config.id);


        if (!table) {

            console.log(
                'Tabel tidak ditemukan:',
                config.id
            );

            return;
        }


        console.log(
            'Tabel ditemukan:',
            config.id
        );


        // ==========================================
        // PENTING:
        // Jangan inisialisasi DataTables dua kali
        // ==========================================

        if (DataTable.isDataTable(table)) {

            console.log(
                'DataTables sudah aktif:',
                config.id
            );

            return;
        }


        console.log(
            'Initializing DataTables:',
            config.id
        );


        new DataTable(table, {

            // =========================
            // Pagination
            // =========================

            pageLength: 25,

            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],


            // =========================
            // Features
            // =========================

            paging: true,

            searching: true,

            ordering: true,

            info: true,

            autoWidth: false,

            scrollX: true,


            // Jangan sorting otomatis
            order: [],
            // =========================
            // Tombol export
            // =========================
	layout: {
		topStart: {
			buttons: [{
					text: 'JSON',
					action: function (e, dt, button, config) {
						var data = dt.buttons.exportData();

						DataTable.fileSave(new Blob([JSON.stringify(data)]), 'Export.json');
					}
				}, 'excel', 'print']
		}
	},

            // =========================
            // Bahasa Indonesia
            // =========================

            language: {

                search: 'Cari:',

                searchPlaceholder:
                    'Ketik untuk mencari...',

                lengthMenu:
                    'Tampilkan _MENU_ data',

                info:
                    'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',

                infoEmpty:
                    'Tidak ada data',

                zeroRecords:
                    'Data tidak ditemukan',

                emptyTable:
                    config.empty,

                paginate: {

                    first: 'Awal',

                    last: 'Akhir',

                    next: '›',

                    previous: '‹'

                }

            },


            // =========================
            // Kolom Aksi
            // =========================

            columnDefs: [

                {
                    targets: 'no-sort',
                    orderable: false
                }

            ]

        });


        console.log(
            'DataTables initialized:',
            config.id
        );

    });

});