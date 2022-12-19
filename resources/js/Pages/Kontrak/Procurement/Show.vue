<template>
    <Show :procurement=procurement >
        <template #file>
            <a v-show="procurement.hps_submitted" :href="route('kontrak.document.boq',procurement.id)" class="btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">Lihat BOQ</a>
        </template>
        <template #amount>
            <Container>
                <Label value="Nilai Penawaran" />
                <p class="font-bold text-lg tracking-wider">{{ convertToRupiah(procurement.contract.offer) }}</p>
            </Container>
        </template>
        <template #extra-info={loading}>
            <div class="flex gap-4 mt-10">
            <Container >
                <div >
                    <Header1 title="Data Supplier" widthSize="60" />
                    <Label value="Nama" class="mt-5"/>
                    <p class="font-bold text-lg tracking-wider mb-3">
                        <span >{{procurement.suppliers.entity}}. {{procurement.suppliers.name}}</span>
                    </p>
                    <Label value="NPWP" class="mt-5"/>
                    <p class="font-bold text-lg tracking-wider mb-3">
                        <span >{{procurement.suppliers.npwp}}</span>
                    </p>
                    <Label value="Alamat" />
                    <p class="font-bold text-lg tracking-wider mb-3">
                        <span >{{procurement.suppliers.address + ', ' + procurement.suppliers.regency + ', ' + procurement.suppliers.province}}</span>
                    </p>
                    <Label value="Rekening" />
                    <p class="font-bold text-lg tracking-wider mb-3">
                        <span >{{procurement.suppliers.bank}} {{procurement.suppliers.account}}</span>
                    </p>
                </div>
            </Container>
            <Container>
                <Header1 title="File Kontrak" widthSize="60" />
                <div class="grid grid-rows-4 grid-flow-col gap-x-3">
                    <div v-if="procurement.estimate.total >= 50000000">
                        <!--SPPBJ-->
                        <a v-if="procurement.contract.file_sppbj" :href="procurement.contract.file_sppbj" class="mt-3 w-full btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">SPPBJ</a>
                        <a v-else-if="procurement.contract.no_sppbj" :href="route('kontrak.document.sppbj',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">SPPBJ</a>
                        <!-- The button to open modal -->
                        <label v-else for="sppbj" class="mt-3 btn w-full border-first modal-button bg-first">Buat SPPBJ</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="sppbj" class="modal-toggle" v-model="sppbj.modal" />
                            <label for="sppbj" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="sppbj" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Surat Penunjukan Penyedia Barang/Jasa" :widthSize="100" />
                                
                                <Label value="Nomor SPPBJ" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="sppbj.no_sppbj"
                                :status="sppbj.errors.no_sppbj"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="sppbj.errors.no_sppbj">{{ sppbj.errors.no_sppbj }}</div>
                                
                                <Label value="Prihal" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="sppbj.purpose_sppbj"
                                :status="sppbj.errors.purpose_sppbj"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="sppbj.errors.purpose_sppbj">{{ sppbj.errors.purpose_sppbj }}</div>

                                <Label value="Tanggal SPPBJ" />
                                <Datepicker 
                                    v-model="sppbj.date_sppbj" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="sppbj.errors.date_sppbj">{{ sppbj.errors.date_sppbj }}</div>
                                <div class="flex justify-center my-5">
                                    <button @click="createsppbj(procurement.id, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Buat</button>
                                </div>
                            </label>
                        </label>
                        <!-- EndSPPBJ-->
                    </div>

                    <!-- SPK -->
                    <div v-if="procurement.contract.no_sppbj && procurement.estimate.total >= 50000000">
                        <a v-if="procurement.contract.file_spk" :href="procurement.contract.file_spk" class="mt-3 w-full btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">SPK</a>
                        <a v-else-if="procurement.contract.no_spk" :href="route('kontrak.document.spk',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">SPK</a>
                        <!-- The button to open modal -->
                        <label v-else for="spk" class="btn w-full mt-3 border-first modal-button bg-first">Buat SPK</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="spk" class="modal-toggle" v-model="spk.modal" />
                            <label for="spk" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="spk" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Surat Perintah Kerja" :widthSize="100" />
                                <Label value="Nomor SPK" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="spk.no_spk"
                                :status="spk.errors.no_spk"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="spk.errors.no_spk">{{ spk.errors.no_spk }}</div>

                                <Label value="Kode MAK" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="spk.mak_code"
                                :status="spk.errors.mak_code"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="spk.errors.mak_code">{{ spk.errors.mak_code }}</div>

                                <!-- <div class="divider my-10"></div> -->
                                <Label value="Masa Kerja" class="mt-5" />
                                <div class="font-bold mb-5">{{spk.days}} hari kalender</div>
                                <!-- <Input
                                type="number"
                                class="mt-1 block w-full"
                                v-model="spk.days"
                                @input="e => convert(e.target.value)"
                                /> -->
                                <!-- @input="e => workEnd(spk.start, e.target.value)" -->
                                <div class="grid grid-flow-row-dense grid-cols-2 grid-rows-2 gap-x-4">
                                    <Label value="Tanggal Mulai" />
                                    <Label value="Tanggal Selesai" class="pb-0 mb-0" />
                                    <!-- {
                                        format: 'DD-MM-YYYY'
                                    } -->
                                    <Datepicker 
                                        v-model="spk.start" 
                                        :enableTimePicker="false"  
                                        @update:modelValue="convert(spk.days)"
                                        format='dd-MM-yyyy'
                                        selectText="Pilih"
                                        cancelText="Batal"
                                    />
                                    <div v-if="spk.end" >{{spk.end}}</div>
                                    <div v-else class="text-secondary font-bold" >Atur Tanggal Mulai</div>
                                    <div class="text-sm text-error mt-1 mb-4" v-if="spk.errors.end">{{ spk.errors.end }}</div>
                                </div>
                                <div class="flex justify-center my-5">
                                    <button @click="createspk(procurement.id, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Buat</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End SPK -->

                    <!-- End SPP/SPMK -->
                    <div v-if="procurement.contract.no_spk || procurement.estimate.total <= 50000000">
                        <a v-if="procurement.contract.file_sp" :href="procurement.contract.file_sp" class="mt-3 w-full btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">{{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</a>
                        <a v-else-if="procurement.contract.no_sp" :href="route('kontrak.document.sp',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">{{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</a>
                        <!-- The button to open modal -->
                        <label v-else for="sp" class="btn w-full mt-3 border-first modal-button bg-first">Buat {{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="sp" class="modal-toggle" v-model="sp.modal" />
                            <label for="sp" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="sp" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 :title="procurement.category == 'Barang' ? 'Surat Perintah Pengiriman' : 'Surat Perintah Mulai Kerja'"   :widthSize="100" />
                                <Label value="Nomor" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="sp.no_sp"
                                :status="sp.errors.no_sp"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="sp.errors.no_sp">{{ sp.errors.no_sp }}</div>
                                
                                <Label :value="'Tanggal ' + procurement.category == 'Barang' ? 'SPP' : 'SPMK'"  />
                                <Datepicker 
                                    v-model="sp.date_sp" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="sp.errors.date_sp">{{ sp.errors.date_sp }}</div>

                                <div v-if="procurement.estimate.total <= 50000000">
                                    <Label value="Masa Kerja" class="mt-5" />
                                    <div class="font-bold mb-5">{{sp.days}} hari kalender</div>
                                    <div class="grid grid-flow-row-dense grid-cols-2 grid-rows-2 gap-x-4">
                                        <Label value="Tanggal Mulai" />
                                        <Label value="Tanggal Selesai" class="pb-0 mb-0" />
                                        <Datepicker 
                                            v-model="sp.start" 
                                            :enableTimePicker="false"  
                                            @update:modelValue="convert2(sp.days)"
                                            format='dd-MM-yyyy'
                                            selectText="Pilih"
                                            cancelText="Batal"
                                        />
                                        <div v-if="sp.end" >{{sp.end}}</div>
                                        <div v-else class="text-secondary font-bold" >Atur Tanggal Mulai</div>
                                        <div class="text-sm text-error mt-1 mb-4" v-if="sp.errors.end">{{ sp.errors.end }}</div>
                                    </div>
                                </div>
                                <div class="flex justify-center my-5">
                                    <button @click="createsp(procurement.id, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Buat {{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End SPP/SPMK -->

                </div>
            </Container>
            <Container v-if="procurement.contract.no_sp">
                <Header1 title="Berita Acara" widthSize="60" />
                <div class="grid grid-rows-4 grid-flow-col gap-x-3">
                    <!-- BAP -->
                    <div v-if="procurement.contract.no_sp">
                        <a v-if="procurement.contract.file_bap" :href="procurement.contract.file_bap" class="mt-3 w-full btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">BAP</a>
                        <a v-else-if="procurement.contract.no_bap" :href="route('kontrak.document.bap',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAP</a>
                        <!-- The button to open modal -->
                        <label v-else for="bap" class="btn w-full mt-3 border-first modal-button bg-first">Buat BAP</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="bap" class="modal-toggle" v-model="bap.modal" />
                            <label for="bap" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="bap" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Berita Acara Hasil Pemeriksaan" :widthSize="100" />
                                <Label value="Nomor" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="bap.no_bap"
                                :status="bap.errors.no_bap"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="bap.errors.no_bap">{{ bap.errors.no_bap }}</div>
                                
                                <Label value="Tanggal" />
                                <Datepicker 
                                    v-model="bap.date_bap" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="bap.errors.date_bap">{{ bap.errors.date_bap }}</div>
                                
                                <div class="flex justify-center my-5">
                                    <button @click="createbap(procurement.id, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Buat BAP</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End BAP -->

                    <!-- BAST -->
                    <div v-if="procurement.contract.no_bap">
                        <a v-if="procurement.contract.file_bastp" :href="procurement.contract.file_bastp" class="mt-3 w-full btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">BAST</a>
                        <a v-else-if="procurement.contract.no_bastp" :href="route('kontrak.document.bastp',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BAST</a>
                        <!-- The button to open modal -->
                        <label v-else for="bastp" class="btn w-full mt-3 border-first modal-button bg-first">Buat BAST</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="bastp" class="modal-toggle" v-model="bastp.modal" />
                            <label for="bastp" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="bastp" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Berita Acara Serah Terima" :widthSize="100" />
                                
                                <Label value="Nomor" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="bastp.no_bastp"
                                :status="bastp.errors.no_bastp"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="bastp.errors.no_bastp">{{ bastp.errors.no_bastp }}</div>
                                
                                <Label value="Tanggal" />
                                <Datepicker 
                                    v-model="bastp.date_bastp" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="bastp.errors.date_bastp">{{ bastp.errors.date_bastp }}</div>
                                <div class="flex justify-center my-5">
                                    <button @click="createbastp(procurement.id)" class="btn border-first bg-first mt-5 tracking-wide" >Buat</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End BAST -->

                    <!-- BP -->
                    <div v-if="procurement.contract.no_bastp">
                        <a v-if="procurement.contract.file_bp" :href="procurement.contract.file_bp" class="mt-3 w-full btn text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold">BP</a>
                        <a v-else-if="procurement.contract.no_bp" :href="route('kontrak.document.bp',procurement.id)" class="mt-3 btn text-first w-full btn-outline font-bold hover:bg-first hover:text-white hover:border-none" target="_blank">BP</a>
                        <!-- The button to open modal -->
                        <label v-else for="bp" class="btn w-full mt-3 border-first modal-button bg-first">Buat BP</label>
    
                            <!-- Put this part before </body> tag -->
                            <input type="checkbox" id="bp" class="modal-toggle" v-model="bp.modal" />
                            <label for="bp" class="modal cursor-pointer">
                            <label class="modal-box relative" for="">
                                <label for="bp" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                                <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                                <Header1 title="Berita Acara Pembayaran" :widthSize="100" />
                                <Label value="Nomor" class="mt-10" />
                                <Input
                                type="text"
                                class="mt-1 block w-full"
                                v-model="bp.no_bp"
                                :status="bp.errors.no_bp"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="bp.errors.no_bp">{{ bp.errors.no_bp }}</div>
                                <Label value="Tanggal" />
                                <Datepicker 
                                    v-model="bp.date_bp" 
                                    :enableTimePicker="false"  
                                    format='dd-MM-yyyy'
                                    selectText="Pilih"
                                    cancelText="Batal"
                                />
                                <div class="text-sm text-error mt-1 mb-4" v-if="bp.errors.date_bp">{{ bp.errors.date_bp }}</div>
                                <div class="flex justify-center my-5">
                                    <button @click="createbp(procurement.id)" class="btn border-first bg-first mt-5 tracking-wide" >Buat</button>
                                </div>
                            </label>
                        </label>
                    </div>
                    <!-- End BAST -->
                </div>
            </Container>
            <div  v-if="((!procurement.contract.file_sppbj || !procurement.contract.file_spk) && procurement.estimate.total >= 50000000) || (!procurement.contract.file_sp || !procurement.contract.file_bap || !procurement.contract.file_bastp || !procurement.contract.file_bp)">
                <Container v-if="procurement.contract.no_sppbj || procurement.contract.no_sp">
                    <Header1 title="Berkas Fisik" widthSize="60" />
    
                    <!-- SPPBJ -->
                    <label v-if="!procurement.contract.file_sppbj && procurement.estimate.total >= 50000000" for="fileSPK" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah SPPBJ</label>
                    <input type="checkbox" id="fileSPK" class="modal-toggle" v-model="file.modal1" />
                    <label for="fileSPK" class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label for="fileSPK" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                            <Header1 title="Unggah File SPPBJ" widthSize="100" />
                            <label class="block mb-3 mt-10">
                                <span class="sr-only">Pilih File</span>
                                <input type="file" class=" block w-full text-sm text-first
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-slate-200 file:text-first
                                hover:file:bg-slate-300"
                                accept=".pdf"
                                @input="(e) => onInputChangeFile(e)"
                            />
                        </label>
                        <div class="text-sm text-error mt-1 mb-5">{{ file.errors.file }}</div>
                            <div class="flex justify-center my-5">
                                <button @click="uploadFile(procurement.id, procurement.name, 7, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                            </div>
                        </label>
                    </label>
                    <!-- END of SPPBJ -->
    
                    <!-- SPK -->
                    <label v-if="!procurement.contract.file_spk && procurement.contract.no_spk && procurement.estimate.total >= 50000000" for="fileSPK" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah SPK</label>
                    <input type="checkbox" id="fileSPK" class="modal-toggle" v-model="file.modal2" />
                    <label for="fileSPK" class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label for="fileSPK" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                            <Header1 title="Unggah File SPK" widthSize="100" />
                            <label class="block mb-3 mt-10">
                                <span class="sr-only">Pilih File</span>
                                <input type="file" class=" block w-full text-sm text-first
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-slate-200 file:text-first
                                hover:file:bg-slate-300"
                                accept=".pdf"
                                @input="(e) => onInputChangeFile(e)"
                            />
                        </label>
                        <div class="text-sm text-error mt-1 mb-5">{{ file.errors.file }}</div>
                            <div class="flex justify-center my-5">
                                <button @click="uploadFile(procurement.id, procurement.name, 8, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                            </div>
                        </label>
                    </label>
                    <!-- END of SPK -->
    
                    <!-- SP -->
                    <label v-if="!procurement.contract.file_sp && procurement.contract.no_sp" for="fileSP" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah {{procurement.category == 'Barang' ? 'SPP' : 'SPMK'}}</label>
                    <input type="checkbox" id="fileSP" class="modal-toggle" v-model="file.modal3" />
                    <label for="fileSP" class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label for="fileSP" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                            <Header1 title="Unggah File SP" widthSize="100" />
                            <label class="block mb-3 mt-10">
                                <span class="sr-only">Pilih File</span>
                                <input type="file" class=" block w-full text-sm text-first
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-slate-200 file:text-first
                                hover:file:bg-slate-300"
                                accept=".pdf"
                                @input="(e) => onInputChangeFile(e)"
                            />
                        </label>
                        <div class="text-sm text-error mt-1 mb-5">{{ file.errors.file }}</div>
                            <div class="flex justify-center my-5">
                                <button @click="uploadFile(procurement.id, procurement.name, 9, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                            </div>
                        </label>
                    </label>
                    <!-- END of SP -->
    
                    <!-- BAP -->
                    <label v-if="!procurement.contract.file_bap && procurement.contract.no_bap" for="fileBAP" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah BAP</label>
                    <input type="checkbox" id="fileBAP" class="modal-toggle" v-model="file.modal4" />
                    <label for="fileBAP" class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label for="fileBAP" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                            <Header1 title="Unggah File BAP" widthSize="100" />
                            <label class="block mb-3 mt-10">
                                <span class="sr-only">Pilih File</span>
                                <input type="file" class=" block w-full text-sm text-first
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-slate-200 file:text-first
                                hover:file:bg-slate-300"
                                accept=".pdf"
                                @input="(e) => onInputChangeFile(e)"
                            />
                        </label>
                        <div class="text-sm text-error mt-1 mb-5">{{ file.errors.file }}</div>
                            <div class="flex justify-center my-5">
                                <button @click="uploadFile(procurement.id, procurement.name, 10, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                            </div>
                        </label>
                    </label>
                    <!-- END of BAP -->
    
                    <!-- BAST -->
                    <label v-if="!procurement.contract.file_bastp && procurement.contract.no_bastp" for="fileBAST" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah BAST</label>
                    <input type="checkbox" id="fileBAST" class="modal-toggle" v-model="file.modal5" />
                    <label for="fileBAST" class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label for="fileBAST" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                            <Header1 title="Unggah File BAST" widthSize="100" />
                            <label class="block mb-3 mt-10">
                                <span class="sr-only">Pilih File</span>
                                <input type="file" class=" block w-full text-sm text-first
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-slate-200 file:text-first
                                hover:file:bg-slate-300"
                                accept=".pdf"
                                @input="(e) => onInputChangeFile(e)"
                            />
                        </label>
                        <div class="text-sm text-error mt-1 mb-5">{{ file.errors.file }}</div>
                            <div class="flex justify-center my-5">
                                <button @click="uploadFile(procurement.id, procurement.name, 11, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                            </div>
                        </label>
                    </label>
                    <!-- END of BAST -->
    
                    <!-- BP -->
                    <label v-if="!procurement.contract.file_bp && procurement.contract.no_bp" for="fileBp" class="btn w-full  mt-3 border-first modal-button bg-first">Unggah BP</label>
                    <input type="checkbox" id="fileBp" class="modal-toggle" v-model="file.modal6" />
                    <label for="fileBp" class="modal cursor-pointer">
                        <label class="modal-box relative" for="">
                            <label for="fileBp" class="btn btn-xs border-first bg-first btn-circle absolute right-2 top-2">✕</label>
                            <!-- <Header1 title="Setujui HPS" class="my-12" :widhSize=50 /> -->
                            <Header1 title="Unggah File BP" widthSize="100" />
                            <label class="block mb-3 mt-10">
                                <span class="sr-only">Pilih File</span>
                                <input type="file" class=" block w-full text-sm text-first
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-slate-200 file:text-first
                                hover:file:bg-slate-300"
                                accept=".pdf"
                                @input="(e) => onInputChangeFile(e)"
                            />
                        </label>
                        <div class="text-sm text-error mt-1 mb-5">{{ file.errors.file }}</div>
                            <div class="flex justify-center my-5">
                                <button @click="uploadFile(procurement.id, procurement.name, 12, loading)" class="btn border-first bg-first mt-5 tracking-wide" >Unggah</button>
                            </div>
                        </label>
                    </label>
                    <!-- END of BP -->
                </Container>
            </div>
            </div>
        </template>

    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";
import Label from '@/Components/utils/Label.vue';
import Input from '@/Components/utils/Input.vue';
import Header1 from "@/Components/utils/Header1.vue";
import { Link,useForm } from '@inertiajs/inertia-vue3'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Container from "@/Components/utils/Container.vue";
import moment from 'moment';
import Notification from "@/Components/composables/Notification"

const toast = Notification()
const props = defineProps({
	procurement: { type: Object, required: true },
})

const cek = () =>{
    console.log("masuk")
}

const sppbj = useForm({
    status          : 1,
    no_sppbj        : "",
    purpose_sppbj   : "",
    date_sppbj      : null,
    modal           : 0,
    _method         : 'patch',
})

const spk = useForm({
    status      : 2,
    no_spk      : "",
    mak_code    : "",
    start       : null,
    days        : props.procurement.contract.days,
    end         : null,
    modal       : 0,
    _method     : 'patch',
})

const bastp = useForm({
    status      : 3,
    no_bastp    : "",
    date_bastp  : null,
    modal       : 0,
    _method     : 'patch',
})

const bap = useForm({
    status      : 4,
    no_bap      : "",
    date_bap    : null,
    modal       : 0,
    _method     : 'patch',
})

const sp = useForm({
    status      : 5,
    no_sp       : "",
    paket_sp    : "",
    date_sp     : null,
    start       : null,
    days        : props.procurement.contract.days,
    end         : null,
    modal       : 0,
    _method     : 'patch',
})

const bp = useForm({
    status      : 6,
    no_bp    : "",
    date_bp  : null,
    modal       : 0,
    _method     : 'patch',
})

const file = useForm({
    status : null,
    file   : null,
    modal1  : 0,
    modal2  : 0,
    modal3  : 0,
    modal4  : 0,
    modal5  : 0,
    modal6  : 0,
    _method     : 'patch',
})

const uploadFile = (id, name, status, loading) =>{
    const type = {
        7: "SPPBJ",
        8: "SPMK",
        9: "SPK",
        10: "BAP",
        11: "BAST",
        12: "BP",
    }
    file.status = status
    file.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil unggah file '+ type[status] +" "+  name),
            file.reset()
        },
        onError:    (e) => {toast('error', 'Gagal unggah file '+ type[status] +" "+  name); console.log(e)},
        onStart     :   ()  => loading(),
        onFinish    :   ()  => loading(),
    })
}

const createbp = (id) =>{
    bp.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil membuat BP')
            bp.reset()
        },
        onError:    (e) => {console.log(e); toast('error', 'Gagal membuat BP')}
    })
}

