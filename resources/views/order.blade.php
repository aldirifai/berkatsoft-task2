@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row m-1">
                            <div class="col-md-6">
                                <h3>Data Penjualan</h3>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#tambahData">
                                    <i class="fas fa-plus"></i>
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered" id="data">
                            <thead>
                                <tr class="text-center">
                                    <th>Nomor Invoice</th>
                                    <th>Nama Customer</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->invoice_number }}</td>
                                        <td>{{ $order->customer->name }}</td>
                                        <td>{{ $order->order_date }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-info text-white" data-bs-toggle="modal"
                                                data-bs-target="#viewData" onclick="lihatData(`{{ $order }}`)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form class="d-inline" action="{{ route('order.destroy', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="button"
                                                    onclick="fungsiHapus(this.form)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="total_price" id="total_price" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="customer" class="form-label">Nama Customer</label>
                            <input class="form-control" list="customer_list" id="customer" placeholder="Type to search...">
                            <datalist id="customer_list">
                                @foreach ($customers as $customer)
                                    <option data-value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="customer_id" id="customer-hidden">
                        </div>
                        <div class="mb-3">
                            <label for="order_date" class="form-label">Tanggal Pembelian</label>
                            <input type="date" class="form-control" id="order_date" name="order_date"
                                date-format="yyyy-mm-dd">
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label class="form-label col">Detail Order</label>
                            <div class="col">
                                <button type="button" class="btn btn-success btn-sm float-end" id="tambah_detail_product"><i
                                        class="fas fa-plus"></i> Tambah</button>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga Satuan</th>
                                        <th width="10%">Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tempat_detail">
                                    <tr class="baris_detail">
                                        <td>
                                            <select class="form-select jenis" name="product_id[]">
                                                <option value="">Pilih Produk</option>
                                                @foreach ($products as $produk)
                                                    <option value="{{ $produk->id }}|{{ $produk->price }}">
                                                        {{ $produk->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <input type="number" class="form-control banyaknya" name="banyaknya[]">
                                        </td>
                                        <td class="price">

                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm hapusfile"><i
                                                    class="fas fa-trash"></i> Hapus</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th id="jumlahtext">

                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewData" tabindex="-1" aria-labelledby="viewDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDataLabel">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body m-3">
                        <h4 class="text-center">Invoice Transaksi</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-3">Nomor Invoice</div>
                                    <div style="flex: 0 0 auto;width:3%">:</div>
                                    <div class="col" id="dt_invoice"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3">Nama Customer</div>
                                    <div style="flex: 0 0 auto;width:3%">:</div>
                                    <div class="col" id="dt_name"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3">Tanggal Transaksi</div>
                                    <div style="flex: 0 0 auto;width:3%">:</div>
                                    <div class="col" id="dt_date"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row table-responsive mt-3">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga Satuan</th>
                                        <th width="10%">Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="detail_order">

                                </tbody>
                                <tbody>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th id="total_order">

                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="tutup-view">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editData" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataLabel">Ubah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="total_price" id="total_price" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Nama Produk</label>
                            <select class="form-select" name="product_id" id="edt_product_id">
                                <option value="">Pilih Produk</option>
                                @foreach ($products as $produk)
                                    <option value="{{ $produk->id }}|{{ $produk->price }}">
                                        {{ $produk->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edt_quantity" class="form-label">Kuantitas</label>
                            <input type="number" class="form-control" name="quantity" id="edt_quantity">
                        </div>
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total</label>
                            <input disabled class="form-control" name="total_price" id="edt_total_price">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#data').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                order: []
            });
        });

        function lihatData(data) {
            var data = JSON.parse(data);

            $('#dt_invoice').text(data.invoice_number);
            $('#dt_name').text(data.customer.name);
            $('#dt_date').text(data.order_date);
            $('#total_order').text(rupiah(data.total_price));

            $('#detail_order').html('');

            console.log(data.order_details);
            $.each(data.order_details, function(index, value) {
                var link = "{{ url('order-detail') }}/" + value.id;
                var data_edit = value.id + "|"  +value.product_id + "|" +value.product.price+ "|" + value.quantity;
                console.log(data_edit);
                $('#detail_order').append(
                    '<tr>' +
                    '<td>' + value.product.name + '</td>' +
                    '<td>' + rupiah(value.product.price) + '</td>' +
                    '<td>' + value.quantity + '</td>' +
                    '<td>' + rupiah(value.total_price) + '</td>' +
                    `<td class="text-center">
                        <button type="button" class="btn btn-warning" onclick="ubahData('`+data_edit+`')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form class="d-inline" action="`+link+`" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="button"
                                onclick="fungsiHapus(this.form)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>` +
                    '</tr>'
                );
            });
        }

        document.querySelector('input[list]').addEventListener('input', function(e) {
            var input = e.target,
                list = input.getAttribute('list'),
                options = document.querySelectorAll('#' + list + ' option'),
                hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
                inputValue = input.value;

            hiddenInput.value = inputValue;

            for (var i = 0; i < options.length; i++) {
                var option = options[i];

                if (option.innerText === inputValue) {
                    hiddenInput.value = option.getAttribute('data-value');
                    break;
                }
            }
        });

        function ubahData(data) {
            $('#tutup-view').click();

            var data = data.split('|');
            var link = "{{ url('order-detail') }}/" + data[0];
            $('#editData form').attr('action', link);
            $('#edt_product_id').val(data[1]+"|"+data[2]);
            $('#editData form input[name="quantity"]').val(data[3]);
            $('#edt_total_price').val(data[2] * data[3]);

            var myModal = new bootstrap.Modal(document.getElementById("editData"), {});
            myModal.show();
        }

        $('#edt_product_id').change(function() {
            var product_id = $(this).val().split('|');
            var quantity = $('#edt_quantity').val();
            var total_price = product_id[1] * quantity;
            $('#edt_total_price').val(total_price);
        });

        $('#edt_quantity').change(function() {
            var product_id = $('#edt_product_id').val().split('|');
            var quantity = $(this).val();
            var total_price = product_id[1] * quantity;
            $('#edt_total_price').val(total_price);
        });
    </script>

    <script>
        function calc_total() {
            var sum = 0;
            $(".price").each(function() {
                sum += parseFloat($(this).text().replace(/\D/g,''));
            });
            // $('#jumlah').val(sum);
            if(!isNaN(sum)){
                $('#jumlahtext').text(rupiah(sum));
                $('#total_price').val(sum);
            }
        }

        function rupiah(angka) {
            if (typeof angka !== 'undefined') {
            var bilangan = angka;

            var reverse = bilangan.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');

            return 'Rp. ' + ribuan;
            } else {
                return '';
            }
        }

        $('select.jenis').on('change', function() {
            var data = $(this).val();
            var isidata = data.split('|');
            var product_id = isidata[0];
            var harga_satuan = isidata[1];

            $(this).parents('td').next().text(rupiah(harga_satuan));

            var $tr = $(this).closest('tr');
            var banyaknya = $tr.find('input.banyaknya').val();

            if(banyaknya != '') {
                var total = banyaknya * harga_satuan;
                $tr.find('td:nth-child(4)').text(rupiah(total));
                calc_total();
            } else {
                $tr.find('input.banyaknya').val(0);
                $tr.find('td:nth-child(4)').text(rupiah(0));
                calc_total();
            }
        }).change();

        $('input.banyaknya').on('change', function() {
            var $tr = $(this).closest('tr');
            var jenis = $tr.find('td:first-child').text();
            var harga_satuan = $tr.find('td:nth-child(2)').text().replace(/\D/g,'');

            var banyaknya = $(this).val();
            var sub_total = harga_satuan * banyaknya;

            $(this).parents('td').next().text(rupiah(sub_total));
            calc_total();
        }).change();

        $('#tambah_detail_product').click(function(e) {
            e.preventDefault();

            $("#tempat_detail").append(`<tr class="baris_detail">
											<td>
												<select class="form-select jenis" name="product_id[]">
													<option value="">Pilih Produk</option>
            @foreach ($products as $produk)
                                                    <option value="{{ $produk->id }}|{{ $produk->price }}">
                                                        {{ $produk->name }}</option>
                                                @endforeach
												</select>
											</td>
											<td>

											</td>
											<td>
												<input type="number" class="form-control banyaknya" name="banyaknya[]">
											</td>
											<td class="price">

											</td>
											<td>
												<button type="button" class="btn btn-danger btn-sm hapusfile"><i class="fas fa-trash"></i> Hapus</button>
											</td>
										</tr>`);

            $(".hapusfile").click(function() {
                $(this).closest('.baris_detail').remove();
                calc_total();
            });

            $('select.jenis').on('change', function() {
                var data = $(this).val();
                var isidata = data.split('|');
                var product_id = isidata[0];
                var harga_satuan = isidata[1];

                $(this).parents('td').next().text(rupiah(harga_satuan));

                var $tr = $(this).closest('tr');
                var banyaknya = $tr.find('input.banyaknya').val();

                if(banyaknya != '') {
                    var total = banyaknya * harga_satuan;
                    $tr.find('td:nth-child(4)').text(rupiah(total));
                    calc_total();
                } else {
                    $tr.find('input.banyaknya').val(0);
                    $tr.find('td:nth-child(4)').text(rupiah(0));
                    calc_total();
                }
            }).change();

            $('input.banyaknya').on('change', function() {
                var $tr = $(this).closest('tr');
                var jenis = $tr.find('td:first-child').text();
                var harga_satuan = $tr.find('td:nth-child(2)').text().replace(/\D/g,'');

                var banyaknya = $(this).val();
                var sub_total = harga_satuan * banyaknya;

                $(this).parents('td').next().text(rupiah(sub_total));
                calc_total();
            }).change();
        });
    </script>
@endsection
