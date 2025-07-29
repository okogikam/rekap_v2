<?php
include_once "../rot/function.php";
// Ganti URL dengan halaman yang ingin dicrawl
$url = "https://scholar.google.com/citations?view_op=view_citation&hl=id&user=-NsFG-gAAAAJ&citation_for_view=-NsFG-gAAAAJ:fbc8zXXH2BUC";

// Ambil konten HTML
$html = file_get_contents($url);

// Inisialisasi DOM dan load HTML
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Supaya gak error karena HTML yang tidak valid
$dom->loadHTML($html);
libxml_clear_errors();

// Ambil semua <a> (tautan)
$links = $dom->getElementsByTagName('a');
echo "Daftar Link:\n";
foreach ($links as $link) {
    $href = $link->getAttribute('href');
   // echo $href . "\n";
}

test($dom);

?>