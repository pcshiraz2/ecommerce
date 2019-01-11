@extends('layouts.app')
@if($invoice->type == 'sale')
    @section('title', 'ویرایش فاکتور ' . $invoice->id .' - ')
@endif

@if($invoice->type == 'purchase')
    @section('title', 'ویرایش فاکتور ' . $invoice->id .' - ')
@endif

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@latest/dist/css/persian-datepicker.min.css"/>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-{{ config('platform.sidebar-size') }}">
            @include('admin.sidebar')
        </div>
        <div class="col-md-{{ config('platform.content-size') }}">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">مدیریت سیستم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.invoice') }}">فاکتورها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if($invoice->type == 'sale')
                            فاکتور فروش {{ $invoice->id }}
                        @endif

                        @if($invoice->type == 'purchase')
                            فاکتور خرید {{ $invoice->id }}
                        @endif
                    </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">
                    @if($invoice->type == 'sale')
                        فاکتور فروش {{ $invoice->id }}
                    @endif

                    @if($invoice->type == 'purchase')
                        فاکتور خرید {{ $invoice->id }}
                    @endif
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.invoice.update',[$invoice->id]) }}"
                          onsubmit="$('.price').unmask();" id="invoice_form">
                        @csrf
                        @method('post')
                        <input type="hidden" name="type" value="{{ $invoice->type }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">
                                        @if($invoice->type == 'sale')
                                            مشتری
                                        @endif

                                        @if($invoice->type == 'purchase')
                                            فروشنده
                                        @endif
                                    </label>
                                    <select name="user_id" id="user_id" class="form-control" required autofocus>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"{{ old('user_id',$invoice->user_id) == $user->id  ? ' selected' : '' }}>{{$user->name}}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice_at">تاریخ</label>
                                    <input dir="ltr" id="invoice_at" autocomplete="off"
                                           value="{{ old('invoice_at', jdate($invoice->invoice_at)->format('Y/m/d')) }}"
                                           data-date="{{ old('invoice_at', jdate($invoice->invoice_at)->format('Y/m/d')) }}"
                                           placeholder="____/__/__" type="text"
                                           class="invoice_at date form-control{{ $errors->has('invoice_at') ? ' is-invalid' : '' }}"
                                           name="invoice_at" value="{{ old('invoice_at') }}" required>

                                    @if ($errors->has('invoice_at'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('invoice_at') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="period">دوره زمانی</label>
                                    <input id="period" autocomplete="off" placeholder="به روز" type="number"
                                           class="form-control{{ $errors->has('period') ? ' is-invalid' : '' }}"
                                           name="period" value="{{ old('period',$invoice->period) }}">
                                    @if ($errors->has('period'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('period') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_at">تاریخ سرسید</label>
                                    <input dir="ltr" id="due_at" autocomplete="off"
                                           value="{{ old('due_at', jdate($invoice->due_at)->format('Y/m/d')) }}"
                                           data-date="{{ old('due_at', jdate($invoice->invoice_at)->format('Y/m/d')) }}"
                                           placeholder="____/__/__" type="text"
                                           class="due_at date form-control{{ $errors->has('due_at') ? ' is-invalid' : '' }}"
                                           name="due_at" value="{{ old('due_at') }}">

                                    @if ($errors->has('due_at'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('due_at') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center"></th>
                                <th scope="col" class="text-center">شرح کالا</th>
                                <th scope="col" class="text-center">تعداد</th>
                                <th scope="col" class="text-center">قیمت واحد</th>
                                <th scope="col" class="text-center">مبلغ کل</th>
                            </tr>
                            </thead>
                            <tbody id="records">
                            @php
                                $record_row = 0;
                            @endphp
                            @foreach($invoice->records as $record)
                                <tr id="record-{{$record_row}}" class="record">
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger" type="button"
                                                onclick="removeRecord({{$record_row}})"><i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" autocomplete="off"
                                               name="record[{{$record_row}}][description]"
                                               value="{{$record->description}}" dir="rtl"
                                               class="typeahead form-control form-control-sm"
                                               placeholder="نام کالا یا شرح خدمات"
                                               id="record-description-{{$record_row}}" required>
                                        <input type="hidden" name="record[{{$record_row}}][item_id]"
                                               value="{{$record->item_id}}"
                                               class="form-control form-control-sm text-center"
                                               id="record-item-id-{{$record_row}}">
                                        <input type="hidden" name="record[{{$record_row}}][id]"
                                               class="form-control form-control-sm text-center" value="{{$record_row}}"
                                               id="record-id-{{$record_row}}">
                                        <input type="hidden" name="record[{{$record_row}}][record_id]"
                                               class="form-control form-control-sm text-center" value="{{$record->id}}"
                                               id="old-record-id-{{$record_row}}">
                                    </td>
                                    <td class="text-center">
                                        <input type="text" autocomplete="off" name="record[{{$record_row}}][quantity]"
                                               value="{{ abs($record->quantity) }}"
                                               class="form-control form-control-sm text-center" placeholder="تعداد"
                                               id="record-quantity-{{$record_row}}" required>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" autocomplete="off" name="record[{{$record_row}}][price]"
                                               value="{{$record->price}}"
                                               class="form-control form-control-sm text-center" placeholder="قیمت واحد"
                                               id="record-price-{{$record_row}}" required>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" readonly value="{{$record->total}}"
                                               class="form-control form-control-sm text-center"
                                               id="record-total-{{$record_row}}">
                                    </td>
                                </tr>
                                @php
                                    $record_row++;
                                @endphp
                            @endforeach
                            </tbody>
                            <tfoot id="addRecord">
                            <tr>
                                <th scope="col" class="text-center">
                                    <button class="btn btn-sm btn-primary" type="button" onclick="addRecord()"><i
                                                class="fa fa-plus"></i></button>
                                </th>
                                <th scope="col" class="text-left" colspan="3">مجموع:</th>
                                <th scope="col" class="text-center">
                                    <input type="text" readonly
                                           value="{{ $invoice->total + $invoice->discount - $invoice->tax }}"
                                           name="sub_total" id="sub_total"
                                           class="form-control form-control-sm text-center" required>
                                </th>

                            </tr>
                            <tr>
                                <th scope="col" class="text-left" colspan="3">تخفیف:</th>
                                <th scope="col" class="text-center">
                                    <input type="text" autocomplete="off" name="discount_percent" id="discount_percent"
                                           class="form-control form-control-sm text-center" placeholder="درصد تخفیف">
                                </th>
                                <th scope="col" class="text-center">
                                    <input type="text" autocomplete="off" value="{{ $invoice->discount }}"
                                           name="discount" id="discount"
                                           class="form-control form-control-sm text-center" required>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-left" colspan="3">مالیات:</th>
                                <th scope="col" class="text-left">
                                    <input type="text" autocomplete="off" name="tax_percent" id="tax_percent"
                                           class="form-control form-control-sm text-center" placeholder="درصد مالیات">
                                </th>
                                <th scope="col" class="text-center">
                                    <input type="text" autocomplete="off" value="{{ $invoice->tax }}" name="tax"
                                           id="tax" class="form-control form-control-sm text-center" required>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-right" colspan="3">جمع حروف:
                                    <span id="total_letters">{{ number_to_letters($invoice->total) }} تومان</span>
                                </th>
                                <th scope="col" class="text-left">جمع کل:</th>
                                <th scope="col" class="text-center"><input type="text" id="total" name="total"
                                                                           value="{{ $invoice->total }}" readonly
                                                                           class="form-control form-control-sm text-center"
                                                                           id="record-0-total" required></th>
                            </tr>
                            </tfoot>
                        </table>

                        <div class="form-group">
                            <label for="note">توضیحات</label>
                            <textarea id="note" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}"
                                      name="note" value="{{ old('note') }}"></textarea>
                            @if ($errors->has('note'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm" value="save">
                            <i class="fa fa-save"></i>
                            ذخیره فاکتور
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://unpkg.com/persian-date@latest/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker@latest/dist/js/persian-datepicker.min.js"></script>

    <script>

        var record_row = '{{ $record_row }}';
        $(function () {
            $('.price').mask('#,##0', {reverse: true});
            $('.date').mask('0000/00/00');
            $(".invoice_at").persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValueType: 'persian',
                autoClose: true,
                persianDigit: false
            });
            $(".due_at").persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValueType: 'persian',
                minDate: new persianDate().unix(),
                autoClose: true,
                persianDigit: false
            });
        });

        function addRecord() {
            html = '<tr class="record" id="record-' + record_row + '">';
            html += '<td class="text-center">';
            html += '<button class="btn btn-sm btn-danger" type="button" onclick="removeRecord(' + record_row + ')"><i class="fa fa-trash"></i></button>';
            html += '</td>';
            html += '<td class="text-center">';
            html += '<input type="text" autocomplete="off" dir="rtl" name="record[' + record_row + '][description]" class="typeahead form-control form-control-sm" placeholder="نام کالا یا شرح خدمات" id="record-description-' + record_row + '" required>';
            html += '<input type="hidden" name="record[' + record_row + '][id]" class="form-control form-control-sm text-center" value="' + record_row + '" id="record-id-' + record_row + '">';
            html += '<input type="hidden" name="record[' + record_row + '][item_id]" class="form-control form-control-sm text-center" id="record-item-id-' + record_row + '">';
            html += '</td>';
            html += '<td class="text-center">';
            html += '<input type="text" autocomplete="off" name="record[' + record_row + '][quantity]" value="" class="form-control form-control-sm text-center" placeholder="تعداد" id="record-quantity-' + record_row + '" required>';
            html += '</td>';
            html += '<td class="text-center">';
            html += '<input type="text" autocomplete="off" name="record[' + record_row + '][price]" value="" class="form-control form-control-sm text-center" placeholder="قیمت واحد" id="record-price-' + record_row + '" required>';
            html += '</td>';
            html += '<td class="text-center"><input type="text" readonly class="form-control form-control-sm text-center" id="record-total-' + record_row + '"></td>';
            html += '</tr>';
            $('#records').append(html);
            makeAutoItems();
            record_row++;
        }

        function removeRecord(row_id) {
            if ($('#old-record-id-' + row_id).val()) {
                axios.post('{{ route('admin.invoice.delete-record') }}', {
                    id: $('#old-record-id-' + row_id).val(),
                    invoice_id: '{{$invoice->id}}'
                }).then(function (response) {
                    $('#record-' + row_id).remove();
                    calculateTotal();
                }).catch(function (error) {
                    alert(error);
                });
            } else {
                $('#record-' + row_id).remove();
                calculateTotal();
            }
        }

        function calculateTotal() {
            $.ajax({
                url: '{{ route('admin.invoice.calculate-total') }}',
                type: 'POST',
                dataType: 'JSON',
                data: $('#invoice_form input[type=\'text\'],#invoice_form input[type=\'hidden\']'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data) {
                        $.each(data.record_total, function (key, value) {
                            $('#record-total-' + key).val(value);
                        });
                        $('#sub_total').val(data.sub_total);
                        $('#total').val(data.total);
                        $('#total_letters').html(data.total_letters);
                        if (data.tax_percent) {
                            $('#tax').val(data.tax);
                        }
                        if (data.discount_percent) {
                            $('#discount').val(data.discount);
                        }
                    }
                }
            });
        }

        $(document).on('change', '#invoice_form', function () {
            calculateTotal();
        });

        $(document).on('keyup', '#invoice_form .form-control', function () {
            calculateTotal();
        });


        function makeAutoItems() {
            $(".typeahead").autocomplete({
                source: "{{route('admin.invoice.items')}}",
                select: function (event, item) {
                    var input_id = event.target.id.split('-');
                    var row_id = parseInt(input_id[input_id.length - 1]);
                    $('#record-item-id-' + row_id).val(item.item.id);

                    $('#record-price-' + row_id).val(item.item.sale_price);

                }
            });
        }

        makeAutoItems();

    </script>
@endsection
