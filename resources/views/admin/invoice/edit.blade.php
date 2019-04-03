@extends('layouts.app')
@if($invoice->type == 'sale')
    @section('title', 'ویرایش فاکتور:' . $invoice->id .' - ')
@endif

@if($invoice->type == 'purchase')
    @section('title', 'ویرایش فاکتور:' . $invoice->id .' - ')
@endif

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ config('platform.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">مدیریت سیستم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.invoice') }}">فاکتورها</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if($invoice->type == 'sale')
                            فاکتور فروش:{{ $invoice->id }}
                        @endif

                        @if($invoice->type == 'purchase')
                                فاکتور خرید: {{ $invoice->id }}
                        @endif
                    </li>
                </ol>
            </nav>
            <div class="card card-default">
                <div class="card-header">
                    <div class="clearfix">
                        <div class="pull-right">
                            @if($invoice->type == 'sale')
                                فاکتور فروش:{{ $invoice->id }}
                            @endif

                            @if($invoice->type == 'purchase')
                                    فاکتور خرید: {{ $invoice->id }}
                            @endif
                        </div>
                        <div class="pull-left">
                            <a href="{{ route('admin.invoice') }}" class="btn btn-primary btn-sm"><i class="fa fa-step-backward"></i> بازگشت به لیست فاکتور ها</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.invoice.update',[$invoice->id]) }}"
                          onsubmit="$('.price').unmask();" id="invoice_form" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="hidden" name="type" value="{{ $invoice->type }}">
                        <input type="hidden" name="tax" id="tax_value" value="{{ \App\Utils\MoneyUtil::display($invoice->tax) }}">
                        <input type="hidden" name="discount" id="discount_value" value="{{ \App\Utils\MoneyUtil::display($invoice->discount) }}">
                        <input type="hidden" name="quantity" id="quantity_value" value="{{ \App\Utils\MoneyUtil::display($invoice->quantity) }}">
                        <input type="hidden" name="total" id="total_value" value="{{ \App\Utils\MoneyUtil::display($invoice->total) }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_id">
                                        @if($invoice->type == 'sale')
                                            مشتری
                                        @endif

                                        @if($invoice->type == 'purchase')
                                            فروشنده
                                        @endif
                                    </label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="{{ $invoice->user->id }}" selected>{{ $invoice->user->name }}</option>
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice_at">تاریخ</label>
                                    <div dir="rtl">
                                        <date-picker
                                                id="invoice_at"
                                                name="invoice_at"
                                                format="jYYYY/jMM/jDD"
                                                display-format="jYYYY/jMM/jDD"
                                                color="#6838b8"
                                                type="date"
                                                value="{{ old('invoice_at', jdate($invoice->invoice_at)->format("Y/m/d")) }}">
                                        </date-picker>
                                    </div>

                                    @if ($errors->has('invoice_at'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('invoice_at') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_at">تاریخ سرسید</label>
                                    <div dir="rtl">
                                        <date-picker
                                                id="due_at"
                                                name="due_at"
                                                format="jYYYY/jMM/jDD"
                                                display-format="jYYYY/jMM/jDD"
                                                color="#6838b8"
                                                type="date"
                                                value="{{ old('due_at', jdate($invoice->due_at)->format("Y/m/d")) }}">
                                        </date-picker>
                                    </div>

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
                                <th scope="col" class="text-center">اقدام</th>
                                <th scope="col" class="text-center">شرح کالا</th>
                                <th scope="col" class="text-center">تعداد</th>
                                <th scope="col" class="text-center">قیمت واحد</th>
                                <th scope="col" class="text-center">تخفیف</th>
                                <th scope="col" class="text-center">مالیات</th>
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
                                        <button class="btn btn-sm btn-danger" type="button" onclick="removeRecord({{$record_row}})"><i
                                                    class="fa fa-trash"></i></button>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" autocomplete="off" name="record[{{$record_row}}][title]" dir="rtl"
                                               class="typeahead form-control form-control-sm"
                                               value="{{ $record->title }}"
                                               placeholder="نام کالا یا شرح خدمات" id="record-title-{{$record_row}}" required>
                                        <input type="hidden" name="record[{{$record_row}}][product_id]"
                                               value="{{ $record->product_id }}"
                                               class="form-control form-control-sm text-center" id="record-product-id-{{$record_row}}">
                                        <input type="hidden" name="record[{{$record_row}}][record_row]"
                                               class="form-control form-control-sm text-center" value="{{$record_row}}" id="record-row-{{$record_row}}">
                                        <input type="hidden" name="record[{{$record_row}}][id]"
                                               class="form-control form-control-sm text-center" value="{{$record->id}}" id="record-id-{{$record_row}}">
                                    </td>
                                    <td class="text-center">
                                        <input type="text" autocomplete="off" name="record[{{$record_row}}][quantity]" value="{{ \App\Utils\MoneyUtil::display($record->quantity) }}"
                                               class="price form-control form-control-sm text-center" placeholder="تعداد"
                                               id="record-quantity-{{$record_row}}" dir="ltr" required>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" autocomplete="off" name="record[{{$record_row}}][price]" value="{{ \App\Utils\MoneyUtil::display($record->price) }}"
                                               class="price form-control form-control-sm text-center" placeholder="قیمت واحد"
                                               id="record-price-{{$record_row}}" dir="ltr" required>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" autocomplete="off" name="record[{{$record_row}}][discount]" value="{{ \App\Utils\MoneyUtil::display($record->discount) }}"
                                               class="price form-control form-control-sm text-center" placeholder="تخفیف"
                                               id="record-discount-{{$record_row}}" dir="ltr" required>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" autocomplete="off" name="record[{{$record_row}}][tax]" value="{{ \App\Utils\MoneyUtil::display($record->tax) }}"
                                               class="price form-control form-control-sm text-center" placeholder="مالیات"
                                               id="record-tax-{{$record_row}}" dir="ltr" required>
                                    </td>

                                    <td class="text-center">
                                        <input type="text" readonly class="price form-control form-control-sm text-center"
                                               value="{{ \App\Utils\MoneyUtil::display($record->total) }}" dir="ltr" id="record-total-{{$record_row}}">
                                    </td>
                                </tr>
                                @php
                                    $record_row++;
                                @endphp
                            @endforeach
                            </tbody>
                            <tfoot id="addRecord">
                            <tr>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" type="button" onclick="addRecord()"><i
                                                class="fa fa-plus"></i></button>
                                </td>
                                <td colspan="6">
                                    تعداد اقلام:
                                    <span id="quantity_format">{{ \App\Utils\MoneyUtil::display($invoice->quantity) }}</span>
                                </td>

                            </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <div class="alert alert-dark">
                                    تخفیف:
                                    <span id="discount_format">{{ \App\Utils\MoneyUtil::display($invoice->discount) }}</span> {{ trans('currency.'.config('platform.currency')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <div class="alert alert-dark">
                                    مالیات:
                                    <span id="tax_format">{{ \App\Utils\MoneyUtil::display($invoice->tax) }}</span> {{ trans('currency.'.config('platform.currency')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="alert alert-dark">
                                    جمع حروف:
                                    <span id="total_letters_format">{{ \App\Utils\MoneyUtil::letters($invoice->total) }}</span> {{ trans('currency.'.config('platform.currency')) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-dark">
                                    جمع عدد:
                                    <span id="total_format">{{ \App\Utils\MoneyUtil::display($invoice->total) }}</span> {{ trans('currency.'.config('platform.currency')) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="note">توضیحات</label>
                            <textarea id="note" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}"
                                      name="note">{{ old('note', $invoice->note) }}</textarea>
                            @if ($errors->has('note'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>فایل پیوست</label>
                            <input id="attachment" type="file" class="form-control{{ $errors->has('attachment') ? ' is-invalid' : '' }}" name="attachment" value="{{ old('attachment') }}">
                            @if($invoice->attachment)
                                <a href="{{ route('admin.invoice.download', [$invoice->id]) }}" class="btn btn-link">دریافت فایل پیوست</a>
                            @endif
                            @if ($errors->has('attachment'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('attachment') }}</strong>
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
<script>
    $("#user_id").select2({
        dir: "rtl",
        language: "fa",
        ajax: {
            url: "{{ route('admin.ajax.users') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term, // search term
                };
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.data, function(item) {
                        if(item.title) {
                            return { id: item.id, text: item.first_name + ' ' + item.last_name + '(' + item.title + ')' };
                        } else {
                            return { id: item.id, text: item.first_name + ' ' + item.last_name };
                        }

                    })
                };
            },
            cache: true
        },
        placeholder: 'جستجوی شخص',
        minimumInputLength: 3,
    });

    var record_row = {{ $record_row }};

    function addRecord() {
        html = '<tr class="record" id="record-' + record_row + '">';
        html += '<td class="text-center">';
        html += '<button class="btn btn-sm btn-danger" type="button" onclick="removeRecord(' + record_row + ')"><i class="fa fa-trash"></i></button>';
        html += '</td>';
        html += '<td class="text-center">';
        html += '<input type="text" autocomplete="off" dir="rtl" name="record[' + record_row + '][title]" class="typeahead form-control form-control-sm" placeholder="نام کالا یا شرح خدمات" id="record-title-' + record_row + '" required>';
        html += '<input type="hidden" name="record[' + record_row + '][record_row]" class="form-control form-control-sm text-center" value="' + record_row + '" id="record-row-' + record_row + '">';
        html += '<input type="hidden" name="record[' + record_row + '][product_id]" class="form-control form-control-sm text-center" id="record-product-id-' + record_row + '">';
        html += '</td>';
        html += '<td class="text-center">';
        html += '<input type="tel" dir="ltr" autocomplete="off" name="record[' + record_row + '][quantity]" value="" class="price form-control form-control-sm text-center" placeholder="تعداد" id="record-quantity-' + record_row + '" required>';
        html += '</td>';
        html += '<td class="text-center">';
        html += '<input type="tel" dir="ltr" autocomplete="off" name="record[' + record_row + '][price]" value="" class="price form-control form-control-sm text-center" placeholder="قیمت واحد" id="record-price-' + record_row + '" required>';
        html += '</td>';


        html += '<td class="text-center">';
        html += '<input type="tel" dir="ltr" autocomplete="off" name="record[' + record_row + '][discount]" value="" class="price form-control form-control-sm text-center" placeholder="تخفیف" id="record-discount-' + record_row + '">';
        html += '</td>';


        html += '<td class="text-center">';
        html += '<input type="tel" dir="ltr" autocomplete="off" name="record[' + record_row + '][tax]" value="" class="price form-control form-control-sm text-center" placeholder="مالیات" id="record-tax-' + record_row + '">';
        html += '</td>';



        html += '<td class="text-center"><input type="tel" dir="ltr" readonly class="price form-control form-control-sm text-center" id="record-total-' + record_row + '"></td>';
        html += '</tr>';
        $('#records').append(html);
        record_row++;
        $('.price').mask('#,##0', {reverse: true});
    }

    function removeRecord(row_id) {
        if($('#record-id-'+row_id).val()) {
            axios.post('{{ route('admin.invoice.delete-record') }}', {
                id: $('#record-id-'+row_id).val(),
                invoice_id: '{{$invoice->id}}'
            }).then(function (response) {
                $('#record-'+row_id).remove();
                calculateTotal();
            }).catch(function (error) {
                alert(error);
            });
        } else {
            $('#record-'+row_id).remove();
            calculateTotal();
        }
    }

    function calculateTotal()
    {
        $.ajax({
            url: '{{ route('admin.invoice.calculate-total') }}',
            type: 'POST',
            dataType: 'JSON',
            data: $('#invoice_form input[type=\'text\'],#invoice_form input[type=\'hidden\'],#invoice_form input[type=\'tel\']'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if (data) {
                    $.each(data.record_total, function (key, value) {
                        $('#record-total-' + key).val(value);
                    });

                    $('#total_format').html(data.total_format);
                    $('#total_value').val(data.total_value);
                    $('#total_letters_format').html(data.total_letters_format);
                    $('#discount_format').html(data.discount_format);
                    $('#discount_value').val(data.discount_value);
                    $('#tax_format').html(data.tax_format);
                    $('#tax_value').val(data.tax_value);
                    $('#quantity_format').html(data.quantity_format);
                    $('#quantity_value').val(data.quantity_value);

                }
            }
        });
    }

    var timer = null;
    $('#invoice_form').keydown(function(){
        clearTimeout(timer);
        timer = setTimeout(calculateTotal, 1000)
    });



    $('.typeahead').autocomplete({
        serviceUrl: '{{ route('admin.invoice.items') }}',
        minChars: 2,
        showNoSuggestionNotice: true,
        noSuggestionNotice: 'کالایی با این نام وجود ندارد.',
        onSelect: function (suggestion) {
            var input_id = this.id.split('-');
            var row_id = parseInt(input_id[input_id.length-1]);
            $('#record-product-id-'+row_id).val(suggestion.id);
            $('#record-price-'+row_id).val(suggestion.price);
            $('#record-tax-'+row_id).val(suggestion.tax);
            $('#record-discount-'+row_id).val(suggestion.discount);
            calculateTotal();
            $('.price').mask('#,##0', {reverse: true});
        }
    });
</script>
@endsection
