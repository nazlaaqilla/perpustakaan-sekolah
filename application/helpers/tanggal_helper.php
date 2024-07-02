<?php
if (!function_exists('tanggal_indo')) {
    /**
     * Mengubah tanggal YYYY-MM-DD menjadi kalimat tanggal pada format kalender Indonesia
     * 
     * @param string $tanggal
     * @return string
     */
    function tanggal_indo($tanggal = '1900-01-01')
    {
        $bulan = array(
            '',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $array = explode('-', $tanggal);
        return $array[2] . ' ' . $bulan[(int)$array[1]] . ' ' . $array[0];
    }
}