const createsppbj = (id) =>{
    sppbj.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil membuat SPPBJ')
            sppbj.reset()
        },
        onError:    (e) => {console.log(e); toast('error', 'Gagal membuat BP')}
    })
}

const createspk = (id) =>{
    spk.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil membuat SPK')
            spk.reset()
        },
        onError:    (e) => {console.log(e); toast('error', 'Gagal membuat SPK')}
    })
}

const createbastp = (id) =>{
    bastp.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil membuat BAST')
            bastp.reset()
        },
        onError:    (e) => {console.log(e); toast('error', 'Gagal membuat BAST')}
    })
}

const createbap = (id) =>{
    bap.post(route("kontrak.procurement.update", id),{
        onSuccess:  (e) => {
            toast('success', 'Berhasil membuat BAP')
            bap.reset()
        },
        onError:    (e) => {console.log(e); toast('error', 'Gagal membuat BAP')}
    })
}

const createsp = (id) =>{
        sp.post(route("kontrak.procurement.update", id),{
            onSuccess:  (e) => {
                toast('success', 'Berhasil membuat SP')
                sp.reset()
            },
            onError:    (e) => {console.log(e); toast('error', 'Gagal membuat SP')}
        })
}

const convert = (days) => {
    const x     = moment(spk.start , 'MM-DD-YYYY').add(days, 'days').format('DD-MM-YYYY'); 
    spk.days    = days;
    spk.end     = x;
}

const convert2 = (days) => {
    const x     = moment(sp.start , 'MM-DD-YYYY').add(days, 'days').format('DD-MM-YYYY'); 
    sp.days    = days;
    sp.end     = x;
}

function convertToRupiah (angka) {
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

function onInputChangeFile(e) {
    file.file = e.target.files
}
</script>