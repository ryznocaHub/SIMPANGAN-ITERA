<Container
                    class="ml-5 card border-2 bg-grey-50 border-dashed border-gray-600 p-5 w-1/3"
                >
                    <span class="h3 text-xl font-extrabold tracking-wider flex">
                        Data HPS 
                        <div v-if="hps.total == 0"></div>
                        <span v-else-if="hps.total > x.itemPreview['total']" class="tooltip tooltip-bottom flex text-sm align-bottom text-secondary" data-tip="Lebih mahal dari harga RAB">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up text-secondary ml-3 mr-1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                            {{convertToRupiah(hps.total - x.itemPreview['total'])}}
                        </span>
                        <span v-else-if="hps.total < x.itemPreview['total']" class="tooltip tooltip-bottom flex text-sm align-bottom text-first" data-tip="Lebih murah dari harga RAB">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down text-first ml-3 mr-1" ><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
                            {{convertToRupiah(x.itemPreview['total'] - hps.total) }}
                        </span>
                    </span>
                    <div class="divider"></div>
                    <div class="flex flex-wrap">
                        <div class="flex flex-col basis-1/2 pr-5">
                            <Label value="Harga Satuan" />
                            <Input
                                id="price"
                                type="number"
                                class="mt-1 block w-full"
                                v-model.number="hps.price"
                                min="1000"
                                @change="total()"
                                placeholder="Harga Satuan"
                                required
                            />
                        </div>
                        <div class="flex flex-col">
                            <Label value="Jumlah" />
                            <p class="font-bold text-lg tracking-wider">
                                {{ x.itemPreview['unit'] }} Unit
                            </p>
                        </div>
                        <div class="flex flex-col basis-1/2 mt-5">
                            <Label value="Total" />
                            <p class="font-bold text-lg tracking-wider">
                                {{ convertToRupiah(hps.unit*hps.price) }}
                            </p>
                        </div>
                    </div>
                    <Label value="Sumber" class="mt-5" />
                    <Input
                        class="w-full"
                        type="text"
                        v-model="hps.source"
                    />
                    <div class="flex justify-between">
                        <a v-show="hps.source" class=" hover:bg-none text-xs text-first underline underline-offset-8 " id="visit" :href="hps.source" target="_blank">
                            Kunjungi Sumber
                        </a>
                        <button
                            v-if="hps.total != 0 && hps.source != ''"
                            class="btn btn-xs text-white bg-first border-none  font-bold"
                            id="use"
                            @click="verifikasi()"
                        >
                            Verifikasi
                        </button>
                        <button
                            class="btn btn-xs text-first bg-slate-200 border-none hover:text-white hover:bg-first font-bold"
                            id="use"
                            @click="useRAB()"
                        >
                            Gunakan Sumber RAB
                        </button>
                    </div>
                </Container>