<template>
    <Cover :procurement="procurement" type="SPK">
        <div class="flex tex-center">
            <img :src="'/image/logoitera.png'" class="w-28">
            <div class="text-center">
                <div class="text-lg font-bold">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
                <div class="text-base font-bold">INSTITUT TEKNOLOGI SUMATERA</div>
                <div class="text-xs">Jalan Terusan Ryacudu Way Hui, Kecamatan Jati Agung, Lampung Selatan 35365</div>
                <div class="text-xs">Telepon: (0721) 8030188</div>
                <div class="text-xs">Email: pusat@itera.ac.id Website: http://itera.ac.id</div>
            </div>
        </div>
        <div class="text-center font-bold text-2xl mt-10 mb-20">Surat Perintah Kerja (SPK)</div>
        <div class="flex mx-10 border-2 font-bold items-center justify-items-center text-justify">
            <div class="w-5/12 text-center">
                SURAT PERINTAH KERJA (SPK)
            </div>
            <div class="flex flex-col flex-grow">
                <div class="border-l-2 border-b-2 px-2 ">
                    <span>SATUAN KERJA:</span> 
                    <div class="mt-2 mb-3 text-sm font-normal">
                        677540-INSTITUT TEKNOLOGI SUMATERA
                    </div>
                </div>
                <div class="border-l-2 px-2">
                    <span >NOMOR DAN TANGGAL SPK:</span> 
                    <div class=" mt-2 mb-3 text-sm font-normal">
                        No. {{procurement.contract.no_spk}} Tanggal: {{moment(procurement.contract.date_start_spk, 'YYYY-MM-DD').format('DD-MM-YYYY')}}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex mx-10 border-2  items-center justify-items-center text-justify">
            <div class="w-5/12 text-center font-bold">
                Paket Pekerjaan:
            </div>
            <div class="flex flex-col w-7/12">
                <div class="border-l-2 border-b-2 px-2 flex-1">
                    <span class="font-bold">NOMOR DAN TANGGAL BERITA ACARA HASIL PENGADAAN LANGSUNG:</span> 
                    <div class="mt-2 mb-3 text-sm">
                        Nomor :  {{procurement.contract.no_bahp}} Tanggal : {{moment(procurement.contract.date_bahp).format('DD-MM-yy')}}
                    </div>
                </div>
                <div class="border-l-2 px-2 flex-1" >
                    <div class=" mt-2 mb-3 text-sm">
                        SPK ini mulai berlaku efektif terhitung sejak tanggal diterbitkannya SPMK dan penyelesaian keseluruhan pekerjaan sebagaimana diatur dalam SPK ini.
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-10 border-2 text-justify px-2 pb-3">
            <div class="mt-2 mb-5 font-bold">SUMBER DANA:</div>
            <div>
                Surat Perintah Kerja (SPK) ini dibiayai dari sumber dana APBN Institut Teknologi Sumatera dengan kode akun kegiatan {{procurement.account}}. 
                Pembayaran ditransfer ke rekening {{supplier.bank}} dengan nomer rekening {{supplier.account}} Atas
                Nama <span class="">{{supplier.name}}</span>
            </div>
        </div>
        <div class="mx-10 border-2 text-justify px-2 pb-3">
            <div class="mt-2 mb-5 font-bold">WAKTU PELAKSANAAN PEKERJAAN:</div>
            <div class="col-span-3 ">{{procurement.contract.days}} ({{angkaTerbilang(procurement.contract.days)}}) Hari Kalender ({{moment(procurement.contract.date_start_spk, 'YYYY-MM-DD').format('DD-MM-YYYY')}} s/d {{moment(procurement.contract.date_end_spk, 'YYYY-MM-DD').format('DD-MM-YYYY')}})</div>
        </div>
        <!-- <div id="nilai"></div> -->
        <!-- <div class="mx-10 border-2 text-justify px-2 pb-3 mt-10" >
            <div class="mt-2 mb-5 font-bold text-center ">NILAI PEKERJAAN</div>
        </div>
        <div class="mx-10 border-2 flex">
            <span class="text-secondary border-r-2 pb-3 mr-2">No</span>
            <span class="text-secondary border-r-2 pb-3 mr-2">Uraian Pekerjaan</span>
            <span class="text-secondary border-r-2 pb-3 mr-2">Kuantitas</span>
            <span class="text-secondary border-r-2 pb-3 mr-2">Satuan Ukuran</span>
            <span class="text-secondary border-r-2 pb-3 mr-2">Harga Satuan (Rp.)</span>
            <span class="text-secondary">Total (Rp.)</span>
        </div>
        <div class="mx-10 border-2 flex flex-wrap text-secondary">
            <div class="pb-3 pl-2 w-9/12">Jumlah</div>
            <div class="pb-3 pl-2 w-3/12 border-l-2">8989898989</div>
            <div class="pb-3 pl-2 w-9/12 border-y-2">PPN 11%</div>
            <div class="pb-3 pl-2 w-3/12 border-y-2 border-l-2">8989899</div>
            <div class="pb-3 pl-2 w-9/12">Nilai</div>
            <div class="pb-3 pl-2 w-3/12 border-l-2">8989899</div>
        </div>
        <div class="mx-10 border-2 flex flex-wrap text-secondary pb-3 px-2">
            <div class="mt-2 mb-5 font-bold">WAKTU PELAKSANAAN PEKERJAAN:</div>
            delapan puluh delapan juta tujuh ratus tiga puluh ribu
        </div> -->
        <div class="mx-10 border-2 pb-3 px-2 text-justify">
            <div class="mt-2 mb-5 font-bold">INSTRUKSI KE PENYEDIA :</div>
            Penagihan hanya dapat dilakukan setelah penyelesaian pekerjaan yang diperintahkan dalam SPK ini dan dibuktikan dengan Berita Acara Serah Terima. Jika pekerjaan tidak dapat diselesaikan dalam jangka waktu pelaksanaan pekerjaan karena kesalahan atau kelalaian Penyedia maka Penyedia berkewajiban untuk membayar denda kepada PPK sebesar 1/1000 (satu per seribu) dari nilai SPK untuk setiap hari keterlambatan.        
        </div>
        <div id="signature"></div>

        <div class="mx-10 border-2 pb-3 px-2 text-center flex">
            <div class="w-6/12 border-r-2 flex flex-col justify-between">
                <div>
                    <div>Untuk Dan Atas Nama</div>
                    <div>Institut Teknologi Sumatera</div>
                    <div>Pejabat Pembuat Komitmen</div>
                </div>
                <div>
                    <div class="">{{procurement.executor.ppk.name}}</div>
                    <div class="">{{procurement.executor.ppk.identity_type}}. {{procurement.executor.ppk.identity_number}}</div>
                </div>
            </div>
            <div class="flex-grow flex flex-col justify-between">
                <div>
                    <div>Untuk Dan Atas Nama Penyedia</div>
                    <div>{{procurement.suppliers.name}}</div>
                </div>
                <div>
                    <div class="mt-36 ">{{procurement.suppliers.pic}}</div>
                    <div class="">{{procurement.suppliers.pic_position}}</div>
                </div>
            </div>
        </div>
        <div id="rule"></div>
        <div class="mx-10 text-justify">
            <div class="newpage text-center text-2xl font-bold">Syarat Umum</div>
            <div class="text-center text-2xl font-bold">Surat Perintah Kerja (SPK)</div>

            <div class="font-bold text-lg mt-10">1. LINGKUP PEKERJAAN</div>
            <div >Penyedia yang ditunjuk berkewajiban untuk menyelesaikan pekerjaan dalam jangka waktu yang ditentukan, sesuai dengan volume, spesifikasi teknis dan harga yang tercantum dalam SPK dan lampiran SPK.</div>

            <div class="font-bold text-lg mt-10">2. HUKUM YANG BERLAKU</div>
            <div >Keabsahan, interpretasi, dan pelaksanaan SPK ini didasarkan kepada hukum Republik Indonesia.</div>
            
            <div class="font-bold text-lg mt-10">3. HARGA SPK</div>
            <div class="flex ml-3">
                <div>a.</div>
                <div class="pl-3">PPK membayar kepada penyedia atas pelaksanaan pekerjaan dalam SPK sebesar harga SPK.</div>
            </div>
            <div class="flex ml-3">
                <div>b.</div>
                <div class="pl-3">Harga SPK telah memperhitungkan keuntungan, beban pajak dan biaya overhead serta biaya asuransi (apabila dipersyaratkan).</div>
            </div>
            <div class="flex ml-3">
                <div>c.</div>
                <div class="pl-3">Rincian harga SPK sesuai dengan rincian yang tercantum dalam daftar kuantitas dan harga.</div>
            </div>

            <div class="font-bold text-lg mt-10">4. HAK KEPEMILIKAN</div>
            <div class="flex ml-3">
                <div>a.</div>
                <div class="pl-3">PPK berhak atas kepemilikan semua barang/bahan yang terkait langsung atau disediakan sehubungan dengan jasa yang diberikan oleh penyedia kepada PPK. Jika diminta oleh PPK maka penyedia berkewajiban untuk membantu secara optimal pengalihan hak kepemilikan tersebut kepada PPK sesuai dengan hukum yang berlaku.</div>
            </div>
            <div class="flex ml-3">
                <div>b.</div>
                <div class="pl-3">Hak kepemilikan atas peralatan dan barang/bahan yang disediakan oleh PPK tetap pada PPK, dan semua peralatan tersebut harus dikembalikan kepada PPK pada saat SPK berakhir atau jika tidak diperlukan lagi oleh penyedia. Semua peralatan tersebut harus dikembalikan dalam kondisi yang sama pada saat diberikan kepada penyedia dengan pengecualian keausan akibat pemakaian yang wajar.</div>
            </div>

            <div class="font-bold text-lg mt-10">5. CACAT MUTU</div>
            <div>PPK akan memeriksa setiap hasil pekerjaan penyedia dan memberitahukan secara tertulis penyedia atas setiap cacat mutu yang ditemukan. PPK dapat memerintahkan penyedia untuk menemukan dan mengungkapkan cacat mutu, serta menguji pekerjaan yang dianggap oleh PPK mengandung cacat mutu. Penyedia bertanggung jawab atas cacat mutu selama 6 (enam) bulan setelah serah terima hasil pekerjaan.</div>

            <div class="font-bold text-lg mt-10">6. PERPAJAKAN</div>
            <div>Penyedia berkewajiban untuk membayar semua pajak, bea, retribusi, dan pungutan lain yang sah yang dibebankan oleh hukum yang berlaku atas pelaksanaan SPK. Semua pengeluaran perpajakan ini dianggap telah termasuk dalam harga SPK.</div>

            <div class="font-bold text-lg mt-10">7. PENGALIHAN DAN/ATAU SUBKONTRAK</div>
            <div>Penyedia dilarang untuk mengalihkan dan/atau mensubkontrakkan sebagian atau seluruh pekerjaan, kecuali kepada penyedia spesialis untuk bagian pekerjaan tertentu. Pengalihan seluruh pekerjaan hanya diperbolehkan dalam hal pergantian nama penyedia, baik sebagai akibat peleburan (merger) atau akibat lainnya.</div>
            
            <div class="font-bold text-lg mt-10">8. JADWAL</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">SPK ini berlaku efektif pada tanggal penandatanganan oleh para pihak atau pada tanggal yang ditetapkan dalam SP.</li>
                <li class="pl-3">Waktu pelaksanaan SPK adalah sejak tanggal mulai kerja yang tercantum dalam SP.</li>
                <li class="pl-3">Penyedia harus menyelesaikan pekerjaan sesuai jadwal yang ditentukan.</li>
                <li class="pl-3">Apabila penyedia berpendapat tidak dapat menyelesaikan pekerjaan sesuai jadwal karena keadaan diluar pengendaliannya dan penyedia telah melaporkan kejadian tersebut kepada PPK, maka PPK dapat melakukan penjadwalan kembali pelaksanaan tugas penyediadengan adendum SPK.</li>
            </ol >
            
            <div class="font-bold text-lg mt-10">9. ASURANSI</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Apabila dipersyaratkan, penyedia wajib menyediakan asuransi sejak SPMK sampai dengan tanggal selesainya pemeliharaan untuk:
                    <ol class="list-decimal ml-5">
                        <li class="pl-3">semua barang dan peralatan yang mempunyai risiko tinggi terjadinya kecelakaan, pelaksanaan pekerjaan, serta pekerja untuk pelaksanaan pekerjaan, atas segala risiko terhadap kecelakaan, kerusakan, kehilangan, serta risiko lain yang tidak dapat diduga;</li>
                        <li class="pl-3">pihak ketiga sebagai akibat kecelakaan di tempat kerjanya; dan</li>
                    </ol>
                </li>
                <li class="pl-3">Besarnya asuransi sudah diperhitungkan dalam penawaran dan termasuk dalam harga SPK.</li>
            </ol >
            
            <div class="font-bold text-lg mt-10 ">10. PENANGGUNGAN DAN RISIKO</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Penyedia berkewajiban untuk melindungi, membebaskan, dan menanggung tanpa batas PPK beserta instansinya terhadap semua bentuk tuntutan, tanggung jawab, kewajiban, kehilangan, kerugian, denda, gugatan atau tuntutan hukum, proses pemeriksaan hukum, dan biaya yang dikenakan terhadap PPK beserta instansinya (kecuali kerugian yang mendasari tuntutan tersebut disebabkan kesalahan atau kelalaian berat PPK) sehubungan dengan klaim yang timbul dari hal-hal berikut terhitung sejak Tanggal Mulai Kerja sampai dengan tanggal penandatanganan berita acara penyerahan akhir:
                    <ol class="list-decimal ml-5">
                        <li class="pl-3">kehilangan atau kerusakan peralatan dan harta benda penyedia dan Personil;</li>
                        <li class="pl-3">cidera tubuh, sakit atau kematian Personil;</li>
                        <li class="pl-3">kehilangan atau kerusakan harta benda, dan cidera tubuh, sakit atau kematian pihak ketiga;</li>
                    </ol>
                </li>
                <li class="pl-3">Terhitung sejak Tanggal Mulai Kerja sampai dengan tanggal penandatanganan berita acara penyerahan awal, semua risiko kehilangan atau kerusakan Hasil Pekerjaan ini,Bahan dan Perlengkapan merupakan risiko penyedia, kecuali kerugian atau kerusakan tersebut diakibatkan oleh kesalahan atau kelalaian PPK.</li>
                <div class="break"></div>
                <li class="pl-3 ">Pertanggungan asuransi yang dimiliki oleh penyedia tidak membatasi kewajiban penanggungan dalam syarat ini.</li>
                <li class="pl-3 ">Kehilangan atau kerusakan terhadap Hasil Pekerjaan atau Bahan yang menyatu dengan Hasil Pekerjaan selama Tanggal Mulai Kerja dan batas akhir Masa Pemeliharaan harus diganti atau diperbaiki oleh penyedia atas tanggungannya sendiri jika kehilangan atau kerusakan tersebut terjadi akibat tindakan atau kelalaian penyedia.</li>
            </ol >

            <div class="font-bold text-lg mt-10">11. PENGAWASAN DAN PEMERIKSAAN</div>
            <div>PPK berwenang melakukan pengawasan dan pemeriksaan terhadap pelaksanaan pekerjaan yang dilaksanakan oleh penyedia. Apabila diperlukan, PPK dapat memerintahkan kepada pihak ketiga untuk melakukan pengawasan dan pemeriksaan atas semua pelaksanaan pekerjaan yang dilaksanakan oleh penyedia.</div>
            
            <div class="font-bold text-lg mt-10">12. PENGUJIAN</div>
            <div>Jika PPK atau Pengawas Pekerjaan memerintahkan penyedia untuk melakukan pengujian Cacat Mutu yang tidak tercantum dalam Spesifikasi Teknis dan Gambar, dan hasil uji coba menunjukkan adanya Cacat Mutu maka penyedia berkewajiban untuk menanggung biaya pengujian tersebut. Jika tidak ditemukan adanya Cacat Mutu maka uji coba tersebut dianggap sebagai Peristiwa Kompensasi.</div>
            
            <div class="font-bold text-lg mt-10">13. LAPORAN HASIL PEKERJAAN</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Pemeriksaan pekerjaan dilakukan selama pelaksanaan SPK untuk menetapkan volume pekerjaan atau kegiatan yang telah dilaksanakan guna pembayaran hasil pekerjaan. Hasil pemeriksaan pekerjaan dituangkan dalam laporan kemajuan hasil pekerjaan.</li>
                <li class="pl-3">Untuk merekam kegiatan pelaksanaan kegiatan, PPK dapat menugaskan Pejabat Pemeriksa Hasil Pekerjaan membuat foto-foto dokumentasi pelaksanaan pekerjaan dilokasi pekerjaan.</li>
            </ol >

            <div class="font-bold text-lg mt-10">14. WAKTU PENYELESAIAN PEKERJAAN</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Kecuali SPK diputuskan lebih awal, penyedia berkewajiban untuk memulai pelaksanaan pekerjaan pada Tanggal Mulai Kerja, dan melaksanakan pekerjaan sesuai dengan program mutu, serta menyelesaikan pekerjaan selambat-lambatnya pada Tanggal Penyelesaian yang ditetapkan dalam SPMK.</li>
                <li class="pl-3">Jika pekerjaan tidak selesai pada Tanggal Penyelesaian bukan akibat Keadaan Kahar atau Peristiwa Kompensasi atau karena kesalahan atau kelalaian penyedia maka penyedia dikenakan denda.</li>
                <li class="pl-3">Jika keterlambatan tersebut semata-mata disebabkan oleh Peristiwa Kompensasi maka PPK dikenakan kewajiban pembayaran ganti rugi. Denda atau ganti rugi tidak dikenakan jika Tanggal Penyelesaian disepakati oleh Para Pihak untuk diperpanjang.</li>
                <li class="pl-3">Tanggal Penyelesaian yang dimaksud dalam ketentuan ini adalah tanggal penyelesaian semua pekerjaan.</li>
            </ol >

            <div class="font-bold text-lg break">15. SERAH TERIMA PEKERJAAN</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Setelah pekerjaan selesai 100% (seratus perseratus), penyedia mengajukan permintaan secara tertulis kepada PPK untuk penyerahan pekerjaan.</li>
                <li class="pl-3">Dalam rangka penilaian hasil pekerjaan, PPK menugaskan Pejabat Pemeriksa Hasil Pekerjaan.</li>
                <li class="pl-3">Pejabat Penerima Hasil Pekerjaan melakukan penilaian terhadap hasil pekerjaan yang telah diselesaikan oleh penyedia. Apabila terdapat kekurangan-kekurangan dan/atau cacat hasil pekerjaan, penyedia wajib memperbaiki/menyelesaikannya, atas perintah PPK.</li>
                <li class="pl-3">PPK menerima penyerahan pertama pekerjaan setelah seluruh hasil pekerjaan dilaksanakan sesuai dengan ketentuan SPK dan diterima oleh Pejabat Penerima Hasil Pekerjaan.</li>
                <li class="pl-3">Pembayaran dilakukan sebesar 100% (seratus perseratus) dari harga SPK dan penyedia harus menyerahkan Sertifikat Garansi sebesar 5% (lima perseratus) dari harga SPK.</li>
            </ol >

            <div class="font-bold text-lg mt-10">16. JAMINAN BEBAS CACAT MUTU/GARANSI</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Penyedia dengan jaminan pabrikan dari produsen pabrikan (jika ada) berkewajiban untuk menjamin bahwa selama penggunaan secara wajar oleh PPK, Barang tidak mengandung cacat mutu yang disebabkan oleh tindakan atau kelalaian Penyedia, atau cacat mutuakibat desain, bahan, dan cara kerja.</li>
                <li class="pl-3">Jaminan bebas cacat mutu ini berlaku sampai dengan 12 (dua belas) bulan setelah serah terima Barang.</li>
                <li class="pl-3">PPK akan menyampaikan pemberitahuan cacat mutu kepada Penyedia segera setelah ditemukan cacat mutu tersebut selama Masa Layanan Purnajual.</li>
                <li class="pl-3">Terhadap pemberitahuan cacat mutu oleh PPK, Penyedia berkewajiban untuk memperbaiki atau mengganti Barang dalam jangka waktu yang ditetapkan dalam pemberitahuan tersebut.</li>
                <li class="pl-3">Jika Penyedia tidak memperbaiki atau mengganti Barang akibat cacat mutu dalam jangka waktu yang ditentukan maka PPK akan menghitung biaya perbaikan yang diperlukan, dan PPK secara langsung atau melalui pihak ketiga yang ditunjuk oleh PPK akan melakukan perbaikan tersebut. Penyedia berkewajiban untuk membayar biaya perbaikan atau penggantian tersebut sesuai dengan klaim yang diajukan secara tertulis oleh PPK. Biaya tersebut dapat dipotong oleh PPK dari nilai tagihan Penyedia.</li>
                <li class="pl-3">Terlepas dari kewajiban penggantian biaya, PPK dapat memasukkan Penyedia yang lalai memperbaiki cacat mutu ke dalam daftar hitam.</li>
            </ol >

            <div class="font-bold text-lg mt-10">17. PERUBAHAN SPK</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">SPK hanya dapat diubah melalui adendum SPK.</li>
                <li class="pl-3">Perubahan SPK bisa dilaksanakan apabila disetujui oleh para pihak, meliputi:
                    <ol class="list-decimal ml-5">
                        <li class="pl-3">perubahan pekerjaan disebabkan oleh sesuatu hal yang dilakukan oleh para pihak dalam SPK sehingga mengubah lingkup pekerjaan dalam SPK;</li>
                        <li class="pl-3">perubahan jadwal pelaksanaan pekerjaan akibat adanya perubahan pekerjaan,</li>
                        <li class="pl-3">perubahan harga SPK akibat adanya perubahan pekerjaan dan/atau perubahan pelaksanaan pekerjaan.</li>
                    </ol>
                </li>
                <li class="pl-3">Untuk kepentingan perubahan SPK, PA/KPA dapat membentuk Pejabat Peneliti Pelaksanaan Kontrak atas usul PPK.</li>
            </ol >

            <div class="break"></div>
            <div class="font-bold text-lg ">18. PERISTIWA KOMPENSASI</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Peristiwa Kompensasi dapat diberikan kepada penyedia dalam hal sebagai berikut:
                    <ol class="list-decimal ml-5">
                        <li class="pl-3">PPK mengubah jadwal yang dapat mempengaruhi pelaksanaan pekerjaan,</li>
                        <li class="pl-3">keterlambatan pembayaran kepada penyedia;</li>
                        <li class="pl-3">PPK tidak memberikan gambar-gambar, spesifikasi dan/atau instruksi sesuai jadwal yang dibutuhkan;</li>
                        <li class="pl-3">penyedia belum bisa masuk ke lokasi sesuai jadwal;</li>
                        <li class="pl-3">PPK menginstruksikan kepada pihak penyedia untuk melakukan pengujian tambahan yang setelah dilaksanakan pengujian ternyata tidak ditemukan kerusakan/kegagalan/penyimpangan;</li>
                        <li class="pl-3">PPK memerintahkan penundaan pelaksanaan pekerjaan;</li>
                        <li class="pl-3">PPK memerintahkan untuk mengatasi kondisi tertentu yang tidak dapat diduga sebelumnya dan disebabkan oleh PPK;</li>
                        <li class="pl-3">ketentuan lain dalam SPK.</li>
                    </ol>
                </li>
                <li class="pl-3">Jika Peristiwa Kompensasi mengakibatkan pengeluaran tambahan dan/atauketerlambatan penyelesaian pekerjaan maka PPK berkewajiban untuk membayar gantirugi dan/atau memberikan perpanjangan waktu penyelesaian pekerjaan.</li>
                <li class="pl-3">Ganti rugi hanya dapat dibayarkan jika berdasarkan data penunjang dan perhitungan kompensasi yang diajukan oleh penyedia kepada PPK, dapat dibuktikan kerugian nyata akibat Peristiwa Kompensasi.</li>
                <li class="pl-3">Perpanjangan waktu penyelesaian pekerjaan hanya dapat diberikan jika berdasarkan data penunjang dan perhitungan kompensasi yang diajukan oleh penyedia kepada PPK, dapat dibuktikan perlunya tambahan waktu akibat Peristiwa Kompensasi.</li>
                <li class="pl-3">Penyedia tidak berhak atas ganti rugi dan/atau perpanjangan waktu penyelesaian pekerjaan jika penyedia gagal atau lalai untuk memberikan peringatan dini dalam mengantisipasi atau mengatasi dampak Peristiwa Kompensasi.</li>
            </ol >

            <div class="font-bold text-lg mt-10">19. PERPANJANGAN WAKTU</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Jika terjadi Peristiwa Kompensasi sehingga penyelesaian pekerjaan akan melampaui Tanggal Penyelesaian maka penyedia berhak untuk meminta perpanjangan Tanggal Penyelesaian berdasarkan data penunjang. PPK berdasarkan pertimbangan Pengawas Pekerjaan memperpanjang Tanggal Penyelesaian Pekerjaan secara tertulis. Perpanjangan Tanggal Penyelesaian harus dilakukan melalui adendum SPK jika perpanjangan tersebut mengubah Masa SPK.</li>
                <li class="pl-3">PPK dapat menyetujui perpanjangan waktu pelaksanaan setelah melakukan penelitian terhadap usulan tertulis yang diajukan oleh penyedia.</li>
            </ol >
            
            <div class="font-bold text-lg mt-10">20. PENGHENTIAN DAN PEMUTUSAN SPK</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">Penghentian SPK dapat dilakukan karena pekerjaan sudah selesai atau terjadi Keadaan Kahar.</li>
                <li class="pl-3">Dalam hal SPK dihentikan, maka PPK wajib membayar kepada penyedia sesuai dengan prestasi pekerjaan yang telah dicapai, termasuk:
                    <ol class="list-decimal ml-5 break">
                        <li class="pl-3">biaya langsung pengadaan bahan dan perlengkapan untuk pekerjaan ini. Bahan dan perlengkapan ini harus diserahkan oleh Penyedia kepada PPK, dan selanjutnya menjadi hak milik PPK;</li>
                        <li class="pl-3">biaya langsung pembongkaran dan demobilisasi hasil pekerjaan sementara dan peralatan;</li>
                        <li class="pl-3">biaya langsung demobilisasi personil.</li>
                    </ol>
                </li>
                <li class="pl-3">Pemutusan SPK dapat dilakukan oleh pihak penyedia atau pihak PPK.</li>
                <li class="pl-3">Menyimpang dari Pasal 1266 dan 1267 Kitab Undang-Undang Hukum Perdata, pemutusan SPK melalui pemberitahuan tertulis dapat dilakukan apabila:
                    <ol class="list-decimal ml-5">
                        <li class="pl-3">penyedia lalai/cidera janji dalam melaksanakan kewajibannya dan tidak memperbaiki kelalaiannya dalam jangka waktu yang telah ditetapkan;</li>
                        <li class="pl-3">penyedia tanpa persetujuan Pengawas Pekerjaan, tidak memulai pelaksanaan pekerjaan;</li>
                        <li class="pl-3">penyedia menghentikan pekerjaan selama 28 (dua puluh delapan) hari dan penghentian ini tidak tercantum dalam program mutu serta tanpa persetujuan Pengawas Pekerjaan;</li>
                        <li class="pl-3">penyedia berada dalam keadaan pailit;</li>
                        <li class="pl-3">penyedia selama Masa SPK gagal memperbaiki Cacat Mutu dalam jangka waktu yang ditetapkan oleh PPK;</li>
                        <li class="pl-3">denda keterlambatan pelaksanaan pekerjaan akibat kesalahan penyedia sudah melampaui 5% (lima perseratus) dari harga SPK dan PPK menilai bahwa Penyedia tidak akan sanggup menyelesaikan sisa pekerjaan;</li>
                        <li class="pl-3">Pengawas Pekerjaan memerintahkan penyedia untuk menunda pelaksanaan atau kelanjutan pekerjaan, dan perintah tersebut tidak ditarik selama 28 (dua puluh delapan) hari;</li>
                        <li class="pl-3">PPK tidak menerbitkan SPP untuk pembayaran tagihan angsuran sesuai dengan yang disepakati sebagaimana tercantum dalam SPK;</li>
                        <li class="pl-3">penyedia terbukti melakukan KKN, kecurangan dan/atau pemalsuan dalam proses Pengadaan yang diputuskan oleh instansi yang berwenang; dan/atau</li>
                        <li class="pl-3">pengaduan tentang penyimpangan prosedur, dugaan KKN dan/atau pelanggaran persaingan sehat dalam pelaksanaan pengadaan dinyatakan benar oleh instansi yang berwenang.</li>
                    </ol>
                </li>
                <li class="pl-3">Dalam hal pemutusan SPK dilakukan karena kesalahan penyedia:
                    <ol class="list-decimal ml-5">
                        <li class="pl-3">penyedia membayar denda; dan/atau</li>
                        <li class="pl-3">penyedia dimasukkan dalam Daftar Hitam.</li>
                    </ol>
                </li>
                <li class="pl-3">Dalam hal pemutusan SPK dilakukan karena PPK terlibat penyimpangan prosedur, melakukan KKN dan/atau pelanggaran persaingan sehat dalam pelaksanaan pengadaan, maka PPK dikenakan sanksi berdasarkan peraturan perundang-undangan.</li>
            </ol >

            <div class="font-bold text-lg mt-10">21. PEMBAYARAN</div>
            <ol class="list-[lower-alpha] ml-10">
                <li class="pl-3">pembayaran prestasi hasil pekerjaan yang disepakati dilakukan oleh PPK, dengan ketentuan:
                    <ol class="list-decimal ml-5">
                        <li class="pl-3">penyedia telah mengajukan tagihan disertai laporan kemajuan hasil pekerjaan;</li>
                        <li class="pl-3">pembayaran dilakukan dengan sistem pembayaran secara sekaligus;</li>
                        <li class="pl-3">pembayaran harus dipotong denda (apabila ada), dan pajak ;</li>
                    </ol>
                </li>
                <li class="pl-3">pembayaran terakhir hanya dilakukan setelah pekerjaan selesai 100% (seratus perseratus) dan Berita Acara penyerahan pekerjaan diterbitkan.</li>
                <li class="pl-3 break">PPK dalam kurun waktu 7 (tujuh) hari kerja setelah pengajuan permintaan pembayaran dari penyedia harus sudah mengajukan surat permintaan pembayaran kepada Pejabat Penandatangan Surat Perintah Membayar (PPSPM).</li>
                <li class="pl-3">bila terdapat ketidaksesuaian dalam perhitungan angsuran, tidak akan menjadi alasan untuk menunda pembayaran. PPK dapat meminta penyedia untuk menyampaikan perhitungan prestasi sementara dengan mengesampingkan hal-hal yang sedang menjadi perselisihan.</li>
            </ol >

            <div class="font-bold text-lg mt-10">22. DENDA</div>
            <div>Penyedia berkewajiban untuk membayar sanksi finansial berupa Denda sebagai akibat mengenakan Denda dengan memotong angsuran pembayaran prestasi pekerjaan penyedia. wanprestasi atau cidera janji terhadap kewajiban-kewajiban penyedia dalam SPK ini. PPK Pembayaran Denda tidak mengurangi tanggung jawab kontraktual penyedia.</div>

            <div class="font-bold text-lg mt-10">23. PENYELESAIAN PERSELISIHAN</div>
            <div>PPK dan penyedia berkewajiban untuk berupaya sungguh-sungguh menyelesaikan secara damai semua perselisihan yang timbul dari atau berhubungan dengan SPK ini atau interpretasinya selama atau setelah pelaksanaan pekerjaan. Jika perselisihan tidak dapat diselesaikan secara musyawarah maka perselisihan akan diselesaikan melalui pengadilan negeri dalam wilayah hukum Republik Indonesia.</div>

            <div class="font-bold text-lg mt-10 ">24. LARANGAN PEMBERIAN KOMISI</div>
            <div class="mb-10">Penyedia menjamin bahwa tidak satu pun personil satuan kerja PPK telah atau akan menerima komisi atau keuntungan tidak sah lainnya baik langsung maupun tidak langsung dari SPK ini. Penyedia menyetujui bahwa pelanggaran syarat ini merupakan pelanggaran yang mendasar terhadap SPK ini.</div>
        </div>

        <div class="break"></div>
        <Kop/>
        <div class="mx-10 mb-10 text-justify">
            <div class="text-xl font-bold text-center my-10">RINGKASAN SPK</div>
            <div class="flex mt-2 ">
                <div class="font-bold">1.</div>
                <div class="ml-3 w-36 ">Nomor dan Tanggal DIPA</div>
                <div class="pl-3">: {{procurement.account}}</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">2.</div>
                <div class="ml-3 w-36">Kode MAK</div>
                <div class="pl-3">: {{procurement.contract.mak_code}}</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">3.</div>
                <div class="ml-3 w-36">Nomor dan Tanggal SPK</div>
                <!-- <div class="pl-3">: Nomor {{procurement.contract.no_spk}} Tanggal {{getDate(procurement.contract.date_start_spk)}} </div> -->
                <div class="pl-3">: Nomor {{procurement.contract.no_spk}} Tanggal {{getDate()}}</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">4.</div>
                <div class="ml-3 w-36">Nama Penyedia</div>
                <div class="pl-3">: {{procurement.suppliers.name}}</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">5.</div>
                <div class="ml-3 w-36">Alamat Penyedia</div>
                <div class="pl-3">: {{procurement.suppliers.address + ', ' + procurement.suppliers.regency + ', ' + procurement.suppliers.province}}</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">6.</div>
                <div class="ml-3 w-36 ">Uraian Pekerjaan</div>
                <div class="pl-3">: {{procurement.name}}</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">7.</div>
                <div class="ml-3 w-36">Nilai SPK</div>
                <div class="pl-3">: {{convertToRupiah(procurement.contract.offer)}}</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">8.</div>
                <div class="ml-3 w-[265px]">Cara Pembayaran</div>
                <div class="pl-3">: Pembayaran sekaligus melalui transfer ke rekening {{supplier.bank}} dengan nomer rekening {{supplier.account}} Atas Nama <span class="">{{supplier.name }}</span> </div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">9.</div>
                <div class="ml-3 w-36">Tanggal Penyelesaiaan Pekerjan</div>
                <!-- <div class="pl-3">: {{getDate(procurement.contract.date_end_spk)}})</div> -->
                <div class="pl-3">: {{getDate()}}</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">10.</div>
                <div class="ml-3 w-36">Waktu Pemeliharaan</div>
                <div class="pl-3">: -</div>
            </div>
            <div class="flex mt-2">
                <div class="font-bold">11.</div>
                <div class="ml-3 w-36 ">Ketentuan Sanksi</div>
                <div class="pl-3">: 1/1000  (satu per seribu) dari nilai bagian SPK untuk setiap hari keterlambatan</div>
            </div>
            <div class="grid place-items-end mt-14 font-bold">
                <div class="w-6/12 flex flex-col align-end text-center">
                    <div>
                        <div>Lampung Selatan, {{dateSignature()}}</div>
                        <div>a.n. Kuasa Pengguna Anggaran</div>
                        <div>Pembuat Komitmen</div>
                    </div>
                    <div>
                        <div class="mt-20">{{procurement.executor.ppk.name}}</div>
                        <div class="" >{{procurement.executor.ppk.identity_type}}. {{procurement.executor.ppk.identity_number}}</div>
                    </div>
                </div>
            </div>
        </div>
    </Cover>
</template>

<script setup>
import Cover from './Cover.vue';
import angkaTerbilang from '@develoka/angka-terbilang-js';
import moment from 'moment';
import Kop from './Kop.vue';

defineProps({
    procurement : {
        tipe : Object
    },supplier :{
        tipe: Object
    }
})

moment.updateLocale('en', {
    months : [
        "Januari", "Feruari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember"
    ],
    weekdays : [
    "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
]
});

const getDate = (date) =>{
    // return moment(date, 'YYYY-MM-DD h:mm:ss a').format('DD-MM-YYYY');
    return moment().format('DD MMMM YYYY');
}

const dateSignature = (date) => {
    // return moment(date, 'YYYY-MM-DD').format('DD MMMM YYYY')
    return moment().format('DD MMMM YYYY')
}

function convertToRupiah(angka) {
        var rupiah = "";
        var angkarev = angka.toString().split("").reverse().join("");
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
        return (
            "Rp. " +
            rupiah
                .split("", rupiah.length - 1)
                .reverse()
                .join("")
        );
    }
</script>